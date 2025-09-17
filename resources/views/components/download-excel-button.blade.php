@props([
    'route',
    'params' => [],
    'label' => 'Descargar Excel',
    'size' => 'sm',
    'color' => 'green',
    'icon' => true
])

@php
    $colorStyles = [
        'green' => 'background-color: #16a34a; hover:background-color: #15803d;',
        'red' => 'background-color: #dc2626; hover:background-color: #b91c1c;',
        'blue' => 'background-color: #2563eb; hover:background-color: #1d4ed8;',
        'yellow' => 'background-color: #ca8a04; hover:background-color: #a16207;',
        'orange' => 'background-color: #ea580c; hover:background-color: #c2410c;',
        'purple' => 'background-color: #9333ea; hover:background-color: #7c3aed;',
        'gray' => 'background-color: #6b7280; hover:background-color: #4b5563;',
        'navy' => 'background-color: #1e3a8a; hover:background-color: #1e40af;',
    ];
    
    $style = $colorStyles[$color] ?? $colorStyles['green'];
@endphp

<a href="{{ route($route, $params) }}" 
   class="text-white text-xs px-3 py-1 rounded-md transition-colors duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-1 text-center"
   style="{{ $style }}"
   title="{{ $label }}">
    @if($icon)
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
    @endif
    <span>{{ $label }}</span>
</a>
