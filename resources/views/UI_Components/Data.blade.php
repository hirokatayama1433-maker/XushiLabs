<x-layouts.layout>
    {{-- Carousel --}}
<h2>Carousel</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:data.carousel height="220px" :arrows="true" :dots="true" :loop="true">
        <xushi:data.carousel-slide>
            <div style="height:220px; background:var(--xushi-color-primary); display:flex; align-items:center; justify-content:center; color:var(--xushi-color-primary-content); font-size:1.25rem; font-weight:600;">
                Slide 1
            </div>
        </xushi:data.carousel-slide>
        <xushi:data.carousel-slide>
            <div style="height:220px; background:var(--xushi-color-secondary); display:flex; align-items:center; justify-content:center; color:var(--xushi-color-secondary-content); font-size:1.25rem; font-weight:600;">
                Slide 2
            </div>
        </xushi:data.carousel-slide>
        <xushi:data.carousel-slide>
            <div style="height:220px; background:var(--xushi-color-base-300); display:flex; align-items:center; justify-content:center; color:var(--xushi-color-base-content); font-size:1.25rem; font-weight:600;">
                Slide 3
            </div>
        </xushi:data.carousel-slide>
    </xushi:data.carousel>

    {{-- Autoplay variant --}}
    <xushi:data.carousel height="120px" :autoplay="true" :interval="2500" :arrows="false" :dots="true">
        <xushi:data.carousel-slide>
            <div style="height:120px; background:var(--xushi-color-success); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:600;">Autoplay A</div>
        </xushi:data.carousel-slide>
        <xushi:data.carousel-slide>
            <div style="height:120px; background:var(--xushi-color-warning); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:600;">Autoplay B</div>
        </xushi:data.carousel-slide>
        <xushi:data.carousel-slide>
            <div style="height:120px; background:var(--xushi-color-danger); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:600;">Autoplay C</div>
        </xushi:data.carousel-slide>
    </xushi:data.carousel>
</div>

{{-- Table --}}
<h2>Table</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Default solid --}}
    <xushi:data.table>
        <x-slot:header>
            <xushi:data.table-head>Name</xushi:data.table-head>
            <xushi:data.table-head>Role</xushi:data.table-head>
            <xushi:data.table-head>Status</xushi:data.table-head>
        </x-slot:header>
        <tr>
            <xushi:data.table-cell>Zayne Admin</xushi:data.table-cell>
            <xushi:data.table-cell>Lead Developer</xushi:data.table-cell>
            <xushi:data.table-cell>Active</xushi:data.table-cell>
        </tr>
        <tr>
            <xushi:data.table-cell>Jane Smith</xushi:data.table-cell>
            <xushi:data.table-cell>Designer</xushi:data.table-cell>
            <xushi:data.table-cell>Away</xushi:data.table-cell>
        </tr>
        <tr>
            <xushi:data.table-cell>Alex Ray</xushi:data.table-cell>
            <xushi:data.table-cell>Product Manager</xushi:data.table-cell>
            <xushi:data.table-cell>Offline</xushi:data.table-cell>
        </tr>
    </xushi:data.table>

    {{-- Striped + soft variant --}}
    <xushi:data.table variant="soft" :striped="true">
        <x-slot:header>
            <xushi:data.table-head sort="asc" name="product">Product</xushi:data.table-head>
            <xushi:data.table-head sort="desc" name="price">Price</xushi:data.table-head>
            <xushi:data.table-head>Stock</xushi:data.table-head>
        </x-slot:header>
        <tr>
            <xushi:data.table-cell>Widget Pro</xushi:data.table-cell>
            <xushi:data.table-cell>$49.00</xushi:data.table-cell>
            <xushi:data.table-cell>142</xushi:data.table-cell>
        </tr>
        <tr>
            <xushi:data.table-cell>Gadget Lite</xushi:data.table-cell>
            <xushi:data.table-cell>$19.00</xushi:data.table-cell>
            <xushi:data.table-cell>38</xushi:data.table-cell>
        </tr>
        <tr>
            <xushi:data.table-cell>Super Donut</xushi:data.table-cell>
            <xushi:data.table-cell>$9.00</xushi:data.table-cell>
            <xushi:data.table-cell>0</xushi:data.table-cell>
        </tr>
    </xushi:data.table>
</div>

{{-- Timeline --}}
<h2>Timeline</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:data.timeline>
        <xushi:data.timeline-item
            title="Project kicked off"
            timestamp="Jan 1, 2025"
            color="primary"
            icon="rocket"
        >
            Initial planning and team onboarding completed.
        </xushi:data.timeline-item>

        <xushi:data.timeline-item
            title="Alpha released"
            timestamp="Mar 15, 2025"
            color="info"
            icon="package"
        >
            First internal alpha shipped to early testers.
        </xushi:data.timeline-item>

        <xushi:data.timeline-item
            title="Bug squashed"
            timestamp="Apr 3, 2025"
            color="warning"
            icon="bug"
        >
            Critical rendering issue fixed across all themes.
        </xushi:data.timeline-item>

        <xushi:data.timeline-item
            title="v1.0 shipped"
            timestamp="May 20, 2025"
            color="success"
            icon="check-circle"
            :last="true"
        >
            Public release. XushiUI v1.0 is live.
        </xushi:data.timeline-item>
    </xushi:data.timeline>
</div>
</x-layouts.layout>