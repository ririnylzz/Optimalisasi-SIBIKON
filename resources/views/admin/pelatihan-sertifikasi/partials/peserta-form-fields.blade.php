@php
    $formPrefix = $formPrefix ?? 'create';
@endphp

{{-- Form peserta pelatihan --}}

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- Identitas peserta --}}
    <div class="peserta-field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">Nama</label>

        <input
            type="text"
            name="nama"
            data-required="true"
            data-label="Nama"
            class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100"
            placeholder="Masukkan nama peserta">

        <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
    </div>

    {{-- Identitas peserta (NIK) --}}
    <div class="peserta-field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">NIK</label>

        <input
            type="text"
            name="nik"
            inputmode="numeric"
            pattern="[0-9]*"
            data-required="true"
            data-label="NIK"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100"
            placeholder="Masukkan NIK">

        <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
    </div>
</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- Kontak peserta --}}
    <div class="peserta-field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>

        <input
            type="email"
            name="email"
            data-required="true"
            data-email="true"
            data-label="Email"
            class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100"
            placeholder="Masukkan email">

        <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
    </div>

    {{-- Kontak peserta (telepon) --}}
    <div class="peserta-field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">No. Telp</label>

        <input
            type="text"
            name="telp"
            inputmode="numeric"
            pattern="[0-9]*"
            data-required="true"
            data-label="No. Telp"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100"
            placeholder="Masukkan nomor telepon">

        <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
    </div>
</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- Pendidikan & ASN --}}
    <div class="peserta-field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">Pendidikan/Jurusan</label>

        <select
            name="pendidikan_jurusan"
            data-required="true"
            data-label="Pendidikan/Jurusan"
            class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">
            <option value="" disabled hidden selected>Pilih</option>
            <option value="D4">D4</option>
            <option value="S1">S1</option>
            <option value="S2">S2</option>
            <option value="S3">S3</option>
        </select>

        <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
    </div>

    {{-- Pendidikan & ASN (status ASN) --}}
    <div class="peserta-field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">ASN</label>

        <select
            name="asn"
            data-required="true"
            data-label="ASN"
            class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">
            <option value="" disabled hidden selected>Pilih</option>
            <option value="Tidak">Tidak</option>
            <option value="Ya">Ya</option>
        </select>

        <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
    </div>
</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- Data pekerjaan --}}
    <div class="peserta-field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">Jabatan/Instansi</label>

        <input
            type="text"
            name="jabatan_instansi"
            data-required="true"
            data-label="Jabatan/Instansi"
            class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100"
            placeholder="Masukkan jabatan atau instansi">

        <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
    </div>

    {{-- Lokasi peserta --}}
    <div class="peserta-field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">Provinsi</label>

        <select
            name="provinsi"
            data-required="true"
            data-label="Provinsi"
            data-provinsi-peserta
            class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

            <option value="" disabled hidden selected>Pilih</option>

            {{-- Data wilayah Indonesia --}}
            <option value="Aceh">Aceh</option>
            <option value="Sumatera Utara">Sumatera Utara</option>
            <option value="Sumatera Barat">Sumatera Barat</option>
            <option value="Riau">Riau</option>
            <option value="Jambi">Jambi</option>
            <option value="Sumatera Selatan">Sumatera Selatan</option>
            <option value="Bengkulu">Bengkulu</option>
            <option value="Lampung">Lampung</option>
            <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung</option>
            <option value="Kepulauan Riau">Kepulauan Riau</option>
            <option value="DKI Jakarta">DKI Jakarta</option>
            <option value="Jawa Barat">Jawa Barat</option>
            <option value="Jawa Tengah">Jawa Tengah</option>
            <option value="DI Yogyakarta">DI Yogyakarta</option>
            <option value="Jawa Timur">Jawa Timur</option>
            <option value="Banten">Banten</option>
            <option value="Bali">Bali</option>
            <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
            <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
            <option value="Kalimantan Barat">Kalimantan Barat</option>
            <option value="Kalimantan Tengah">Kalimantan Tengah</option>
            <option value="Kalimantan Selatan">Kalimantan Selatan</option>
            <option value="Kalimantan Timur">Kalimantan Timur</option>
            <option value="Kalimantan Utara">Kalimantan Utara</option>
            <option value="Sulawesi Utara">Sulawesi Utara</option>
            <option value="Sulawesi Tengah">Sulawesi Tengah</option>
            <option value="Sulawesi Selatan">Sulawesi Selatan</option>
            <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
            <option value="Gorontalo">Gorontalo</option>
            <option value="Sulawesi Barat">Sulawesi Barat</option>
            <option value="Maluku">Maluku</option>
            <option value="Maluku Utara">Maluku Utara</option>
            <option value="Papua">Papua</option>
            <option value="Papua Barat">Papua Barat</option>
        </select>

        <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
    </div>
</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- Lokasi administrasi --}}
    <div class="peserta-field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">Kab./Kota</label>

        <select
            name="kab_kota"
            data-required="true"
            data-label="Kab./Kota"
            data-kabupaten-peserta
            class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">
            <option value="" disabled hidden selected>Pilih provinsi dulu</option>
        </select>

        <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
    </div>

    {{-- Tanggal pendaftaran --}}
    <div class="peserta-field-group">
        <label class="mb-2 block text-sm font-medium text-slate-700">Tanggal Daftar</label>

        <input
            type="date"
            name="waktu_daftar"
            data-required="true"
            data-label="Tanggal Daftar"
            class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">

        <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
    </div>
</div>

{{-- Alamat peserta --}}
<div class="peserta-field-group">
    <label class="mb-2 block text-sm font-medium text-slate-700">Alamat</label>

    <textarea
        name="alamat"
        rows="3"
        data-required="true"
        data-label="Alamat"
        class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100"
        placeholder="Masukkan alamat lengkap"></textarea>

    <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
</div>

{{-- Status peserta --}}
<div class="peserta-field-group">
    <label class="mb-2 block text-sm font-medium text-slate-700">Status Peserta</label>

    <select
        name="status_peserta"
        data-required="true"
        data-label="Status Peserta"
        class="peserta-form-control w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm transition focus:border-[#28428B] focus:ring-4 focus:ring-blue-100">
        <option value="" disabled hidden selected>Pilih</option>
        <option value="Calon Peserta">Calon Peserta</option>
        <option value="Peserta">Peserta</option>
        <option value="Tidak Lolos">Tidak Lolos</option>
    </select>

    <p class="peserta-field-error mt-2 hidden text-xs font-semibold text-rose-500"></p>
</div>