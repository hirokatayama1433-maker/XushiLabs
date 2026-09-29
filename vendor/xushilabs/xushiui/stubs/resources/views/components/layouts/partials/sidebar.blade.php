<xushi:sidebar>
    <x-slot:header>
        <xushi:sidebar-brand name="{{ config('app.name') }}" href="/" />
    </x-slot:header>

    <xushi:sidebar-label title="Menu" />

    <xushi:sidebar-navitem href="/" icon="house">
        Dashboard
    </xushi:sidebar-navitem>

    <x-slot:footer>
        <xushi:sidebar-avatar
            name="{{ auth()->user()->name ?? 'Guest' }}"
            :src="auth()->user()->avatar_url ?? null"
        />
    </x-slot:footer>
</xushi:sidebar>
