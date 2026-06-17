<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GisController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Kode Kabupaten/Kota Kalimantan Timur
    |--------------------------------------------------------------------------
    | Array ini digunakan untuk menyamakan kode wilayah dari database
    | dengan nama kabupaten/kota yang akan ditampilkan pada fitur GIS.
    */
    private array $kodeKabupaten = [
        '64.01' => 'Paser',
        '64.02' => 'Kutai Kartanegara',
        '64.03' => 'Berau',
        '64.07' => 'Kutai Barat',
        '64.08' => 'Kutai Timur',
        '64.09' => 'Penajam Paser Utara',
        '64.11' => 'Mahakam Ulu',
        '64.71' => 'Kota Balikpapan',
        '64.72' => 'Kota Samarinda',
        '64.74' => 'Kota Bontang',
    ];

    /*
    |--------------------------------------------------------------------------
    | Endpoint Utama Data GIS
    |--------------------------------------------------------------------------
    | Fungsi ini menerima parameter kategori dari route, lalu menentukan
    | data mana yang akan dikirim ke halaman GIS, apakah BUJK, TKK,
    | atau Rantai Pasok.
    */
    public function data(string $category): JsonResponse
    {
        return match ($category) {
            'bujk' => response()->json($this->bujkData()),
            'tkk' => response()->json($this->tkkData()),
            'rantai-pasok' => response()->json($this->rantaiPasokData()),
            default => response()->json([
                'items' => [],
                'summary' => [],
                'kabupaten_options' => $this->kabupatenOptions(),
                'message' => 'Kategori GIS tidak ditemukan.',
            ], 404),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Mengambil Data BUJK
    |--------------------------------------------------------------------------
    | Fungsi ini mengambil data BUJK dari tabel bujk, lalu menyesuaikan
    | nama kolom agar data dapat dibaca oleh tampilan GIS.
    */
    private function bujkData(): array
    {
        $table = 'bujk';

        // Mengecek apakah tabel bujk tersedia di database
        if (!Schema::hasTable($table)) {
            return $this->emptyPayload();
        }

        // Membuat query dasar untuk mengambil data dari tabel bujk
        $query = DB::table($table);

        // Jika tabel memiliki kolom is_deleted, maka data yang sudah dihapus tidak ditampilkan
        if ($this->hasColumn($table, 'is_deleted')) {
            $query->where(function ($query) {
                $query->whereNull('is_deleted')
                    ->orWhere('is_deleted', 0);
            });
        }

        // Menyaring data berdasarkan kode kabupaten/kota jika kolom kab_kota_bujk tersedia
        if ($this->hasColumn($table, 'kab_kota_bujk')) {
            $query->whereIn('kab_kota_bujk', array_keys($this->kodeKabupaten));
        } elseif ($this->hasColumn($table, 'kabupaten')) {
            $query->whereNotNull('kabupaten')
                ->where('kabupaten', '!=', '');
        }

        // Menjalankan query dan mengambil seluruh data BUJK
        $rows = $query->get();

        /*
         * Mengubah data mentah dari database menjadi format standar
         * yang dibutuhkan oleh tampilan GIS.
         */
        $items = $rows
            ->map(function ($row) {
                // Mengambil nama badan usaha dari beberapa kemungkinan nama kolom
                $namaBu = $this->value($row, [
                    'nama_bu',
                    'nama_bujk',
                    'nama',
                    'Nama_BU',
                    'Nama_BUJK',
                ]);

                // Mengambil NIB badan usaha
                $nib = $this->value($row, [
                    'nib',
                    'NIB',
                ]);

                // Mengambil jenis usaha BUJK
                $jenisUsaha = $this->value($row, [
                    'jenis_usaha',
                    'jenis_bujk',
                    'Jenis_Usaha',
                    'Jenis_BUJK',
                ]);

                // Mengambil alamat BUJK
                $alamat = $this->value($row, [
                    'alamat',
                    'alamat_bujk',
                    'alamat_bu',
                    'Alamat',
                    'Alamat_BUJK',
                ]);

                // Mengambil data kabupaten/kota dari beberapa kemungkinan nama kolom
                $kabupatenRaw = $this->value($row, [
                    'kabupaten',
                    'kab_kota_bujk',
                    'kab_kota',
                    'Kabupaten',
                    'Kab_Kota_BUJK',
                ]);

                // Menyamakan format nama kabupaten/kota
                $kabupaten = $this->normalizeKabupaten($kabupatenRaw);

                // Mengambil nomor telepon atau kontak BUJK
                $telepon = $this->value($row, [
                    'telepon',
                    'telp',
                    'telp_bujk',
                    'no_telp',
                    'no_telepon',
                    'nomor_telepon',
                    'kontak',
                    'Telepon',
                ]);

                // Mengambil email BUJK
                $email = $this->value($row, [
                    'email',
                    'email_bujk',
                    'Email',
                ]);

                // Mengambil website BUJK jika tersedia
                $website = $this->value($row, [
                    'website',
                    'website_bujk',
                    'Website',
                ]);

                // Mengambil asosiasi BUJK jika tersedia
                $asosiasi = $this->value($row, [
                    'asosiasi',
                    'Asosiasi',
                ]);

                // Mengambil status BUJK jika tersedia
                $status = $this->value($row, [
                    'status',
                    'Status',
                ]);

                // Mengembalikan data BUJK dalam format standar untuk GIS
                return [
                    'id' => $this->value($row, ['id', 'ID']),
                    'category' => 'bujk',
                    'name' => $namaBu,
                    'nama_bu' => $namaBu,
                    'nib' => $nib,
                    'jenis_usaha' => $jenisUsaha,
                    'alamat' => $alamat,
                    'kabupaten' => $kabupaten,
                    'kode_kabupaten' => $this->kodeKabupatenByName($kabupaten),
                    'provinsi' => $this->value($row, ['propinsi', 'provinsi', 'Provinsi']) ?: 'Kalimantan Timur',
                    'telepon' => $telepon,
                    'email' => $email,
                    'website' => $website,
                    'asosiasi' => $asosiasi,
                    'status' => $status,
                ];
            })

            // Menampilkan hanya data yang memiliki nama dan kabupaten/kota
            ->filter(function ($item) {
                return filled($item['name'])
                    && filled($item['kabupaten']);
            })
            ->values();

        /*
         * Menghapus data ganda berdasarkan NIB.
         * Jika NIB kosong, maka pengecekan dilakukan berdasarkan nama BU dan kabupaten.
         */
        $items = $items
            ->groupBy(function ($item) {
                if (filled($item['nib'])) {
                    return 'nib:' . trim((string) $item['nib']);
                }

                return 'nama:' . strtolower((string) $item['name']) . '|kab:' . strtolower((string) $item['kabupaten']);
            })
            ->map(function ($group) {
                return $group->first();
            })
            ->values();

        // Mengembalikan data BUJK lengkap dengan summary dan pilihan kabupaten/kota
        return $this->payload($items);
    }

    /*
    |--------------------------------------------------------------------------
    | Mengambil Data TKK
    |--------------------------------------------------------------------------
    | Fungsi ini mengambil data Tenaga Kerja Konstruksi dari tabel tkk,
    | lalu menambahkan informasi status aktif/kadaluwarsa berdasarkan
    | tanggal kadaluwarsa sertifikat.
    */
    private function tkkData(): array
    {
        $table = 'tkk';

        // Mengecek apakah tabel tkk tersedia di database
        if (!Schema::hasTable($table)) {
            return $this->emptyPayload();
        }

        // Mengambil data TKK dan mengubahnya ke format standar untuk GIS
        $items = DB::table($table)
            ->get()
            ->map(function ($row) {
                // Mengambil tanggal kadaluwarsa sertifikat dari beberapa kemungkinan nama kolom
                $tanggalKadaluwarsa = $this->value($row, [
                    'Tanggal_Kadaluwarsa',
                    'Tanggal_kadaluwarsa',
                    'tanggal_kadaluwarsa',
                    'tgl_kadaluwarsa',
                ]);

                // Menentukan status sertifikat berdasarkan tanggal kadaluwarsa
                $status = $this->isExpired($tanggalKadaluwarsa) ? 'kadaluwarsa' : 'aktif';

                // Mengembalikan data TKK dalam format standar untuk GIS
                return [
                    'id' => $this->value($row, ['id', 'ID']),
                    'category' => 'tkk',
                    'name' => $this->value($row, ['Nama', 'nama']),
                    'kabupaten' => $this->normalizeKabupaten(
                        $this->value($row, ['Kabupaten', 'kabupaten', 'kab_kota'])
                    ),
                    'klasifikasi' => $this->value($row, ['Klasifikasi', 'klasifikasi']),
                    'jabatan_kerja' => $this->value($row, ['Jabatan_Kerja', 'jabatan_kerja']),
                    'jenjang' => $this->value($row, ['Jenjang', 'jenjang']),
                    'asosiasi' => $this->value($row, ['Asosiasi', 'asosiasi']),
                    'tanggal_kadaluwarsa' => $tanggalKadaluwarsa,
                    'tanggal_kadaluwarsa_label' => $this->dateLabel($tanggalKadaluwarsa),
                    'status' => $status,
                    'status_label' => $status === 'kadaluwarsa' ? 'Kadaluwarsa' : 'Aktif',
                ];
            })

            // Menampilkan hanya data yang memiliki kabupaten/kota
            ->filter(fn ($item) => filled($item['kabupaten']))
            ->values();

        /*
         * Mengembalikan data TKK beserta pilihan jenjang.
         * Pilihan jenjang digunakan sebagai filter tambahan pada tampilan GIS.
         */
        return $this->payload($items, [
            'jenjang_options' => $items
                ->pluck('jenjang')
                ->filter()
                ->unique()
                ->sort()
                ->values(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Mengambil Data Rantai Pasok
    |--------------------------------------------------------------------------
    | Fungsi ini mengambil data rantai pasok dari tabel rantai_pasok,
    | kemudian mengubahnya menjadi format standar untuk ditampilkan
    | pada peta GIS dan daftar card.
    */
    private function rantaiPasokData(): array
    {
        $table = 'rantai_pasok';

        // Mengecek apakah tabel rantai_pasok tersedia di database
        if (!Schema::hasTable($table)) {
            return $this->emptyPayload();
        }

        // Mengambil data rantai pasok dan menyesuaikannya dengan format GIS
        $items = DB::table($table)
            ->get()
            ->map(function ($row) {
                return [
                    'id' => $this->value($row, ['id', 'ID']),
                    'category' => 'rantai-pasok',
                    'name' => $this->value($row, ['nama', 'Nama', 'nama_usaha', 'Nama_Usaha']),
                    'bidang_usaha' => $this->value($row, ['bidang_usaha', 'Bidang_Usaha', 'bidang', 'Bidang']),
                    'alamat' => $this->value($row, ['alamat', 'Alamat']),
                    'kabupaten' => $this->normalizeKabupaten(
                        $this->value($row, ['kabupaten', 'Kabupaten', 'kab_kota', 'Kab_Kota'])
                    ),
                ];
            })

            // Menampilkan hanya data yang memiliki kabupaten/kota
            ->filter(fn ($item) => filled($item['kabupaten']))
            ->values();

        /*
         * Mengembalikan data rantai pasok beserta pilihan bidang usaha.
         * Pilihan bidang usaha digunakan sebagai filter tambahan pada tampilan GIS.
         */
        return $this->payload($items, [
            'bidang_usaha_options' => $items
                ->pluck('bidang_usaha')
                ->filter()
                ->unique()
                ->sort()
                ->values(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Membentuk Payload JSON untuk GIS
    |--------------------------------------------------------------------------
    | Fungsi ini menyusun data utama, ringkasan jumlah data per kabupaten,
    | dan daftar kabupaten/kota untuk kebutuhan filter di frontend.
    */
    private function payload(Collection $items, array $extra = []): array
    {
        // Menghitung jumlah data berdasarkan kabupaten/kota
        $summary = $items
            ->groupBy('kabupaten')
            ->map(function ($group, $kabupaten) {
                return [
                    'kabupaten' => $kabupaten,
                    'total' => $group->count(),
                ];
            })
            ->sortByDesc('total')
            ->values();

        // Menggabungkan data utama dengan data tambahan jika ada
        return array_merge([
            'items' => $items->values(),
            'summary' => $summary,
            'kabupaten_options' => $this->kabupatenOptions(),
        ], $extra);
    }

    /*
    |--------------------------------------------------------------------------
    | Payload Kosong
    |--------------------------------------------------------------------------
    | Fungsi ini digunakan ketika tabel tidak ditemukan atau data belum tersedia.
    */
    private function emptyPayload(): array
    {
        return [
            'items' => [],
            'summary' => [],
            'kabupaten_options' => $this->kabupatenOptions(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Pilihan Kabupaten/Kota
    |--------------------------------------------------------------------------
    | Fungsi ini mengembalikan daftar kabupaten/kota Kalimantan Timur
    | untuk digunakan sebagai pilihan filter pada tampilan GIS.
    */
    private function kabupatenOptions(): Collection
    {
        return collect($this->kodeKabupaten)
            ->values()
            ->sort()
            ->values();
    }

    /*
    |--------------------------------------------------------------------------
    | Normalisasi Nama Kabupaten/Kota
    |--------------------------------------------------------------------------
    | Fungsi ini menyamakan format data kabupaten/kota, baik yang berasal
    | dari kode wilayah, nama lengkap, maupun nama dengan awalan Kabupaten/Kota.
    */
    private function normalizeKabupaten($value): ?string
    {
        // Jika nilai kosong, maka tidak ada nama kabupaten yang dikembalikan
        if (blank($value)) {
            return null;
        }

        // Mengubah nilai menjadi string dan menghapus spasi berlebih di awal/akhir
        $value = trim((string) $value);

        // Jika nilai berupa kode kabupaten, maka dikonversi menjadi nama kabupaten/kota
        if (isset($this->kodeKabupaten[$value])) {
            return $this->kodeKabupaten[$value];
        }

        // Merapikan spasi ganda pada nama wilayah
        $normalized = preg_replace('/\s+/', ' ', $value);
        $normalized = trim($normalized);

        // Menghapus awalan kabupaten/kab. agar nama wilayah lebih mudah dicocokkan
        $withoutPrefix = preg_replace('/^(kab\.?|kabupaten)\s+/i', '', $normalized);
        $withoutPrefix = trim($withoutPrefix);

        // Mencocokkan nama wilayah dengan daftar kabupaten/kota yang tersedia
        foreach ($this->kodeKabupaten as $kode => $kabupaten) {
            if (strtolower($normalized) === strtolower($kabupaten)) {
                return $kabupaten;
            }

            if (strtolower($withoutPrefix) === strtolower($kabupaten)) {
                return $kabupaten;
            }
        }

        // Jika tidak cocok dengan daftar, maka nilai asli yang sudah dirapikan tetap dikembalikan
        return $normalized;
    }

    /*
    |--------------------------------------------------------------------------
    | Mengambil Kode Kabupaten Berdasarkan Nama
    |--------------------------------------------------------------------------
    | Fungsi ini digunakan untuk mendapatkan kode wilayah dari nama
    | kabupaten/kota yang sudah dinormalisasi.
    */
    private function kodeKabupatenByName(?string $name): ?string
    {
        // Jika nama kabupaten kosong, maka kode tidak dapat dicari
        if (blank($name)) {
            return null;
        }

        // Mencocokkan nama kabupaten/kota dengan daftar kode wilayah
        foreach ($this->kodeKabupaten as $kode => $kabupaten) {
            if (strtolower($kabupaten) === strtolower((string) $name)) {
                return $kode;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Mengambil Nilai dari Beberapa Kemungkinan Nama Kolom
    |--------------------------------------------------------------------------
    | Fungsi ini dibuat karena nama kolom pada database bisa berbeda-beda.
    | Sistem akan mencari kolom yang tersedia, lalu mengambil nilainya.
    */
    private function value(object $row, array $columns): mixed
    {
        foreach ($columns as $column) {
            if (property_exists($row, $column)) {
                return $row->{$column};
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Mengecek Kolom pada Tabel
    |--------------------------------------------------------------------------
    | Fungsi ini digunakan untuk memastikan sebuah kolom tersedia
    | sebelum kolom tersebut dipakai dalam query.
    */
    private function hasColumn(string $table, string $column): bool
    {
        return Schema::hasColumn($table, $column);
    }

    /*
    |--------------------------------------------------------------------------
    | Mengecek Status Kadaluwarsa
    |--------------------------------------------------------------------------
    | Fungsi ini digunakan untuk menentukan apakah tanggal sertifikat
    | sudah melewati tanggal hari ini atau belum.
    */
    private function isExpired($date): bool
    {
        // Jika tanggal kosong, maka dianggap belum kadaluwarsa
        if (blank($date)) {
            return false;
        }

        try {
            return Carbon::parse($date)->lt(now()->startOfDay());
        } catch (\Throwable) {
            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Format Label Tanggal
    |--------------------------------------------------------------------------
    | Fungsi ini mengubah format tanggal menjadi d-m-Y agar lebih mudah
    | dibaca pada tampilan halaman GIS.
    */
    private function dateLabel($date): string
    {
        // Jika tanggal kosong, tampilkan keterangan default
        if (blank($date)) {
            return 'Tidak ada tanggal';
        }

        try {
            return Carbon::parse($date)->format('d-m-Y');
        } catch (\Throwable) {
            return (string) $date;
        }
    }
}