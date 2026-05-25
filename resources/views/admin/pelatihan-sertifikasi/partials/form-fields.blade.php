@php
    $prefix = $prefix ?? 'create';

    $standarOptions = [
        'Pengelola Teknis Pembangunan Bangunan Gedung Negara',
        'Ahli Madya Rekayasa Konstruksi Bangunan Gedung',
        'Ahli Muda Teknik Jalan',
        'Ahli Muda Bidang Keahlian Teknik Sumber Daya Air',
        'Ahli Muda K3 Konstruksi',
        'Ahli Muda Teknik Jembatan',
        'Ahli Muda Bidang Keahlian Manajemen Konstruksi',
    ];

    $lspOptions = [
        'ATAKI Konstruksi Indonesia',
        'HATSINDO Indonesia Teknik',
        'KATIGA Konstruksi Indonesia',
        'GATAKI Konstruksi Mandiri',
        'PERTAHKINDO Kaltim',
        'Infrastruktur Jalan dan Jembatan Indonesia',
        'ASTEKINDO Kaltim',
    ];

    $provinsiOptions = [
        'Aceh',
        'Sumatera Utara',
        'Sumatera Barat',
        'Riau',
        'Jambi',
        'Sumatera Selatan',
        'Bengkulu',
        'Lampung',
        'Kepulauan Bangka Belitung',
        'Kepulauan Riau',
        'DKI Jakarta',
        'Jawa Barat',
        'Jawa Tengah',
        'DI Yogyakarta',
        'Jawa Timur',
        'Banten',
        'Bali',
        'Nusa Tenggara Barat',
        'Nusa Tenggara Timur',
        'Kalimantan Barat',
        'Kalimantan Tengah',
        'Kalimantan Selatan',
        'Kalimantan Timur',
        'Kalimantan Utara',
        'Sulawesi Utara',
        'Sulawesi Tengah',
        'Sulawesi Selatan',
        'Sulawesi Tenggara',
        'Gorontalo',
        'Sulawesi Barat',
        'Maluku',
        'Maluku Utara',
        'Papua',
        'Papua Barat',
    ];
@endphp

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- TAHUN --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Tahun
        </label>

        <select
            name="tahun"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

            <option value="">Pilih...</option>

            @for($i = date('Y') + 1; $i >= 2020; $i--)
                <option value="{{ $i }}" {{ old('tahun') == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor

        </select>
    </div>

    {{-- STATUS --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Status Kegiatan
        </label>

        <select
            name="status"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

            <option value="" disabled hidden {{ old('status') ? '' : 'selected' }}>
                Pilih
            </option>

            <option value="dibuka" {{ old('status') === 'dibuka' ? 'selected' : '' }}>
                Terbuka
            </option>

            <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>
                Tertutup
            </option>

        </select>
    </div>

    {{-- JENIS PESERTA --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Jenis Peserta
        </label>

        <select
            name="jenis_peserta"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

            <option value="Umum" {{ old('jenis_peserta') === 'Umum' ? 'selected' : '' }}>
                Umum
            </option>

            <option value="Fresh Graduate" {{ old('jenis_peserta') === 'Fresh Graduate' ? 'selected' : '' }}>
                Fresh Graduate
            </option>

            <option value="TKK" {{ old('jenis_peserta') === 'TKK' ? 'selected' : '' }}>
                TKK
            </option>

            <option value="ASN" {{ old('jenis_peserta') === 'ASN' ? 'selected' : '' }}>
                ASN
            </option>

        </select>
    </div>

    {{-- METODE --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Metode Kegiatan
        </label>

        <select
            name="metode_kegiatan"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

            <option value="Luring" {{ old('metode_kegiatan') === 'Luring' ? 'selected' : '' }}>
                Luring
            </option>

            <option value="Daring" {{ old('metode_kegiatan') === 'Daring' ? 'selected' : '' }}>
                Daring
            </option>

            <option value="Luring dan Daring" {{ old('metode_kegiatan') === 'Luring dan Daring' ? 'selected' : '' }}>
                Luring dan Daring
            </option>

        </select>
    </div>

</div>

{{-- NAMA KEGIATAN --}}
<div>
    <label class="mb-2 block text-sm font-medium text-slate-700">
        Nama Kegiatan
    </label>

    <input
        type="text"
        name="nama_kegiatan"
        value="{{ old('nama_kegiatan') }}"
        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"
        placeholder="Masukkan nama kegiatan">
</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- WAKTU --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Waktu Kegiatan
        </label>

        <input
            type="date"
            name="waktu_kegiatan"
            value="{{ old('waktu_kegiatan') }}"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
    </div>

    {{-- PESERTA --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Realisasi Jumlah Peserta
        </label>

        <input
            type="number"
            name="realisasi_peserta"
            value="{{ old('realisasi_peserta') }}"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"
            placeholder="0">
    </div>

</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- SUMBER DANA --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Sumber Dana
        </label>

        <select
            name="sumber_dana"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

            <option value="">Pilih...</option>

            <option value="APBD" {{ old('sumber_dana') === 'APBD' ? 'selected' : '' }}>
                APBD
            </option>

            <option value="APBDP" {{ old('sumber_dana') === 'APBDP' ? 'selected' : '' }}>
                APBDP
            </option>

            <option value="APBN" {{ old('sumber_dana') === 'APBN' ? 'selected' : '' }}>
                APBN
            </option>

        </select>
    </div>

    {{-- STANDAR --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Standar Kompetensi
        </label>

        <select
            name="standar_kompetensi"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

            <option value="">Pilih...</option>

            @foreach ($standarOptions as $standar)
                <option value="{{ $standar }}" {{ old('standar_kompetensi') === $standar ? 'selected' : '' }}>
                    {{ $standar }}
                </option>
            @endforeach

        </select>
    </div>

</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- TUK --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Tempat Uji Kompetensi (TUK)
        </label>

        <input
            type="text"
            name="tuk"
            value="{{ old('tuk') }}"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
    </div>

    {{-- LSP --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Lembaga Sertifikasi Profesi (LSP)
        </label>

        <select
            name="lsp"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

            <option value="">Pilih...</option>

            @foreach ($lspOptions as $lsp)
                <option value="{{ $lsp }}" {{ old('lsp') === $lsp ? 'selected' : '' }}>
                    {{ $lsp }}
                </option>
            @endforeach

        </select>
    </div>

</div>

{{-- TEMPAT --}}
<div>
    <label class="mb-2 block text-sm font-medium text-slate-700">
        Tempat Kegiatan
    </label>

    <input
        type="text"
        name="tempat_kegiatan"
        value="{{ old('tempat_kegiatan') }}"
        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- PROVINSI --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Provinsi
        </label>

        <select
            id="{{ $prefix }}_provinsi"
            name="provinsi"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

            <option value="">Pilih...</option>

            @foreach ($provinsiOptions as $provinsi)
                <option value="{{ $provinsi }}" {{ old('provinsi') === $provinsi ? 'selected' : '' }}>
                    {{ $provinsi }}
                </option>
            @endforeach

        </select>
    </div>

    {{-- KABUPATEN --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Kabupaten/Kota
        </label>

        <select
            id="{{ $prefix }}_kabupaten"
            name="kabupaten_kota"
            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

            <option value="">
                Pilih provinsi dulu...
            </option>

        </select>
    </div>

</div>

{{-- SYARAT --}}
<div>
    <label class="mb-2 block text-sm font-medium text-slate-700">
        Syarat Tambahan
    </label>

    <textarea
        name="syarat_tambahan"
        rows="3"
        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"
        placeholder="Gunakan tanda semicolon (;) sebagai pemisah">{{ old('syarat_tambahan') }}</textarea>
</div>