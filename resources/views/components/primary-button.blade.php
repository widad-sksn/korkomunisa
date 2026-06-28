<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center items-center px-6 py-2.5 bg-theme-primary border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-theme-hover focus:bg-theme-hover active:bg-theme-hover focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-200 shadow-md hover:shadow-lg hover:scale-[1.02] transform']) }}>
    {{ $slot }}
</button>
