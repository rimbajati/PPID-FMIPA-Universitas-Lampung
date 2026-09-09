@props(['name'])

@error($name)
    <div class="flex items-center gap-1.5 text-xs font-bold text-rose-600 mt-1 animate-in fade-in duration-150">
        <i class="fa-solid fa-circle-exclamation text-[11px]"></i>
        <span>{{ $message }}</span>
    </div>
@enderror

<template x-if="errors && errors['{{ $name }}']">
    <div class="flex items-center gap-1.5 text-xs font-bold text-rose-600 mt-1 animate-in fade-in duration-150">
        <i class="fa-solid fa-circle-exclamation text-[11px]"></i>
        <span x-text="errors['{{ $name }}']"></span>
    </div>
</template>
