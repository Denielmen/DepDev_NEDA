{{-- filepath: d:\DepDev_NEDA\resources\views\components\input-label.blade.php --}}
<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>