<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    private function kegiatanData()
    {
        return [
            'rakor' => [
                [
                    'judul' => 'Rapat Koordinasi Sub Urusan Jasa Konstruksi Kabupaten/Kota Se Kalimantan Timur Tahun 2026',
                    'tanggal' => '08 Juni 2026',
                    'tempat' => 'Auditorium Kantor Walikota Bontang',
                    'kabupaten' => 'Kota Bontang',
                    'peserta' => 'Instansi Pemerintah',
                    'link' => '#',
                ],
                [
                    'judul' => 'Rapat Koordinasi Sub Urusan Jasa Konstruksi Kabupaten/Kota Se Kalimantan Timur Tahun 2026',
                    'tanggal' => '11 Juni 2026',
                    'tempat' => 'Hotel Kyriad Sadurengas Kabupaten Paser',
                    'kabupaten' => 'Paser',
                    'peserta' => 'Instansi Pemerintah',
                    'link' => '#',
                ],
            ],

            'sosialisasi' => [
                [
                    'judul' => 'Sosialisasi Kebijakan Pembinaan Jasa Konstruksi Tahun 2026',
                    'tanggal' => '12 Juli 2026',
                    'tempat' => 'Aula Dinas PUPRPERA Provinsi Kalimantan Timur',
                    'kabupaten' => 'Samarinda',
                    'peserta' => 'Masyarakat Jasa Konstruksi',
                    'link' => route('daftar-sosil'),
                ],
                [
                    'judul' => 'Sosialisasi Sistem Informasi Pembinaan Jasa Konstruksi',
                    'tanggal' => '18 Juli 2026',
                    'tempat' => 'Hotel Grand Tjokro Balikpapan',
                    'kabupaten' => 'Balikpapan',
                    'peserta' => 'Penyedia Jasa',
                    'link' => '#',
                ],
            ],

            'forum' => [
                [
                    'judul' => 'Forum Diskusi Pengembangan Jasa Konstruksi Kalimantan Timur',
                    'tanggal' => '25 Agustus 2026',
                    'tempat' => 'Ruang Pertemuan Dinas PUPRPERA Provinsi Kalimantan Timur',
                    'kabupaten' => 'Samarinda',
                    'peserta' => 'Forum Konstruksi',
                    'link' => '#',
                ],
                [
                    'judul' => 'Forum Konsultasi Publik Pembinaan Jasa Konstruksi',
                    'tanggal' => '19 Agustus 2026',
                    'tempat' => 'Balikpapan, Kalimantan Timur',
                    'kabupaten' => 'Balikpapan',
                    'peserta' => 'Masyarakat',
                    'link' => '#',
                ],
            ],
        ];
    }

    public function rakor()
    {
        $kegiatan = $this->kegiatanData()['rakor'];

        return view('welcome', [
            'page' => 'rakor',
            'kegiatan' => $kegiatan,
            'runningText' => $this->runningTextKegiatan(),
        ]);
    }

    public function sosialisasi()
    {
        $kegiatan = $this->kegiatanData()['sosialisasi'];

        return view('welcome', [
            'page' => 'sosialisasi',
            'kegiatan' => $kegiatan,
            'runningText' => $this->runningTextKegiatan(),
        ]);
    }

    public function forum()
    {
        $kegiatan = $this->kegiatanData()['forum'];

        return view('welcome', [
            'page' => 'forum',
            'kegiatan' => $kegiatan,
            'runningText' => $this->runningTextKegiatan(),
        ]);
    }

    public function beranda()
    {
        return view('welcome', [
            'page' => 'beranda',
            'runningText' => $this->runningTextKegiatan(),
        ]);
    }

    private function runningTextKegiatan()
    {
        $bulan = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        $semuaKegiatan = collect([
            ...$this->kegiatanData()['rakor'],
            ...$this->kegiatanData()['sosialisasi'],
            ...$this->kegiatanData()['forum'],
        ]);

        return $semuaKegiatan
            ->sortBy(function ($item) use ($bulan) {

                $tanggal = strtr($item['tanggal'], $bulan);

                return \Carbon\Carbon::createFromFormat(
                    'd F Y',
                    $tanggal
                );
            })
            ->take(5)
            ->values();
    }
}
