@props([
    'title',
    'canvas',
    'height' => 'h-[230px]',
])

<div class="sibikon-card overflow-hidden rounded-[20px] transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_18px_40px_rgba(20,43,103,0.10)]">
    <div class="border-b border-slate-100 bg-white px-4 py-3">
        <h3 class="text-base font-extrabold text-slate-900">{{ $title }}</h3>
    </div>

    <div class="bg-white p-4">
        <div class="{{ $height }}">
            <canvas id="{{ $canvas }}"></canvas>
        </div>
    </div>
</div>