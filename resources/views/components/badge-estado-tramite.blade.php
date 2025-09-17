@props(['estadoTramite'])

@if ($estadoTramite)
    <span
        class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap min-w-[120px] text-center
        @if ($estadoTramite === 'En trámite') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
        @elseif($estadoTramite === 'Finalizado') bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200
        @elseif($estadoTramite === 'No iniciado') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
        @elseif($estadoTramite === 'Exceptuado') bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-200
        @elseif($estadoTramite === 'Inconsistencia') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
        @else bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 @endif">
        {{ $estadoTramite }}
    </span>
@else
    <span class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap min-w-[120px] text-center bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
        Sin estado
    </span>
@endif
