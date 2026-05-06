<div class="min-h-screen bg-white text-slate-900">

    <!-- HEADER -->
    <section class="bg-[#243B78] text-white py-10">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-3xl font-extrabold">Form Pendaftaran Kegiatan</h1>
            <p class="text-white/70 mt-2">Silakan lengkapi data berikut</p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-12">
        <div class="max-w-5xl mx-auto px-6">

            <!-- DETAIL ACARA -->
            <div class="mb-10 bg-slate-50 border border-slate-200 rounded-2xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <p><strong>Judul Acara</strong> : Bimbingan Teknis Penyusunan AHSP</p>
                    <p><strong>Waktu Acara</strong> : 07 Mei 2026</p>
                    <p><strong>Lokasi Acara</strong> : Zoom Meeting KOTA SAMARINDA</p>
                    <p><strong>Tipe Peserta</strong> : Masyarakat Konstruksi</p>
                </div>
            </div>

            <!-- FORM -->
            <form class="space-y-6">

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Nama Lengkap (Lengkap dengan gelar)
                    </label>
                    <input type="text"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:border-[#243B78]"
                        placeholder="Nama Lengkap">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Jenis Kelamin
                    </label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="jk"> Laki-laki
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="jk"> Perempuan
                        </label>
                    </div>
                </div>

                <!-- Email & HP -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Email</label>
                        <input type="email"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:border-[#243B78]"
                            placeholder="Email">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Nomor Handphone/WA</label>
                        <input type="text"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:border-[#243B78]"
                            placeholder="Nomor telepon">
                    </div>
                </div>

                <!-- Unsur -->
                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Unsur Masyarakat Konstruksi
                    </label>
                    <select
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:border-[#243B78]">
                        <option>Pilih...</option>
                        <option>Instansi Pemerintah</option>
                        <option>Penyedia Jasa</option>
                        <option>Masyarakat Konstruksi</option>
                    </select>
                </div>

                <!-- Instansi & Jabatan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2">
                            Instansi/Lembaga/Nama Perusahaan
                        </label>
                        <input type="text"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:border-[#243B78]"
                            placeholder="Instansi/Lembaga/Nama Perusahaan">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Jabatan</label>
                        <input type="text"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:border-[#243B78]"
                            placeholder="Jabatan di instansi">
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="pt-4">
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-3 rounded-xl transition">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </section>

</div>