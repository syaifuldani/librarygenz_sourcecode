@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-cream-300 bg-cream-50/20 text-navy-900 focus:border-coral-500 focus:ring-coral-500 rounded-lg shadow-sm placeholder-navy-300 text-sm transition-all duration-150']) }}>
