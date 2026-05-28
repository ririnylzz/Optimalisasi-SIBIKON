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
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Tahun
        </label>

        <select
            name="tahun"
            data-required="true"
            data-label="Tahun"
            data-number-min="2020"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

            <option value="">Pilih...</option>

            @for($i = date('Y') + 1; $i >= 2020; $i--)
                <option value="{{ $i }}" {{ old('tahun') == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor

        </select>

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('tahun') @else hidden @enderror">
            @error('tahun') {{ $message }} @enderror
        </p>
    </div>

    {{-- STATUS --}}
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Status Kegiatan
        </label>

        <select
            name="status"
            data-required="true"
            data-label="Status Kegiatan"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

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

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('status') @else hidden @enderror">
            @error('status') {{ $message }} @enderror
        </p>
    </div>

    {{-- JENIS PESERTA --}}
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Jenis Peserta
        </label>

        <select
            name="jenis_peserta"
            data-required="true"
            data-label="Jenis Peserta"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

            <option value="" disabled hidden {{ old('jenis_peserta') ? '' : 'selected' }}>
                Pilih...
            </option>

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

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('jenis_peserta') @else hidden @enderror">
            @error('jenis_peserta') {{ $message }} @enderror
        </p>
    </div>

    {{-- METODE --}}
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Metode Kegiatan
        </label>

        <select
            name="metode_kegiatan"
            data-required="true"
            data-label="Metode Kegiatan"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

            <option value="" disabled hidden {{ old('metode_kegiatan') ? '' : 'selected' }}>
                Pilih...
            </option>

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

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('metode_kegiatan') @else hidden @enderror">
            @error('metode_kegiatan') {{ $message }} @enderror
        </p>
    </div>

</div>

{{-- NAMA KEGIATAN --}}
<div class="field-group">
    <label class="mb-2 block text-sm font-medium text-slate-700">
        Nama Kegiatan
    </label>

    <input
        type="text"
        name="nama_kegiatan"
        value="{{ old('nama_kegiatan') }}"
        data-required="true"
        data-label="Nama Kegiatan"
        class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100"
        placeholder="Masukkan nama kegiatan">

    <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('nama_kegiatan') @else hidden @enderror">
        @error('nama_kegiatan') {{ $message }} @enderror
    </p>
</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- WAKTU --}}
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Waktu Kegiatan
        </label>

        <input
            type="date"
            name="waktu_kegiatan"
            value="{{ old('waktu_kegiatan') }}"
            data-required="true"
            data-label="Waktu Kegiatan"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('waktu_kegiatan') @else hidden @enderror">
            @error('waktu_kegiatan') {{ $message }} @enderror
        </p>
    </div>

    {{-- PESERTA --}}
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Realisasi Jumlah Peserta
        </label>

        <input
            type="number"
            name="realisasi_peserta"
            value="{{ old('realisasi_peserta') }}"
            data-required="true"
            data-label="Realisasi Jumlah Peserta"
            data-number-min="1"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100"
            placeholder="0">

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('realisasi_peserta') @else hidden @enderror">
            @error('realisasi_peserta') {{ $message }} @enderror
        </p>
    </div>

</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- SUMBER DANA --}}
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Sumber Dana
        </label>

        <select
            name="sumber_dana"
            data-required="true"
            data-label="Sumber Dana"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

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

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('sumber_dana') @else hidden @enderror">
            @error('sumber_dana') {{ $message }} @enderror
        </p>
    </div>

    {{-- STANDAR --}}
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Standar Kompetensi
        </label>

        <select
            name="standar_kompetensi"
            data-required="true"
            data-label="Standar Kompetensi"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

            <option value="">Pilih...</option>

            @foreach ($standarOptions as $standar)
                <option value="{{ $standar }}" {{ old('standar_kompetensi') === $standar ? 'selected' : '' }}>
                    {{ $standar }}
                </option>
            @endforeach

        </select>

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('standar_kompetensi') @else hidden @enderror">
            @error('standar_kompetensi') {{ $message }} @enderror
        </p>
    </div>

</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- TUK --}}
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Tempat Uji Kompetensi (TUK)
        </label>

        <input
            type="text"
            name="tuk"
            value="{{ old('tuk') }}"
            data-required="true"
            data-label="Tempat Uji Kompetensi"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('tuk') @else hidden @enderror">
            @error('tuk') {{ $message }} @enderror
        </p>
    </div>

    {{-- LSP --}}
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Lembaga Sertifikasi Profesi (LSP)
        </label>

        <select
            name="lsp"
            data-required="true"
            data-label="Lembaga Sertifikasi Profesi"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

            <option value="">Pilih...</option>

            @foreach ($lspOptions as $lsp)
                <option value="{{ $lsp }}" {{ old('lsp') === $lsp ? 'selected' : '' }}>
                    {{ $lsp }}
                </option>
            @endforeach

        </select>

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('lsp') @else hidden @enderror">
            @error('lsp') {{ $message }} @enderror
        </p>
    </div>

</div>

{{-- TEMPAT --}}
<div class="field-group">
    <label class="mb-2 block text-sm font-medium text-slate-700">
        Tempat Kegiatan
    </label>

    <input
        type="text"
        name="tempat_kegiatan"
        value="{{ old('tempat_kegiatan') }}"
        data-required="true"
        data-label="Tempat Kegiatan"
        class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

    <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('tempat_kegiatan') @else hidden @enderror">
        @error('tempat_kegiatan') {{ $message }} @enderror
    </p>
</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- PROVINSI --}}
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Provinsi
        </label>

        <select
            id="{{ $prefix }}_provinsi"
            name="provinsi"
            data-required="true"
            data-label="Provinsi"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

            <option value="">Pilih...</option>

            @foreach ($provinsiOptions as $provinsi)
                <option value="{{ $provinsi }}" {{ old('provinsi') === $provinsi ? 'selected' : '' }}>
                    {{ $provinsi }}
                </option>
            @endforeach

        </select>

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('provinsi') @else hidden @enderror">
            @error('provinsi') {{ $message }} @enderror
        </p>
    </div>

    {{-- KABUPATEN --}}
    <div class="field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Kabupaten/Kota
        </label>

        <select
            id="{{ $prefix }}_kabupaten"
            name="kabupaten_kota"
            data-required="true"
            data-label="Kabupaten/Kota"
            class="form-control-field w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

            <option value="">
                Pilih provinsi dulu...
            </option>

        </select>

        <p class="form-field-error mt-2 text-xs font-semibold text-rose-500 @error('kabupaten_kota') @else hidden @enderror">
            @error('kabupaten_kota') {{ $message }} @enderror
        </p>
    </div>

</div>

{{-- SYARAT --}}
<div class="field-group">
    <label class="mb-2 block text-sm font-medium text-slate-700">
        Syarat Tambahan
    </label>

    <textarea
        name="syarat_tambahan"
        rows="3"
        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"
        placeholder="Gunakan tanda semicolon (;) sebagai pemisah">{{ old('syarat_tambahan') }}</textarea>
</div>