@props(['active'])

@php
$activeColor = '#FFB5B5'; // rosa fuerte
$hoverColor = '#FFD5D5'; // rosa
$focusColor = '#FFE5E5'; // rosa claro
$defaultColor = '#FFF5F5'; // rosa muy claro
$textColorActive = 'text-gray-900'; // texto cuando está activo
$textColorDefault = 'text-gray-500'; // texto por defecto

$classes = ($active ?? false)
            ? "inline-flex items-center px-1 pt-1 border-b-2 border-$activeColor text-sm font-medium leading-5 $textColorActive focus:outline-none focus:border-$focusColor transition duration-150 ease-in-out"
            : "inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 $textColorDefault hover:text-gray-700 hover:border-$hoverColor focus:outline-none focus:text-gray-700 focus:border-$focusColor transition duration-150 ease-in-out";
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
