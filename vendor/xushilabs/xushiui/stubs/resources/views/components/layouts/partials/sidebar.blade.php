<xushi:layout.sidebar>
    <x-slot:header>
        <xushi:layout.sidebar.brand name="{{ config('app.name') }}" href="/" />
    </x-slot:header>

    <xushi:layout.sidebar.label title="Menu" />

    <xushi:layout.sidebar.navitem href="/">
        <x-slot:lefticon>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" style="width:1.125rem;height:1.125rem;">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
        </x-slot:lefticon>
        Dashboard
    </xushi:layout.sidebar.navitem>

    <x-slot:footer>
        <xushi:layout.sidebar.avatar
            name="{{ auth()->user()->name ?? 'Guest' }}"
            :src="auth()->user()->avatar_url ?? null"
        />
        <xushi:layout.sidebar.toggle />
    </x-slot:footer>
</xushi:layout.sidebar>
