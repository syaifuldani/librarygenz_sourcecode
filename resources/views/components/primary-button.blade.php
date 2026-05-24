<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-coral-500 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-wider hover:bg-coral-600 focus:bg-coral-600 active:bg-coral-700 focus:outline-none focus:ring-2 focus:ring-coral-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm shadow-coral-500/20 cursor-pointer']) }}>
    {{ $slot }}
</button>
