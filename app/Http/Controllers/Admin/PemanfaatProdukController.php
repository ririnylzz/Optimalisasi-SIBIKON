<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PemanfaatProduk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PemanfaatProdukController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $search = trim((string) $request->query('search', ''));
        $tahunFilter = trim((string) $request->query('tahun_anggaran', ''));
        $perPage = (int) $request->query('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }

        $query = PemanfaatProduk::query()->active();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_bangunan', 'like', "%{$search}%")
                    ->orWhere('pengelola_pemilik_bangunan', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('kabupaten', 'like', "%{$search}%")
                    ->orWhere('provinsi', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('nama_pengelola_pemilik', 'like', "%{$search}%")
                    ->orWhere('tahun_anggaran', 'like', "%{$search}%")
                    ->orWhere('kontak', 'like', "%{$search}%");
            });
        }

        if ($tahunFilter !== '') {
            $query->where('tahun_anggaran', $tahunFilter);
        }

        $pemanfaatProduks = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $tahunOptions = PemanfaatProduk::query()
            ->active()
            ->whereNotNull('tahun_anggaran')
            ->select('tahun_anggaran')
            ->distinct()
            ->orderByDesc('tahun_anggaran')
            ->pluck('tahun_anggaran');

        $editingPemanfaatProduk = null;

        if ($request->filled('edit')) {
            $editingPemanfaatProduk = PemanfaatProduk::query()
                ->active()
                ->find($request->query('edit'));
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.pemanfaat-produk.partials.table', [
                    'pemanfaatProduks' => $pemanfaatProduks,
                    'search' => $search,
                    'tahunFilter' => $tahunFilter,
                    'perPage' => $perPage,
                ])->render(),
            ]);
        }

        return view('admin.pemanfaat-produk.index', [
            'pemanfaatProduks' => $pemanfaatProduks,
            'search' => $search,
            'tahunFilter' => $tahunFilter,
            'perPage' => $perPage,
            'tahunOptions' => $tahunOptions,
            'editingPemanfaatProduk' => $editingPemanfaatProduk,
        ]);
    }

    public function pemanfaatProdukPublik(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $perPage = (int) $request->query('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }

        $pemanfaatProduks = PemanfaatProduk::query()
            ->active()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('nama_bangunan', 'like', "%{$search}%")
                        ->orWhere('pengelola_pemilik_bangunan', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%")
                        ->orWhere('kabupaten', 'like', "%{$search}%")
                        ->orWhere('provinsi', 'like', "%{$search}%")
                        ->orWhere('lokasi', 'like', "%{$search}%")
                        ->orWhere('nama_pengelola_pemilik', 'like', "%{$search}%")
                        ->orWhere('tahun_anggaran', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.layanan.pemanfaat-produk', [
            'pemanfaatProduks' => $pemanfaatProduks,
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        PemanfaatProduk::query()->create($this->validatedData($request));

        return redirect()
            ->route('admin.pemanfaat-produk')
            ->with('success', 'Data pemanfaat produk berhasil ditambahkan.');
    }

    public function update(Request $request, PemanfaatProduk $pemanfaatProduk): RedirectResponse
    {
        $pemanfaatProduk->update($this->validatedData($request));

        return redirect()
            ->route('admin.pemanfaat-produk')
            ->with('success', 'Data pemanfaat produk berhasil diperbarui.');
    }

    public function destroy(PemanfaatProduk $pemanfaatProduk): RedirectResponse
    {
        $pemanfaatProduk->update([
            'is_deleted' => true,
        ]);

        return redirect()
            ->route('admin.pemanfaat-produk')
            ->with('success', 'Data pemanfaat produk berhasil dihapus.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || count($ids) === 0) {
            return redirect()
                ->route('admin.pemanfaat-produk')
                ->with('error', 'Pilih minimal satu data untuk dihapus.');
        }

        PemanfaatProduk::query()
            ->whereIn('id', $ids)
            ->update([
                'is_deleted' => true,
            ]);

        return redirect()
            ->route('admin.pemanfaat-produk')
            ->with('success', 'Data pemanfaat produk terpilih berhasil dihapus.');
    }

    public function destroyAll(): RedirectResponse
    {
        PemanfaatProduk::query()
            ->active()
            ->update([
                'is_deleted' => true,
            ]);

        return redirect()
            ->route('admin.pemanfaat-produk')
            ->with('success', 'Semua data pemanfaat produk berhasil dihapus.');
    }

    public function import(Request $request): RedirectResponse
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $request->validate([
            'file_import' => ['required', 'file', 'mimes:csv,txt,xlsx', 'max:10240'],
        ], [
            'file_import.required' => 'File import wajib dipilih.',
            'file_import.mimes' => 'File harus berformat CSV, TXT, atau XLSX.',
            'file_import.max' => 'Ukuran file maksimal 10MB.',
        ]);

        $file = $request->file('file_import');
        $extension = strtolower($file->getClientOriginalExtension());

        $rows = $extension === 'xlsx'
            ? $this->readXlsxRows($file->getRealPath())
            : $this->readCsvRows($file->getRealPath());

        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($rows as $row) {
            $data = $this->normalizeImportRow($row);

            if (blank($data['nama_bangunan'])) {
                $skipped++;
                continue;
            }

            $record = PemanfaatProduk::query()
                ->where('nama_bangunan', $data['nama_bangunan'])
                ->where('alamat', $data['alamat'])
                ->where('kabupaten', $data['kabupaten'])
                ->where('provinsi', $data['provinsi'])
                ->first();

            if ($record) {
                $record->update(array_merge($data, [
                    'is_deleted' => false,
                ]));

                $updated++;
                continue;
            }

            PemanfaatProduk::query()->create(array_merge($data, [
                'is_deleted' => false,
            ]));

            $created++;
        }

        return redirect()
            ->route('admin.pemanfaat-produk')
            ->with('success', "Import selesai. {$created} data baru, {$updated} data diperbarui, {$skipped} data dilewati.");
    }

    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'nama_bangunan' => ['required', 'string', 'max:255'],
            'pengelola_pemilik_bangunan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'kabupaten' => ['required', 'string', 'max:255'],
            'provinsi' => ['required', 'string', 'max:255'],
            'nama_pengelola_pemilik' => ['required', 'string', 'max:255'],
            'tahun_anggaran' => ['required', 'integer', 'digits:4', 'min:1900', 'max:' . ((int) date('Y') + 5)],
            'kontak' => ['required', 'regex:/^[0-9]+$/', 'max:20'],
        ], [
            'nama_bangunan.required' => 'Nama bangunan wajib diisi.',
            'pengelola_pemilik_bangunan.required' => 'Pengelola/Pemilik bangunan wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kabupaten.required' => 'Kabupaten/Kota wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'nama_pengelola_pemilik.required' => 'Nama pengelola/pemilik wajib diisi.',
            'tahun_anggaran.required' => 'Tahun anggaran wajib diisi.',
            'tahun_anggaran.integer' => 'Tahun anggaran harus berupa angka.',
            'tahun_anggaran.digits' => 'Tahun anggaran harus 4 digit.',
            'kontak.required' => 'Kontak wajib diisi.',
            'kontak.regex' => 'Kontak hanya boleh diisi angka.',
        ]);

        $validated['lokasi'] = collect([
            $validated['alamat'] ?? null,
            $validated['kabupaten'] ?? null,
            $validated['provinsi'] ?? null,
        ])->filter()->implode(', ');

        return $validated;
    }

    private function readCsvRows(string $path): array
    {
        $handle = fopen($path, 'rb');

        if ($handle === false) {
            return [];
        }

        $headers = fgetcsv($handle);

        if ($headers === false) {
            fclose($handle);
            return [];
        }

        $headers = array_map(fn ($header) => $this->normalizeHeader((string) $header), $headers);

        $rows = [];

        while (($line = fgetcsv($handle)) !== false) {
            $row = [];

            foreach ($headers as $index => $header) {
                $row[$header] = $line[$index] ?? null;
            }

            if (collect($row)->filter(fn ($value) => !blank($value))->isNotEmpty()) {
                $rows[] = $row;
            }
        }

        fclose($handle);

        return $rows;
    }

    private function readXlsxRows(string $path): array
    {
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $rawRows = $sheet->toArray(null, true, true, true);

        if (count($rawRows) < 2) {
            return [];
        }

        $headerRow = array_shift($rawRows);
        $headers = [];

        foreach ($headerRow as $column => $header) {
            $headers[$column] = $this->normalizeHeader((string) $header);
        }

        $rows = [];

        foreach ($rawRows as $rawRow) {
            $row = [];

            foreach ($headers as $column => $header) {
                $row[$header] = $rawRow[$column] ?? null;
            }

            if (collect($row)->filter(fn ($value) => !blank($value))->isNotEmpty()) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    private function normalizeHeader(string $header): string
    {
        return Str::of($header)
            ->lower()
            ->replace(['/', '-', '.', '(', ')'], ' ')
            ->squish()
            ->replace(' ', '_')
            ->toString();
    }

    private function normalizeImportRow(array $raw): array
    {
        $alamat = $this->firstValue($raw, [
            'alamat',
            'alamat_bangunan',
            'lokasi',
            'lokasi_bangunan',
        ]);

        $kabupaten = $this->firstValue($raw, [
            'kabupaten',
            'kota',
            'kabupaten_kota',
            'kab_kota',
            'kab',
        ]);

        $provinsi = $this->firstValue($raw, [
            'provinsi',
            'province',
        ]);

        return [
            'nama_bangunan' => $this->firstValue($raw, [
                'nama_bangunan',
                'bangunan',
                'nama',
            ]),
            'pengelola_pemilik_bangunan' => $this->firstValue($raw, [
                'pengelola_pemilik_bangunan',
                'pengelola_bangunan',
                'pemilik_bangunan',
                'pengelola_pemilik',
            ]),
            'lokasi' => collect([
                $alamat,
                $kabupaten,
                $provinsi,
            ])->filter()->implode(', '),
            'alamat' => $alamat,
            'kabupaten' => $kabupaten,
            'provinsi' => $provinsi,
            'nama_pengelola_pemilik' => $this->firstValue($raw, [
                'nama_pengelola_pemilik',
                'nama_pengelola',
                'nama_pemilik',
            ]),
            'tahun_anggaran' => $this->firstValue($raw, [
                'tahun_anggaran',
                'tahun',
                'ta',
            ]),
            'kontak' => $this->firstValue($raw, [
                'kontak',
                'no_telp',
                'telp',
                'telepon',
                'nomor_telepon',
                'hp',
            ]),
        ];
    }

    private function firstValue(array $row, array $keys): ?string
    {
        foreach ($keys as $key) {
            $normalizedKey = $this->normalizeHeader($key);

            if (array_key_exists($normalizedKey, $row) && !blank($row[$normalizedKey])) {
                return trim((string) $row[$normalizedKey]);
            }
        }

        return null;
    }
}