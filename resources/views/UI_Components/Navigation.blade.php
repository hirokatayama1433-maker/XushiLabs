<x-layouts.layout>
    {{-- Breadcrumbs --}}
<h2>Breadcrumbs</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Default separator --}}
    <xushi:navigation.breadcrumbs>
        <xushi:navigation.breadcrumb-item href="/">Home</xushi:navigation.breadcrumb-item>
        <xushi:navigation.breadcrumb-item href="/settings">Settings</xushi:navigation.breadcrumb-item>
        <xushi:navigation.breadcrumb-item :current="true">Profile</xushi:navigation.breadcrumb-item>
    </xushi:navigation.breadcrumbs>

    {{-- Custom separator --}}
    <xushi:navigation.breadcrumbs separator="›" size="md">
        <xushi:navigation.breadcrumb-item href="/">Dashboard</xushi:navigation.breadcrumb-item>
        <xushi:navigation.breadcrumb-item href="/users">Users</xushi:navigation.breadcrumb-item>
        <xushi:navigation.breadcrumb-item :current="true">Edit</xushi:navigation.breadcrumb-item>
    </xushi:navigation.breadcrumbs>
</div>

{{-- Menu --}}
<h2>Menu</h2>
<div style="
    display: flex;
    gap: 10px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Basic menu --}}
    <xushi:navigation.menu style="min-width: 200px; border: 1px solid var(--xushi-color-base-border); border-radius: var(--xushi-radius-box);">
        <xushi:navigation.menu-item icon="layout-dashboard" href="/dashboard">Dashboard</xushi:navigation.menu-item>
        <xushi:navigation.menu-item icon="users" href="/users">Users</xushi:navigation.menu-item>
        <xushi:navigation.menu-item icon="settings" href="/settings">Settings</xushi:navigation.menu-item>
        <xushi:navigation.menu-item icon="log-out" color="danger">Sign out</xushi:navigation.menu-item>
    </xushi:navigation.menu>

    {{-- Grouped with label --}}
    <xushi:navigation.menu label="Account" style="min-width: 200px; border: 1px solid var(--xushi-color-base-border); border-radius: var(--xushi-radius-box);">
        <xushi:navigation.menu-item icon="user" href="/profile">Profile</xushi:navigation.menu-item>
        <xushi:navigation.menu-item icon="bell" href="/notifications">
            Notifications
            <x-slot:right>
                <xushi:feedback.badge variant="solid" color="danger" size="sm">3</xushi:feedback.badge>
            </x-slot:right>
        </xushi:navigation.menu-item>
        <xushi:navigation.menu-item icon="credit-card" href="/billing">Billing</xushi:navigation.menu-item>
        <xushi:navigation.menu-item icon="trash" color="danger" :disabled="true">Delete account</xushi:navigation.menu-item>
    </xushi:navigation.menu>
</div>

{{-- Pagination --}}
<h2>Pagination</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 10px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Solid (default) — Alpine-driven --}}
    <xushi:navigation.pagination
        variant="solid"
        :current="3"
        :total="10"
        :pages="[1, 2, 3, 4, 5, '...', 10]"
        btnBase="display:inline-flex; align-items:center; justify-content:center; min-width:2.25rem; height:2.25rem; padding:0 0.5rem; font-size:0.875rem; font-family:inherit; border-radius:var(--xushi-radius-field); cursor:pointer; text-decoration:none; transition:background 120ms ease;"
    />

    {{-- Ghost variant --}}
    <xushi:navigation.pagination
        variant="ghost"
        :current="1"
        :total="5"
        :pages="[1, 2, 3, 4, 5]"
        btnBase="display:inline-flex; align-items:center; justify-content:center; min-width:2.25rem; height:2.25rem; padding:0 0.5rem; font-size:0.875rem; font-family:inherit; border-radius:var(--xushi-radius-field); cursor:pointer; text-decoration:none; transition:background 120ms ease;"
    />

    {{-- Outline variant with href --}}
    <xushi:navigation.pagination
        variant="outline"
        :current="2"
        :total="8"
        :pages="[1, 2, 3, '...', 8]"
        href="/posts?page={page}"
        btnBase="display:inline-flex; align-items:center; justify-content:center; min-width:2.25rem; height:2.25rem; padding:0 0.5rem; font-size:0.875rem; font-family:inherit; border-radius:var(--xushi-radius-field); cursor:pointer; text-decoration:none; transition:background 120ms ease;"
    />
</div>

{{-- Tabs --}}
<h2>Tabs</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 10px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Underline (default) --}}
    <xushi:navigation.tab defaultopen="tab1" variant="underline">
        <x-slot:tabs>
            <xushi:navigation.tab-item value="tab1" icon="home">Overview</xushi:navigation.tab-item>
            <xushi:navigation.tab-item value="tab2" icon="users">Team</xushi:navigation.tab-item>
            <xushi:navigation.tab-item value="tab3" icon="settings">Settings</xushi:navigation.tab-item>
            <xushi:navigation.tab-item value="tab4" :disabled="true">Billing</xushi:navigation.tab-item>
        </x-slot:tabs>

        <xushi:navigation.tab-panel value="tab1" style="padding: 1rem 0;">
            <xushi:content.heading level="3">Overview</xushi:content.heading>
            <xushi:content.text variant="body">Welcome to the overview panel.</xushi:content.text>
        </xushi:navigation.tab-panel>
        <xushi:navigation.tab-panel value="tab2" style="padding: 1rem 0;">
            <xushi:content.heading level="3">Team</xushi:content.heading>
            <xushi:content.text variant="body">Manage your team members here.</xushi:content.text>
        </xushi:navigation.tab-panel>
        <xushi:navigation.tab-panel value="tab3" style="padding: 1rem 0;">
            <xushi:content.heading level="3">Settings</xushi:content.heading>
            <xushi:content.text variant="body">Configure your preferences.</xushi:content.text>
        </xushi:navigation.tab-panel>
        <xushi:navigation.tab-panel value="tab4" style="padding: 1rem 0;">
            Billing content.
        </xushi:navigation.tab-panel>
    </xushi:navigation.tab>

    {{-- Pill variant --}}
    <xushi:navigation.tab defaultopen="p1" variant="pill" :muted="true">
        <x-slot:tabs>
            <xushi:navigation.tab-item value="p1">All</xushi:navigation.tab-item>
            <xushi:navigation.tab-item value="p2">Active</xushi:navigation.tab-item>
            <xushi:navigation.tab-item value="p3">Archived</xushi:navigation.tab-item>
        </x-slot:tabs>
        <xushi:navigation.tab-panel value="p1" style="padding: 0.75rem 0;">All items panel.</xushi:navigation.tab-panel>
        <xushi:navigation.tab-panel value="p2" style="padding: 0.75rem 0;">Active items panel.</xushi:navigation.tab-panel>
        <xushi:navigation.tab-panel value="p3" style="padding: 0.75rem 0;">Archived items panel.</xushi:navigation.tab-panel>
    </xushi:navigation.tab>

    {{-- Segmented --}}
    <xushi:navigation.tab defaultopen="s1" variant="segmented" :fill="true">
        <x-slot:tabs>
            <xushi:navigation.tab-item value="s1">Month</xushi:navigation.tab-item>
            <xushi:navigation.tab-item value="s2">Quarter</xushi:navigation.tab-item>
            <xushi:navigation.tab-item value="s3">Year</xushi:navigation.tab-item>
        </x-slot:tabs>
        <xushi:navigation.tab-panel value="s1" style="padding: 0.75rem 0;">Monthly view.</xushi:navigation.tab-panel>
        <xushi:navigation.tab-panel value="s2" style="padding: 0.75rem 0;">Quarterly view.</xushi:navigation.tab-panel>
        <xushi:navigation.tab-panel value="s3" style="padding: 0.75rem 0;">Yearly view.</xushi:navigation.tab-panel>
    </xushi:navigation.tab>

    {{-- Soft variant with title and footer slot --}}
    <xushi:navigation.tab defaultopen="f1" variant="soft">
        <x-slot:tabs>
            <xushi:navigation.tab-item value="f1">Details</xushi:navigation.tab-item>
            <xushi:navigation.tab-item value="f2">Activity</xushi:navigation.tab-item>
        </x-slot:tabs>
        <x-slot:footer>
            <xushi:button size="sm" variant="soft" color="primary">Export</xushi:button>
        </x-slot:footer>
        <xushi:navigation.tab-panel value="f1" style="padding: 0.75rem 0;">Details panel with footer action.</xushi:navigation.tab-panel>
        <xushi:navigation.tab-panel value="f2" style="padding: 0.75rem 0;">Activity log goes here.</xushi:navigation.tab-panel>
    </xushi:navigation.tab>

    {{-- Vertical orientation --}}
    <xushi:navigation.tab defaultopen="v1" variant="underline" orientation="vertical" height="200px">
        <x-slot:tabs>
            <xushi:navigation.tab-item value="v1" icon="user">Profile</xushi:navigation.tab-item>
            <xushi:navigation.tab-item value="v2" icon="lock">Security</xushi:navigation.tab-item>
            <xushi:navigation.tab-item value="v3" icon="bell">Notifications</xushi:navigation.tab-item>
        </x-slot:tabs>
        <xushi:navigation.tab-panel value="v1" style="padding: 0 1rem;">Profile settings.</xushi:navigation.tab-panel>
        <xushi:navigation.tab-panel value="v2" style="padding: 0 1rem;">Security settings.</xushi:navigation.tab-panel>
        <xushi:navigation.tab-panel value="v3" style="padding: 0 1rem;">Notification preferences.</xushi:navigation.tab-panel>
    </xushi:navigation.tab>
</div>
</x-layouts.layout>