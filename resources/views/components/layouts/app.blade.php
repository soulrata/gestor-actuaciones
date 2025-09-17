{{-- 
    TODO: Cambiar menu superior y barra side
--}}
{{-- <x-layouts.app.header :title="$title ?? null"> --}}
<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('js')
    <x-alert-toast timer="5000" />
{{-- </x-layouts.app.header> --}}
</x-layouts.app.sidebar>
