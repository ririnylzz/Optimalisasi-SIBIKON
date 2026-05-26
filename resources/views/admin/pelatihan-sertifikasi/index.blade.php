@extends('layouts.admin')

@section('page-title', 'Pelatihan dan Sertifikasi TKK Ahli')
@section('page-subtitle', 'Daftar kegiatan pelatihan dan sertifikasi tenaga kerja konstruksi')

@section('content')

@php
    $openCreateModal = $errors->any() && old('_form_mode', 'create') === 'create';

    $serverErrorMessage = $errors->any()
        ? 'Periksa kembali field yang wajib diisi.'
        : null;
@endphp

{{-- TOAST NOTIFICATION --}}
<div
    id="toastNotification"
    class="fixed right-6 top-6 z-[99999] hidden w-full max-w-sm overflow-hidden rounded-2xl shadow-2xl">

    <div id="toastBox" class="flex items-start gap-4 px-5 py-4 text-white">
        <div id="toastIcon" class="mt-0.5 text-xl font-bold">
            ✓
        </div>

        <div class="min-w-0 flex-1">
            <p id="toastTitle" class="text-sm font-extrabold">
                Berhasil
            </p>

            <p id="toastMessage" class="mt-1 text-sm leading-relaxed">
                Data berhasil diproses.
            </p>
        </div>

        <button
            type="button"
            id="toastClose"
            class="text-2xl font-light leading-none text-white/80 transition hover:text-white">
            &times;
        </button>
    </div>
</div>

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">
                Daftar Kegiatan
            </h1>
        </div>

        <button
            type="button"
            data-modal-target="modalPelatihan"
            class="inline-flex items-center rounded-xl bg-[#28428B] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#1d3270]">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="mr-2 h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4" />
            </svg>

            Tambah Data
        </button>
    </div>

    {{-- CARD TABLE --}}
    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">

        {{-- FILTER --}}
        <div class="border-b border-slate-200 px-6 py-5">

            <form method="GET" action="{{ route('admin.pelatihan-sertifikasi.index') }}">

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    <div class="relative w-full max-w-md">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            🔍
                        </span>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari kegiatan, jabatan kerja, lokasi..."
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-[#28428B] focus:bg-white focus:ring-4 focus:ring-blue-100">

                    </div>

                    <div class="text-sm text-slate-500">
                        Total Data :
                        <span class="font-bold text-slate-700">
                            {{ $pelatihan->total() }}
                        </span>
                    </div>

                </div>

            </form>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Nama Kegiatan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Waktu Pelaksanaan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Peserta
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Jabatan Kerja
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Tempat
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Lokasi
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">

                    @forelse($pelatihan as $item)

                        @php
                            $waktuPelaksanaan = $item->waktu_kegiatan ?? $item->tanggal_mulai;
                            $peserta = $item->realisasi_peserta ?? $item->peserta ?? 0;
                            $jabatanKerja = $item->standar_kompetensi ?? $item->jabatan_kerja ?? '-';
                            $tempat = $item->tempat_kegiatan ?? $item->tempat ?? '-';
                            $lokasi = $item->kabupaten_kota ?? $item->lokasi ?? $item->provinsi ?? '-';
                        @endphp

                        <tr class="transition hover:bg-slate-50">

                            <td class="px-6 py-5 text-sm text-slate-500">
                                {{ $pelatihan->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="max-w-[350px]">
                                    <p class="font-semibold text-slate-800">
                                        {{ $item->nama_kegiatan }}
                                    </p>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-5 text-sm text-slate-600">
                                @if ($waktuPelaksanaan)
                                    {{ \Carbon\Carbon::parse($waktuPelaksanaan)->translatedFormat('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-6 py-5 text-sm font-semibold text-slate-700">
                                {{ $peserta }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $jabatanKerja }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $tempat }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $lokasi }}
                            </td>

                        <td class="px-6 py-5">

                            <div class="flex items-center justify-center gap-2">

                                {{-- EDIT --}}
                                <button
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-amber-200 bg-amber-50 text-amber-600 transition hover:bg-amber-100">

                                    ✏️

                                </button>

                                {{-- DELETE --}}
                                <button
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-rose-200 bg-rose-50 text-rose-600 transition hover:bg-rose-100">

                                    🗑️

                                </button>

                            </div>

                        </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="mb-4 text-5xl">
                                        📁
                                    </div>

                                    <h3 class="text-lg font-bold text-slate-700">
                                        Belum Ada Data
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Data pelatihan dan sertifikasi belum tersedia.
                                    </p>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="border-t border-slate-200 px-6 py-4">
            {{ $pelatihan->links() }}
        </div>

    </div>

</div>

{{-- GLOBAL ACTION DROPDOWN --}}
<div
    id="actionDropdownMenu"
    class="fixed z-[9999] hidden w-56 overflow-hidden rounded-xl border border-slate-200 bg-white text-left shadow-xl">

    <button
        type="button"
        id="actionEditButton"
        class="block w-full px-5 py-3 text-left text-sm font-medium text-slate-700 transition hover:bg-slate-50">
        Edit Kegiatan
    </button>

    <button
        type="button"
        id="actionDetailButton"
        class="block w-full px-5 py-3 text-left text-sm font-medium text-slate-700 transition hover:bg-slate-50">
        Detail Kegiatan
    </button>

    <div class="border-t border-slate-200"></div>

    <button
        type="button"
        id="actionDeleteButton"
        class="block w-full px-5 py-3 text-left text-sm font-medium text-rose-600 transition hover:bg-rose-50">
        Hapus Kegiatan
    </button>
</div>

<form
    id="deletePelatihanForm"
    action="#"
    method="POST"
    class="hidden">
    @csrf
    @method('DELETE')
</form>

{{-- MODAL TAMBAH DATA --}}
<div
    id="modalPelatihan"
    class="fixed inset-0 z-50 {{ $openCreateModal ? 'flex' : 'hidden' }} items-center justify-center bg-black/50 p-4">

    <div class="max-h-[95vh] w-full max-w-5xl overflow-y-auto rounded-3xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Form Pelatihan
                </h2>
            </div>

            <button
                type="button"
                data-modal-close
                class="rounded-xl p-2 text-slate-500 hover:bg-slate-100">
                ✕
            </button>
        </div>

        <form
            action="{{ route('admin.pelatihan-sertifikasi.store') }}"
            method="POST"
            novalidate
            class="pelatihan-form space-y-5 p-6">

            @csrf

            <input type="hidden" name="_form_mode" value="create">

            @include('admin.pelatihan-sertifikasi.partials.form-fields', [
                'mode' => 'create',
                'prefix' => 'create',
                'pelatihanItem' => null,
            ])

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">

                <button
                    type="button"
                    data-modal-close
                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-[#28428B] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1d3270]">
                    Simpan Data
                </button>

            </div>

        </form>

    </div>

</div>

{{-- MODAL EDIT DATA --}}
<div
    id="modalEditPelatihan"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="max-h-[95vh] w-full max-w-5xl overflow-y-auto rounded-3xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Edit Kegiatan
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Ubah data kegiatan pelatihan dan sertifikasi.
                </p>
            </div>

            <button
                type="button"
                data-edit-modal-close
                class="rounded-xl p-2 text-slate-500 hover:bg-slate-100">
                ✕
            </button>
        </div>

        <form
            id="editPelatihanForm"
            action="#"
            method="POST"
            novalidate
            class="pelatihan-form space-y-5 p-6">

            @csrf
            @method('PUT')

            <input type="hidden" name="_form_mode" value="edit">

            @include('admin.pelatihan-sertifikasi.partials.form-fields', [
                'mode' => 'edit',
                'prefix' => 'edit',
                'pelatihanItem' => null,
            ])

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">

                <button
                    type="button"
                    data-edit-modal-close
                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-[#28428B] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1d3270]">
                    Update Data
                </button>

            </div>

        </form>

    </div>

</div>

{{-- SCRIPT MODAL + VALIDASI FORM + GLOBAL DROPDOWN + TOAST --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const toastNotification = document.getElementById('toastNotification');
    const toastBox = document.getElementById('toastBox');
    const toastIcon = document.getElementById('toastIcon');
    const toastTitle = document.getElementById('toastTitle');
    const toastMessage = document.getElementById('toastMessage');
    const toastClose = document.getElementById('toastClose');

    let toastTimer = null;

    function showToast(type, title, message) {
        if (!toastNotification || !toastBox) {
            return;
        }

        clearTimeout(toastTimer);

        toastBox.classList.remove('bg-emerald-500', 'bg-rose-500');

        if (type === 'success') {
            toastBox.classList.add('bg-emerald-500');
            toastIcon.textContent = '✓';
        } else {
            toastBox.classList.add('bg-rose-500');
            toastIcon.textContent = '!';
        }

        toastTitle.textContent = title;
        toastMessage.textContent = message;

        toastNotification.classList.remove('hidden');

        toastTimer = setTimeout(function () {
            toastNotification.classList.add('hidden');
        }, 3500);
    }

    if (toastClose) {
        toastClose.addEventListener('click', function () {
            toastNotification.classList.add('hidden');
            clearTimeout(toastTimer);
        });
    }

    @if (session('success'))
        showToast('success', 'Berhasil', @json(session('success')));
    @endif

    @if ($serverErrorMessage)
        showToast('error', 'Gagal', @json($serverErrorMessage));
    @endif

    const modalCreate = document.getElementById('modalPelatihan');
    const modalEdit = document.getElementById('modalEditPelatihan');
    const editForm = document.getElementById('editPelatihanForm');

    const actionDropdownMenu = document.getElementById('actionDropdownMenu');
    const actionEditButton = document.getElementById('actionEditButton');
    const actionDetailButton = document.getElementById('actionDetailButton');
    const actionDeleteButton = document.getElementById('actionDeleteButton');
    const deletePelatihanForm = document.getElementById('deletePelatihanForm');

    let activeActionButton = null;

    const kabupatenData = {
        "Kalimantan Timur": [
            "Samarinda",
            "Balikpapan",
            "Bontang",
            "Kutai Kartanegara",
            "Kutai Timur",
            "Kutai Barat",
            "Berau",
            "Paser",
            "Penajam Paser Utara",
            "Mahakam Ulu"
        ],
        "DKI Jakarta": [
            "Jakarta Pusat",
            "Jakarta Barat",
            "Jakarta Timur",
            "Jakarta Selatan",
            "Jakarta Utara",
            "Kepulauan Seribu"
        ],
        "Jawa Barat": [
            "Bandung",
            "Bekasi",
            "Bogor",
            "Depok",
            "Cimahi",
            "Tasikmalaya"
        ],
        "Jawa Timur": [
            "Surabaya",
            "Malang",
            "Kediri",
            "Madiun",
            "Blitar"
        ],
        "Sulawesi Selatan": [
            "Makassar",
            "Parepare",
            "Palopo"
        ]
    };

    function renderKabupatenOptions(prefix, selectedProvinsi, selectedKabupaten = null) {
        const kabupatenSelect = document.getElementById(prefix + '_kabupaten');

        if (!kabupatenSelect) {
            return;
        }

        kabupatenSelect.innerHTML = '';

        if (!selectedProvinsi || !kabupatenData[selectedProvinsi]) {
            kabupatenSelect.innerHTML = '<option value="">Pilih provinsi dulu...</option>';
            return;
        }

        kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';

        kabupatenData[selectedProvinsi].forEach(function (kabupaten) {
            const option = document.createElement('option');

            option.value = kabupaten;
            option.textContent = kabupaten;

            if (selectedKabupaten && selectedKabupaten === kabupaten) {
                option.selected = true;
            }

            kabupatenSelect.appendChild(option);
        });
    }

    function clearSingleFieldError(field) {
        const wrapper = field.closest('.field-group');
        const errorText = wrapper ? wrapper.querySelector('.form-field-error') : null;

        if (errorText) {
            errorText.textContent = '';
            errorText.classList.add('hidden');
        }
    }

    function showSingleFieldError(field, message) {
        const wrapper = field.closest('.field-group');
        const errorText = wrapper ? wrapper.querySelector('.form-field-error') : null;

        if (errorText) {
            errorText.textContent = message;
            errorText.classList.remove('hidden');
        }
    }

    function validatePelatihanForm(form) {
        let valid = true;
        let firstInvalidField = null;

        form.querySelectorAll('.form-control-field').forEach(function (field) {
            clearSingleFieldError(field);

            const value = String(field.value || '').trim();
            const label = field.dataset.label || 'Field ini';

            if (field.dataset.required === 'true' && !value) {
                valid = false;
                showSingleFieldError(field, label + ' wajib diisi.');

                if (!firstInvalidField) {
                    firstInvalidField = field;
                }

                return;
            }

            if (value && field.dataset.numberMin !== undefined) {
                const minValue = Number(field.dataset.numberMin);
                const numberValue = Number(value);

                if (Number.isNaN(numberValue) || numberValue < minValue) {
                    valid = false;

                    if (minValue === 1) {
                        showSingleFieldError(field, label + ' minimal 1.');
                    } else {
                        showSingleFieldError(field, label + ' harus berupa angka yang valid.');
                    }

                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                }
            }
        });

        if (!valid && firstInvalidField) {
            showToast('error', 'Gagal', 'Lengkapi field yang wajib diisi.');

            firstInvalidField.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            setTimeout(function () {
                firstInvalidField.focus();
            }, 250);
        }

        return valid;
    }

    function setField(name, value) {
        const field = editForm.querySelector('[name="' + name + '"]');

        if (field) {
            field.value = value || '';
            clearSingleFieldError(field);
        }
    }

    document.querySelectorAll('.pelatihan-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!validatePelatihanForm(form)) {
                event.preventDefault();
                event.stopPropagation();
            }
        });

        form.querySelectorAll('.form-control-field').forEach(function (field) {
            field.addEventListener('input', function () {
                clearSingleFieldError(field);
            });

            field.addEventListener('change', function () {
                clearSingleFieldError(field);
            });
        });
    });

    function hideActionDropdown() {
        if (!actionDropdownMenu) {
            return;
        }

        actionDropdownMenu.classList.add('hidden');
        activeActionButton = null;
    }

    function showActionDropdown(button) {
        const rect = button.getBoundingClientRect();
        const menuWidth = 224;
        const menuHeight = 150;

        let top = rect.bottom + 8;
        let left = rect.right - menuWidth;

        if (left < 12) {
            left = rect.left;
        }

        if (top + menuHeight > window.innerHeight - 12) {
            top = rect.top - menuHeight - 8;
        }

        actionDropdownMenu.style.top = `${top}px`;
        actionDropdownMenu.style.left = `${left}px`;

        actionDropdownMenu.classList.remove('hidden');
        activeActionButton = button;
    }

    document.querySelectorAll('[data-modal-target]').forEach(button => {
        button.addEventListener('click', function () {
            modalCreate.classList.remove('hidden');
            modalCreate.classList.add('flex');
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach(button => {
        button.addEventListener('click', function () {
            modalCreate.classList.add('hidden');
            modalCreate.classList.remove('flex');
        });
    });

    document.querySelectorAll('[data-edit-modal-close]').forEach(button => {
        button.addEventListener('click', function () {
            modalEdit.classList.add('hidden');
            modalEdit.classList.remove('flex');
        });
    });

    document.querySelectorAll('.action-dropdown-trigger').forEach(button => {
        button.addEventListener('click', function (event) {
            event.stopPropagation();

            if (activeActionButton === button && !actionDropdownMenu.classList.contains('hidden')) {
                hideActionDropdown();
                return;
            }

            showActionDropdown(button);
        });
    });

    actionDropdownMenu.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    document.addEventListener('click', function () {
        hideActionDropdown();
    });

    window.addEventListener('scroll', hideActionDropdown, true);
    window.addEventListener('resize', hideActionDropdown);

    actionEditButton.addEventListener('click', function () {
        if (!activeActionButton) {
            return;
        }

        editForm.action = activeActionButton.dataset.updateUrl;

        setField('tahun', activeActionButton.dataset.tahun);
        setField('status', ['dibuka', 'selesai'].includes(activeActionButton.dataset.status) ? activeActionButton.dataset.status : '');
        setField('jenis_peserta', activeActionButton.dataset.jenisPeserta);
        setField('metode_kegiatan', activeActionButton.dataset.metodeKegiatan);
        setField('nama_kegiatan', activeActionButton.dataset.namaKegiatan);
        setField('waktu_kegiatan', activeActionButton.dataset.waktuKegiatan);
        setField('realisasi_peserta', activeActionButton.dataset.realisasiPeserta);
        setField('sumber_dana', activeActionButton.dataset.sumberDana);
        setField('standar_kompetensi', activeActionButton.dataset.standarKompetensi);
        setField('tuk', activeActionButton.dataset.tuk);
        setField('lsp', activeActionButton.dataset.lsp);
        setField('tempat_kegiatan', activeActionButton.dataset.tempatKegiatan);
        setField('provinsi', activeActionButton.dataset.provinsi);
        setField('syarat_tambahan', activeActionButton.dataset.syaratTambahan);

        renderKabupatenOptions('edit', activeActionButton.dataset.provinsi, activeActionButton.dataset.kabupatenKota);

        hideActionDropdown();

        modalEdit.classList.remove('hidden');
        modalEdit.classList.add('flex');
    });

    actionDetailButton.addEventListener('click', function () {
        if (!activeActionButton) {
            return;
        }

        window.location.href = activeActionButton.dataset.detailUrl;
    });

    actionDeleteButton.addEventListener('click', function () {
        if (!activeActionButton) {
            return;
        }

        if (!confirm('Yakin ingin menghapus kegiatan ini?')) {
            return;
        }

        deletePelatihanForm.action = activeActionButton.dataset.deleteUrl;
        deletePelatihanForm.submit();
    });

    const createProvinsiSelect = document.getElementById('create_provinsi');

    if (createProvinsiSelect) {
        createProvinsiSelect.addEventListener('change', function () {
            renderKabupatenOptions('create', this.value);
        });
    }

    const editProvinsiSelect = document.getElementById('edit_provinsi');

    if (editProvinsiSelect) {
        editProvinsiSelect.addEventListener('change', function () {
            renderKabupatenOptions('edit', this.value);
        });
    }

});
</script>

@endsection