@props([
    'title',
    'containerClass' => 'max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8',
    'theme' => 'default', // permohonan | keberatan | default (biru muda sistem)
])

@php
$gradientClass = match($theme) {
    'keberatan' => 'bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700',
    'permohonan' => 'bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700',
    default => 'bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700',
};

$accentClass = match($theme) {
    'keberatan' => 'bg-sky-400/20',
    'permohonan' => 'bg-sky-400/20',
    default => 'bg-sky-400/20',
};

$textAccentClass = match($theme) {
    'keberatan' => 'text-sky-100',
    'permohonan' => 'text-sky-100',
    default => 'text-sky-100',
};
@endphp

<section class="{{ $gradientClass }} text-white py-12 md:py-16 relative overflow-hidden shadow-md">
    <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
    <div class="absolute -left-16 -bottom-16 w-80 h-80 rounded-full {{ $accentClass }} blur-2xl pointer-events-none"></div>

    <div class="{{ $containerClass }} relative z-10 space-y-4">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
            {{ $title }}
        </h1>

        <p class="w-full max-w-none {{ $textAccentClass }} text-sm sm:text-base font-normal leading-relaxed">
            {{ $slot }}
        </p>
    </div>
</section>
