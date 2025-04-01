@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#F6D801]']) }}>
    {{ $value ?? $slot }}
</label>
