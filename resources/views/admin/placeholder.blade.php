@extends('layouts.admin')

@section('page-title', $title)
@section('page-subtitle', 'Halaman placeholder untuk pengembangan fitur')

@section('content')
    <div class="space-y-6">
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900">Home</a>
                <span>/</span>
                <span class="font-medium text-slate-800">{{ $title }}</span>
            </div>
        </div>

        <div class="sibikon-card rounded-[28px] p-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $title }}</h1>
            <p class="mt-4 max-w-3xl leading-7 text-slate-500">
                Halaman ini masih berupa placeholder. Nanti bisa kamu isi dengan tabel data,
                filter pencarian, multiple delete, upload file, validasi input, atau modul lain
                sesuai kebutuhan pengembangan dashboard admin SIBIKON.
            </p>

            <div class="mt-8 rounded-[24px] bg-slate-50 p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Next Development</p>
                <div class="mt-4 grid gap-3 md:grid-cols-2">
                    <div class="rounded-2xl bg-white px-4 py-4 shadow-sm">
                        <p class="font-semibold text-slate-800">Tabel Data Dinamis</p>
                        <p class="mt-1 text-sm text-slate-500">Menampilkan data utama dengan pagination dan filter.</p>
                    </div>
                    <div class="rounded-2xl bg-white px-4 py-4 shadow-sm">
                        <p class="font-semibold text-slate-800">Filter & Search</p>
                        <p class="mt-1 text-sm text-slate-500">Pencarian yang lebih lengkap dan fleksibel.</p>
                    </div>
                    <div class="rounded-2xl bg-white px-4 py-4 shadow-sm">
                        <p class="font-semibold text-slate-800">Bulk Action</p>
                        <p class="mt-1 text-sm text-slate-500">Multiple delete dan aksi massal lainnya.</p>
                    </div>
                    <div class="rounded-2xl bg-white px-4 py-4 shadow-sm">
                        <p class="font-semibold text-slate-800">Validasi & Notifikasi</p>
                        <p class="mt-1 text-sm text-slate-500">Validasi input serta feedback sukses atau error.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection