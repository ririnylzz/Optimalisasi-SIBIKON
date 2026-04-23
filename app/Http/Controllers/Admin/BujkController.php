<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Bujk\BujkFormRequest;
use App\Http\Requests\Admin\Bujk\BujkImportRequest;
use App\Models\Bujk;
use App\Services\Bujk\BujkImportService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class BujkController extends Controller
{
    public function index(Request $request)
    {
        $perPage = in_array((int) $request->integer('per_page'), [10, 25, 50, 100], true)
            ? (int) $request->integer('per_page')
            : 10;

        $search = trim((string) $request->string('search'));
        $jenisFilter = trim((string) $request->string('jenis'));

        $baseQuery = Bujk::query()->active();
        $filteredQuery = (clone $baseQuery);

        if ($search !== '') {
            $filteredQuery->where(function (Builder $query) use ($search): void {
                $query->where('nib', 'like', '%' . $search . '%')
                    ->orWhere('nama_bujk', 'like', '%' . $search . '%')
                    ->orWhere('npwp_bujk', 'like', '%' . $search . '%')
                    ->orWhere('alamat_bujk', 'like', '%' . $search . '%')
                    ->orWhere('kab_kota_bujk', 'like', '%' . $search . '%')
                    ->orWhere('provinsi_bujk', 'like', '%' . $search . '%')
                    ->orWhere('telp_bujk', 'like', '%' . $search . '%')
                    ->orWhere('email_bujk', 'like', '%' . $search . '%');
            });
        }

        if ($jenisFilter !== '') {
            $this->applyJenisFilter($filteredQuery, $jenisFilter);
        }

        $bujks = $filteredQuery
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        $editingBujk = $request->filled('edit')
            ? Bujk::query()->active()->findOrFail((int) $request->query('edit'))
            : null;

        $stats = [
            'total_data' => (clone $baseQuery)->count(),
            'total_email' => (clone $baseQuery)->whereNotNull('email_bujk')->where('email_bujk', '!=', '')->count(),
            'total_website' => (clone $baseQuery)->whereNotNull('website_bujk')->where('website_bujk', '!=', '')->count(),
            'hasil_filter' => $bujks->total(),
        ];

        return view('admin.bujk.index', [
            'bujks' => $bujks,
            'editingBujk' => $editingBujk,
            'regions' => config('bujk.regions', []),
            'jenisOptions' => config('bujk.jenis_usaha', []),
            'stats' => $stats,
            'search' => $search,
            'jenisFilter' => $jenisFilter,
            'perPage' => $perPage,
        ]);
    }

    public function store(BujkFormRequest $request): RedirectResponse
    {
        $payload = $request->validated();
        $existing = Bujk::query()->where('nib', $payload['nib'])->first();

        if ($existing) {
            $existing->fill($payload);
            $existing->is_deleted = false;
            $existing->save();

            return redirect()
                ->route('admin.bujk')
                ->with('success', 'Data BUJK berhasil disimpan dan data lama dengan NIB yang sama dipulihkan.');
        }

        Bujk::query()->create($payload + ['is_deleted' => false]);

        return redirect()
            ->route('admin.bujk')
            ->with('success', 'Data BUJK berhasil ditambahkan.');
    }

    public function update(BujkFormRequest $request, Bujk $bujk): RedirectResponse
    {
        $bujk->update($request->validated() + ['is_deleted' => false]);

        return redirect()
            ->route('admin.bujk')
            ->with('success', 'Data BUJK berhasil diperbarui.');
    }

    public function destroy(Bujk $bujk): RedirectResponse
    {
        $bujk->update(['is_deleted' => true]);

        return redirect()->back()->with('success', 'Data BUJK berhasil dihapus dari daftar aktif.');
    }

    public function import(BujkImportRequest $request, BujkImportService $importService): RedirectResponse
    {
        try {
            $summary = $importService->import($request->file('file_import'));
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['file_import' => $exception->getMessage()]);
        }

        return redirect()
            ->route('admin.bujk')
            ->with('success', 'Import data BUJK selesai diproses.')
            ->with('import_summary', $summary);
    }

    protected function applyJenisFilter(Builder $query, string $jenis): void
    {
        $normalized = str_replace(', ', ',', trim($jenis));
        $expression = "REPLACE(jenis_bujk, ', ', ',')";

        $query->where(function (Builder $innerQuery) use ($expression, $normalized): void {
            $innerQuery->whereRaw($expression . ' = ?', [$normalized])
                ->orWhereRaw($expression . ' LIKE ?', [$normalized . ',%'])
                ->orWhereRaw($expression . ' LIKE ?', ['%,' . $normalized])
                ->orWhereRaw($expression . ' LIKE ?', ['%,' . $normalized . ',%']);
        });
    }
}