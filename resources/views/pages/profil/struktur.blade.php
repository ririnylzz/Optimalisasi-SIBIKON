@extends('layouts.app')

@section('content')
<section class="min-h-screen px-4 py-20 md:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        {{-- Judul Halaman --}}
        <div class="mb-16 text-center">
            <h1 class="text-4xl font-extrabold leading-tight text-[#163B5C] md:text-5xl lg:text-6xl mb-8">
                Struktur Organisasi
            </h1>

            <span class="mx-auto mt-5 block h-1.5 w-32 rounded-full bg-yellow-400"></span>
        </div>

        {{-- Card Gambar Struktur --}}
        <div class="rounded-[28px] bg-white p-5 shadow-sm md:p-7">
            <div class="overflow-hidden rounded-[18px] bg-[#F3F5FC] p-5">

                {{-- Untuk Desktop --}}
                <img
                    src="{{ asset('images/struktur.png') }}"
                    alt="Struktur Organisasi Bidang Bina Konstruksi"
                    class="hidden h-auto w-full rounded-[18px] object-contain md:block">

                {{-- Untuk Mobile: bisa geser horizontal --}}
                <div class="block overflow-x-auto md:hidden">
                    <img
                        src="{{ asset('images/struktur-organisasi.png') }}"
                        alt="Struktur Organisasi Bidang Bina Konstruksi"
                        class="h-auto min-w-[900px] rounded-[18px] object-contain">
                </div>

            </div>
        </div>

    </div>
</section>
@endsection