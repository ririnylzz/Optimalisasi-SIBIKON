<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Bujk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenyediaJasaController extends Controller
{
    protected array $allowedPerPage = [10, 25, 50];

    public function index(Request $request): View
    {
        $perPage = $this->getPerPage($request);
        $search = trim((string) $request->query('search', ''));

        $penyediaJasaKonstruksi = $this->buildQuery($search)
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.layanan.penyedia-jasa', [
            'penyediaJasaKonstruksi' => $penyediaJasaKonstruksi,
            'allowedPerPage' => $this->allowedPerPage,
            'perPage' => $perPage,
            'search' => $search,
        ]);
    }

    public function data(Request $request): JsonResponse
    {
        $perPage = $this->getPerPage($request);
        $search = trim((string) $request->query('search', ''));
        $page = max((int) $request->query('page', 1), 1);

        $result = $this->buildQuery($search)
            ->paginate($perPage, ['*'], 'page', $page);

        $rows = $result->getCollection()
            ->values()
            ->map(function (Bujk $bujk, int $index) use ($result) {
                return [
                    'no' => $result->firstItem() ? $result->firstItem() + $index : $index + 1,
                    'nama' => $bujk->nama_bu ?: '-',
                    'alamat' => $bujk->alamat ?: '-',
                    'telp' => $bujk->telepon ?: '-',
                    'email' => $bujk->email ?: '-',
                ];
            });

        return response()->json([
            'rows' => $rows,
            'pagination' => [
                'current_page' => $result->currentPage(),
                'last_page' => $result->lastPage(),
                'per_page' => $result->perPage(),
                'total' => $result->total(),
                'from' => $result->firstItem(),
                'to' => $result->lastItem(),
                'has_more_pages' => $result->hasMorePages(),
                'on_first_page' => $result->onFirstPage(),
            ],
        ]);
    }

    protected function buildQuery(string $search)
    {
        return Bujk::query()
            ->where('is_deleted', false)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('nama_bu', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%')
                        ->orWhere('telepon', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->orderByRaw("CASE WHEN nama_bu IS NULL OR nama_bu = '' THEN 1 ELSE 0 END")
            ->orderBy('nama_bu');
    }

    protected function getPerPage(Request $request): int
    {
        $perPage = (int) $request->query('per_page', 10);

        if (! in_array($perPage, $this->allowedPerPage, true)) {
            return 10;
        }

        return $perPage;
    }
}