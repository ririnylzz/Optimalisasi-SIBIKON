<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RantaiPasok;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RantaiPasokController extends Controller
{
    public function rantaiPasok()
    {
        $rantaiPasoks = RantaiPasok::query()
            ->where('is_deleted', 0)
            ->paginate(10);

        return view(
            'pages.fungsi.pengaturan.rantai-pasok',
            compact('rantaiPasoks')
        );
    }

    public function index(Request $request): View|JsonResponse
    {
        $search = trim((string) $request->query('search', ''));
        $bidangFilter = $request->query('bidang_usaha');
        $regencyFilter = $request->query('kabupaten');
        $perPage = (int) $request->query('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }

        $query = RantaiPasok::query()->active();

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('bidang_usaha', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('kabupaten', 'like', "%{$search}%")
                    ->orWhere('provinsi', 'like', "%{$search}%")
                    ->orWhere('kontak', 'like', "%{$search}%");
            });
        }

        if (!blank($bidangFilter)) {
            $query->where('bidang_usaha', $bidangFilter);
        }

        if (!blank($regencyFilter)) {
            $query->where('kabupaten', $regencyFilter);
        }

        $rantaiPasoks = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $bidangOptions = RantaiPasok::query()
            ->active()
            ->whereNotNull('bidang_usaha')
            ->where('bidang_usaha', '<>', '')
            ->distinct()
            ->orderBy('bidang_usaha')
            ->pluck('bidang_usaha');

        $regencyFilterOptions = RantaiPasok::query()
            ->active()
            ->whereNotNull('kabupaten')
            ->where('kabupaten', '<>', '')
            ->distinct()
            ->orderBy('kabupaten')
            ->pluck('kabupaten');

        $editingRantaiPasok = null;

        if ($request->filled('edit')) {
            $editingRantaiPasok = RantaiPasok::query()
                ->active()
                ->find($request->query('edit'));
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.rantai-pasok.partials.table', compact(
                    'rantaiPasoks',
                    'search',
                    'bidangFilter',
                    'regencyFilter',
                    'perPage',
                ))->render(),
            ]);
        }

        return view('admin.rantai-pasok.index', compact(
            'rantaiPasoks',
            'search',
            'bidangFilter',
            'regencyFilter',
            'perPage',
            'bidangOptions',
            'regencyFilterOptions',
            'editingRantaiPasok',
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        RantaiPasok::query()->create($this->validatedData($request));

        return redirect()
            ->route('admin.rantai-pasok')
            ->with('success', 'Data rantai pasok berhasil ditambahkan.');
    }

    public function update(Request $request, RantaiPasok $rantaiPasok): RedirectResponse
    {
        $rantaiPasok->update($this->validatedData($request));

        return redirect()
            ->route('admin.rantai-pasok')
            ->with('success', 'Data rantai pasok berhasil diperbarui.');
    }

    public function destroy(RantaiPasok $rantaiPasok): RedirectResponse
    {
        $rantaiPasok->update(['is_deleted' => true]);

        return redirect()
            ->route('admin.rantai-pasok')
            ->with('success', 'Data rantai pasok berhasil dihapus.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return redirect()
                ->route('admin.rantai-pasok')
                ->with('error', 'Tidak ada data yang dipilih.');
        }

        RantaiPasok::query()
            ->whereIn('id', $ids)
            ->update(['is_deleted' => true]);

        return redirect()
            ->route('admin.rantai-pasok')
            ->with('success', 'Data rantai pasok terpilih berhasil dihapus.');
    }

    public function destroyAll(): RedirectResponse
    {
        RantaiPasok::query()
            ->active()
            ->update(['is_deleted' => true]);

        return redirect()
            ->route('admin.rantai-pasok')
            ->with('success', 'Semua data rantai pasok berhasil dihapus.');
    }

    public function import(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'file_import' => ['required', 'file', 'mimes:csv,txt,xlsx', 'max:10240'],
        ], [
            'file_import.required' => 'File import wajib dipilih.',
            'file_import.mimes' => 'File harus berformat CSV atau XLSX.',
        ]);

        $file = $validated['file_import'];
        $extension = strtolower($file->getClientOriginalExtension());

        $rows = $extension === 'xlsx'
            ? $this->readXlsxRows($file->getRealPath())
            : $this->readCsvRows($file->getRealPath());

        if (count($rows) < 2) {
            return redirect()
                ->route('admin.rantai-pasok', ['panel' => 'upload'])
                ->with('error', 'File import kosong atau tidak memiliki data.');
        }

        $header = collect($rows[0])
            ->map(fn($value) => $this->normalizeHeader($value))
            ->all();

        $created = 0;
        $updated = 0;
        $skipped = 0;

        DB::beginTransaction();

        try {
            foreach (array_slice($rows, 1) as $row) {
                $raw = [];

                foreach ($header as $index => $field) {
                    if ($field) {
                        $raw[$field] = $row[$index] ?? null;
                    }
                }

                $record = $this->normalizeImportRow($raw);

                if (blank($record['nama'])) {
                    $skipped++;
                    continue;
                }

                $existing = RantaiPasok::query()
                    ->where('nama', $record['nama'])
                    ->when(!blank($record['kabupaten']), fn($query) => $query->where('kabupaten', $record['kabupaten']))
                    ->first();

                if ($existing) {
                    $existing->fill($record + ['is_deleted' => false]);
                    $existing->save();
                    $updated++;
                    continue;
                }

                RantaiPasok::query()->create($record + ['is_deleted' => false]);
                $created++;
            }

            DB::commit();

            return redirect()
                ->route('admin.rantai-pasok')
                ->with('success', "Import berhasil. Created: {$created}, updated: {$updated}, skipped: {$skipped}.");
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.rantai-pasok', ['panel' => 'upload'])
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'bidang_usaha' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'kabupaten' => ['nullable', 'string', 'max:255'],
            'provinsi' => ['nullable', 'string', 'max:255'],
            'kontak' => ['nullable', 'string', 'max:255'],
        ]);
    }

    private function readCsvRows(string $path): array
    {
        $rows = [];
        $handle = fopen($path, 'r');

        if (!$handle) {
            return $rows;
        }

        while (($data = fgetcsv($handle, 0, ',')) !== false) {
            $rows[] = $data;
        }

        fclose($handle);

        return $rows;
    }

    private function readXlsxRows(string $path): array
    {
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();

        return $sheet->toArray(null, true, true, false);
    }

    private function normalizeHeader(mixed $value): ?string
    {
        $normalized = Str::of((string) $value)
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/i', '_')
            ->trim('_')
            ->toString();

        return $normalized === '' ? null : $normalized;
    }

    private function normalizeImportRow(array $raw): array
    {
        return [
            'nama' => $this->firstValue($raw, ['nama', 'nama_perusahaan', 'nama_badan_usaha', 'perusahaan']),
            'bidang_usaha' => $this->firstValue($raw, ['bidang_usaha', 'bidang', 'jenis_usaha', 'usaha']),
            'alamat' => $this->firstValue($raw, ['alamat', 'alamat_usaha']),
            'kabupaten' => $this->firstValue($raw, ['kabupaten', 'kabupaten_kota', 'kab_kota', 'kota']),
            'provinsi' => $this->firstValue($raw, ['provinsi', 'propinsi']),
            'kontak' => $this->firstValue($raw, ['kontak', 'no_telp', 'telp', 'telepon', 'nomor_telepon', 'hp']),
            
        ];
    }

    private function firstValue(array $raw, array $keys): ?string
    {
        foreach ($keys as $key) {
            if (!blank($raw[$key] ?? null)) {
                return trim((string) $raw[$key]);
            }
        }

        return null;
    }
}
