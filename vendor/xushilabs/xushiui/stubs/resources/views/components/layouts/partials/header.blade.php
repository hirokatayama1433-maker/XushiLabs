<xushi:layout.header>
    <x-slot:left>
        <xushi:layout.header.brand
            name="{{ config('app.name') }}"
            href="/"
        />
    </x-slot:left>

    <xushi:layout.header.nav>
        <xushi:layout.header.nav.item href="/" :active="request()->is('/')">
            Home
        </xushi:layout.header.nav.item>
    </xushi:layout.header.nav>

    <x-slot:right>
        <xushi:layout.header.search placeholder="Search..." />
        <xushi:layout.header.avatar
            name="{{ auth()->user()->name ?? 'Guest' }}"
        />
    </x-slot:right>
</xushi:layout.header>