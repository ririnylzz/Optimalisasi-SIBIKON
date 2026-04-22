@extends('layouts.admin')

@section('page-title', $title)
@section('page-subtitle', 'Halaman placeholder untuk pengembangan fitur')

@section('content')
    <div class="space-y-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-white">Home</a>
                <span>/</span>
                <span class="font-medium text-slate-200">{{ $title }}</span>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
            <h1 class="text-2xl font-bold">{{ $title }}</h1>
            <p class="mt-3 text-slate-400">
                Halaman ini masih berupa placeholder. Nanti kamu bisa isi dengan tabel data,
                filter pencarian, multiple delete, upload file, atau fitur lain sesuai jobdesk tim.
            </p>

            <div class="mt-6 rounded-xl border border-dashed border-slate-700 bg-slate-950 p-6 text-sm text-slate-500">
                Contoh pengembangan berikutnya:
                <br>• tabel data
                <br>• filter lanjutan
                <br>• bulk action / multiple delete
                <br>• validasi input
                <br>• notifikasi sukses / error
            </div>
        </div>
    </div>
@endsection