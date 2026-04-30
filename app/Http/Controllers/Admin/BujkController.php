<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Bujk\BujkFormRequest;
use App\Http\Requests\Admin\Bujk\BujkImportRequest;
use App\Models\Bujk;
use App\Services\Bujk\BujkImportService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class BujkController extends Controller
{
    public function index(Request $request)
    {
        $perPage = in_array((int) $request->integer('per_page'), [10, 25, 50, 100], true)
            ? (int) $request->integer('per_page')
            : 10;

        $search = $this->squish((string) $request->string('search'));
        $jenisFilter = trim((string) $request->string('jenis'));
        $regencyFilter = $this->normalizeRegionValue((string) $request->string('kabupaten'));

        $baseQuery = Bujk::query()->active();
        $filteredQuery = clone $baseQuery;

        if ($search !== '') {
            $filteredQuery->where(function (Builder $query) use ($search): void {
                $query->where('nib', 'like', '%' . $search . '%')
                    ->orWhere('nama_bujk', 'like', '%' . $search . '%');
            });
        }

        if ($jenisFilter !== '') {
            $this->applyJenisFilter($filteredQuery, $jenisFilter);
        }

        if ($regencyFilter !== '') {
            $filteredQuery->where('kab_kota_bujk', $regencyFilter);
        }

        $regencyFilterOptions = Bujk::query()
            ->active()
            ->whereNotNull('kab_kota_bujk')
            ->where('kab_kota_bujk', '<>', '')
            ->orderBy('kab_kota_bujk')
            ->pluck('kab_kota_bujk')
            ->map(fn ($value) => $this->normalizeRegionValue((string) $value))
            ->filter()
            ->unique()
            ->values();

        $bujks = $filteredQuery
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        $editingBujk = $request->filled('edit')
            ? Bujk::query()->active()->findOrFail((int) $request->query('edit'))
            : null;

        $viewData = [
            'bujks' => $bujks,
            'editingBujk' => $editingBujk,
            'jenisOptions' => config('bujk.jenis_usaha', []),
            'search' => $search,
            'jenisFilter' => $jenisFilter,
            'regencyFilter' => $regencyFilter,
            'regencyFilterOptions' => $regencyFilterOptions,
            'perPage' => $perPage,
        ];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.bujk.partials.table', $viewData)->render(),
            ]);
        }

        return view('admin.bujk.index', $viewData);
    }

    public function store(BujkFormRequest $request): RedirectResponse
    {
        $payload = $request->validated();
        $existing = Bujk::query()->where('nib', $payload['nib'])->first();

        if ($existing) {
            $existing->fill($payload);
            $existing->is_deleted = false;
            $existing->updated_at = now();
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
        $bujk->update($request->validated() + [
            'is_deleted' => false,
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.bujk')
            ->with('success', 'Data BUJK berhasil diperbarui.');
    }

    public function destroy(Bujk $bujk): RedirectResponse
    {
        $bujk->update([
            'is_deleted' => true,
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.bujk')
            ->with('success', 'Data BUJK berhasil dihapus dari daftar aktif.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:bujk,id'],
        ], [
            'ids.required' => 'Pilih minimal satu data BUJK.',
            'ids.array' => 'Format data yang dipilih tidak valid.',
            'ids.min' => 'Pilih minimal satu data BUJK.',
            'ids.*.integer' => 'ID data BUJK tidak valid.',
            'ids.*.exists' => 'Ada data BUJK yang tidak ditemukan.',
        ]);

        $ids = collect($validated['ids'])
            ->map(fn($id) => (int) $id)
            ->filter()
            ->unique()
            ->values()
            ->all();

        $affected = Bujk::query()
            ->whereIn('id', $ids)
            ->where('is_deleted', false)
            ->update([
                'is_deleted' => true,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.bujk')
            ->with(
                $affected > 0 ? 'success' : 'error',
                $affected > 0
                    ? $affected . ' data BUJK berhasil dihapus.'
                    : 'Tidak ada data BUJK yang dihapus.'
            );
    }

    public function destroyAll(): RedirectResponse
    {
        $affected = Bujk::query()
            ->where('is_deleted', false)
            ->update([
                'is_deleted' => true,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.bujk')
            ->with(
                $affected > 0 ? 'success' : 'error',
                $affected > 0
                    ? 'Semua data BUJK berhasil dihapus (' . $affected . ' data).'
                    : 'Tidak ada data BUJK aktif untuk dihapus.'
            );
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

    public function provinceOptions(): JsonResponse
    {
        try {
            $data = Cache::remember('bujk:regions:provinces:v1', now()->addDays(30), function () {
                $response = Http::acceptJson()
                    ->timeout(20)
                    ->retry(2, 500)
                    ->get('https://wilayah.id/api/provinces.json')
                    ->throw()
                    ->json();

                return collect($response['data'] ?? [])
                    ->map(function (array $item) {
                        $label = $this->squish((string) ($item['name'] ?? ''));
                        $code = $this->squish((string) ($item['code'] ?? ''));

                        if ($label === '' || $code === '') {
                            return null;
                        }

                        return [
                            'code' => $code,
                            'label' => $label,
                            'value' => $this->normalizeRegionValue($label),
                        ];
                    })
                    ->filter()
                    ->sortBy('label', SORT_NATURAL | SORT_FLAG_CASE)
                    ->values()
                    ->all();
            });

            return response()->json([
                'data' => $data,
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Gagal memuat daftar provinsi.',
            ], 502);
        }
    }

    public function regencyOptions(Request $request): JsonResponse
    {
        $provinceCode = $this->squish((string) $request->query('province_code'));

        if (!preg_match('/^\d{2}$/', $provinceCode)) {
            return response()->json([
                'message' => 'province_code tidak valid.',
            ], 422);
        }

        try {
            $cacheKey = 'bujk:regions:regencies:' . $provinceCode . ':v1';

            $data = Cache::remember($cacheKey, now()->addDays(30), function () use ($provinceCode) {
                $response = Http::acceptJson()
                    ->timeout(20)
                    ->retry(2, 500)
                    ->get("https://wilayah.id/api/regencies/{$provinceCode}.json")
                    ->throw()
                    ->json();

                return collect($response['data'] ?? [])
                    ->map(function (array $item) {
                        $label = $this->squish((string) ($item['name'] ?? ''));
                        $code = $this->squish((string) ($item['code'] ?? ''));

                        if ($label === '' || $code === '') {
                            return null;
                        }

                        return [
                            'code' => $code,
                            'label' => $label,
                            'value' => $this->normalizeRegionValue($label),
                        ];
                    })
                    ->filter()
                    ->sortBy('label', SORT_NATURAL | SORT_FLAG_CASE)
                    ->values()
                    ->all();
            });

            return response()->json([
                'data' => $data,
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Gagal memuat daftar kabupaten/kota.',
            ], 502);
        }
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

    protected function squish(?string $value): string
    {
        return trim(preg_replace('/\s+/u', ' ', (string) $value) ?? '');
    }

    protected function normalizeRegionValue(?string $value): string
    {
        return Str::upper($this->squish($value));
    }
}