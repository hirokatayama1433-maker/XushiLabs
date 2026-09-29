<xushi:header>
    <x-slot:left>
        <xushi:header-brand
            name="{{ config('app.name') }}"
            href="/"
        />
    </x-slot:left>

    <xushi:header-nav>
        <xushi:header-navitem href="/" :active="request()->is('/')">
            Home
        </xushi:header-navitem>
    </xushi:header-nav>

    <x-slot:right>
        <xushi:header-search placeholder="Search..." />
        <xushi:header-avatar
            name="{{ auth()->user()->name ?? 'Guest' }}"
        />
    </x-slot:right>
</xushi:header>