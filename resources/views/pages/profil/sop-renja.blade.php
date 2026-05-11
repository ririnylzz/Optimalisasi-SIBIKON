@extends('layouts.app')

@section('content')
<section class="min-h-screen px-4 py-16 md:px-6 lg:px-8">
    <div class="mx-auto max-w-6xl space-y-20">

        {{-- SOP --}}
        <div>
            <h1 class="mb-5 text-2xl font-extrabold text-[#163B5C] md:text-3xl">
                Standar Operasional Prosedur (SOP)
            </h1>

            <span class="mb-5 mt-5 block h-1.5 w-32 rounded-full bg-yellow-400"></span>

            <div class="rounded-2xl bg-white p-3 shadow-[0_12px_30px_rgba(15,23,42,0.16)]">
                <div class="overflow-hidden rounded-xl border border-[#cbd5e1] bg-[#2f2f2f]">
                    <iframe
                        src="{{ asset('files/sop-bikon.pdf') }}"
                        class="h-[520px] w-full"
                        title="Standar Operasional Prosedur"
                        loading="lazy">
                    </iframe>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-4">
                <a href="{{ asset('files/sop-bikon.pdf') }}"
                    target="_blank"
                    class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-blue-700">
                    Buka di Tab Baru
                </a>

                <a href="{{ asset('files/sop-bikon.pdf') }}"
                    download
                    class="inline-flex items-center justify-center rounded-lg bg-yellow-400 px-7 py-3 text-sm font-bold text-slate-900 transition hover:bg-yellow-300">
                    Download
                </a>
            </div>
        </div>

        {{-- Renja --}}
        <div>
            <h2 class="mb-5 text-2xl font-extrabold text-[#163B5C] md:text-3xl">
                Rencana Kerja (Renja)
            </h2>

            <span class="mb-5 mt-5 block h-1.5 w-32 rounded-full bg-yellow-400"></span>

            <div class="rounded-2xl bg-white p-3 shadow-[0_12px_30px_rgba(15,23,42,0.16)]">
                <div class="overflow-hidden rounded-xl border border-[#cbd5e1] bg-[#2f2f2f]">
                    <iframe
                        src="{{ asset('files/renja.pdf') }}"
                        class="h-[520px] w-full"
                        title="Rencana Kerja"
                        loading="lazy">
                    </iframe>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-4">
                <a href="{{ asset('files/renja.pdf') }}"
                    target="_blank"
                    class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-blue-700">
                    Buka di Tab Baru
                </a>

                <a href="{{ asset('files/renja.pdf') }}"
                    download
                    class="inline-flex items-center justify-center rounded-lg bg-yellow-400 px-7 py-3 text-sm font-bold text-slate-900 transition hover:bg-yellow-300">
                    Download
                </a>
            </div>
        </div>

    </div>
</section>
@endsection