<x-layouts.layout>
    {{-- Alert --}}
<h2>Alert</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:feedback.alert variant="soft" color="info">
        <x-slot:iconslot><xushi:icon name="info" size="1rem" /></x-slot:iconslot>
        This is a soft info alert.
    </xushi:feedback.alert>

    <xushi:feedback.alert variant="soft" color="success">
        <x-slot:iconslot><xushi:icon name="check-circle" size="1rem" /></x-slot:iconslot>
        Your changes have been saved successfully.
    </xushi:feedback.alert>

    <xushi:feedback.alert variant="soft" color="warning">
        <x-slot:iconslot><xushi:icon name="triangle-alert" size="1rem" /></x-slot:iconslot>
        Your session will expire in 5 minutes.
    </xushi:feedback.alert>

    <xushi:feedback.alert variant="soft" color="danger">
        <x-slot:iconslot><xushi:icon name="circle-x" size="1rem" /></x-slot:iconslot>
        Something went wrong. Please try again.
    </xushi:feedback.alert>

    <xushi:feedback.alert variant="solid" color="info">
        <x-slot:iconslot><xushi:icon name="info" size="1rem" /></x-slot:iconslot>
        Solid info alert.
        <x-slot:trailing><xushi:button size="sm" variant="ghost">Dismiss</xushi:button></x-slot:trailing>
    </xushi:feedback.alert>

    <xushi:feedback.alert variant="outline" color="danger">
        <x-slot:iconslot><xushi:icon name="circle-x" size="1rem" /></x-slot:iconslot>
        Outline danger alert.
    </xushi:feedback.alert>
</div>

{{-- Badge --}}
<h2>Badge</h2>
<div style="
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Sizes --}}
    <xushi:feedback.badge size="sm" color="primary">Small</xushi:feedback.badge>
    <xushi:feedback.badge size="md" color="primary">Medium</xushi:feedback.badge>
    <xushi:feedback.badge size="lg" color="primary">Large</xushi:feedback.badge>

    {{-- Colors / soft --}}
    <xushi:feedback.badge variant="soft" color="success">Success</xushi:feedback.badge>
    <xushi:feedback.badge variant="soft" color="warning">Warning</xushi:feedback.badge>
    <xushi:feedback.badge variant="soft" color="danger">Danger</xushi:feedback.badge>
    <xushi:feedback.badge variant="soft" color="info">Info</xushi:feedback.badge>
    <xushi:feedback.badge variant="soft" color="secondary">Secondary</xushi:feedback.badge>

    {{-- Solid --}}
    <xushi:feedback.badge variant="solid" color="primary">Solid</xushi:feedback.badge>
    <xushi:feedback.badge variant="solid" color="danger">Solid Danger</xushi:feedback.badge>

    {{-- Outline --}}
    <xushi:feedback.badge variant="outline" color="success">Outline</xushi:feedback.badge>

    {{-- With icon --}}
    <xushi:feedback.badge variant="soft" color="success">
        <x-slot:iconslot><xushi:icon name="check" size="0.75rem" /></x-slot:iconslot>
        Verified
    </xushi:feedback.badge>
</div>

{{-- Callout --}}
<h2>Callout</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:feedback.callout color="info" icon="info" title="Heads up">
        This action will permanently delete your data and cannot be undone.
    </xushi:feedback.callout>

    <xushi:feedback.callout color="success" icon="check-circle" title="All systems operational">
        All services are running normally. Last checked 2 minutes ago.
    </xushi:feedback.callout>

    <xushi:feedback.callout color="warning" icon="triangle-alert" title="Deprecation notice">
        This API endpoint will be removed in v2.0. Please migrate before January 2026.
    </xushi:feedback.callout>

    <xushi:feedback.callout color="danger" icon="circle-x" title="Action required">
        Your payment method has expired. Update it to avoid service interruption.
    </xushi:feedback.callout>

    <xushi:feedback.callout variant="outline" color="info" icon="info" title="Outline variant">
        Outline callout with a full border instead of a left accent.
    </xushi:feedback.callout>

    <xushi:feedback.callout variant="solid" color="warning" icon="triangle-alert" title="Solid variant">
        Solid callout — full background fill.
    </xushi:feedback.callout>
</div>

{{-- Progress --}}
<h2>Progress</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:feedback.progress :value="25" color="primary" />
    <xushi:feedback.progress :value="50" color="success" :showvalue="true" />
    <xushi:feedback.progress :value="70" color="warning" :showvalue="true" />
    <xushi:feedback.progress :value="90" color="danger" :showvalue="true" />
    <xushi:feedback.progress :value="100" color="info" :showvalue="true" format="percent" />
</div>

{{-- Skeleton --}}
<h2>Skeleton</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 10px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Line --}}
    <xushi:feedback.skeleton variant="line" />
    <xushi:feedback.skeleton variant="line" width="60%" />

    {{-- Circle --}}
    <xushi:feedback.skeleton variant="circle" />

    {{-- Box --}}
    <xushi:feedback.skeleton variant="box" height="6rem" />

    {{-- Text block (multi-line) --}}
    <xushi:feedback.skeleton variant="text" :lines="3" />

    {{-- Card shimmer example --}}
    <div style="display:flex; gap:12px; align-items:flex-start;">
        <xushi:feedback.skeleton variant="circle" width="2.5rem" height="2.5rem" />
        <div style="flex:1; display:flex; flex-direction:column; gap:6px;">
            <xushi:feedback.skeleton variant="line" width="40%" />
            <xushi:feedback.skeleton variant="line" width="80%" />
            <xushi:feedback.skeleton variant="line" width="65%" />
        </div>
    </div>
</div>

{{-- Toast --}}
<h2>Toast</h2>
<div style="
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Place the portal once anywhere in the layout --}}
    <xushi:feedback.toast position="bottom-right" :duration="4000" />

    <xushi:button variant="soft" color="base"
        @click="$dispatch('xushi-toast', { title: 'Note', body: 'This is a base toast.', type: 'base' })">
        Base
    </xushi:button>

    <xushi:button variant="soft" color="primary"
        @click="$dispatch('xushi-toast', { title: 'Info', body: 'Here is some useful information.', type: 'info' })">
        Info
    </xushi:button>

    <xushi:button variant="soft" color="success" {{-- not a named color prop, just visual --}}
        @click="$dispatch('xushi-toast', { title: 'Success', body: 'Your changes were saved.', type: 'success' })">
        Success
    </xushi:button>

    <xushi:button variant="soft" color="warning"
        @click="$dispatch('xushi-toast', { title: 'Warning', body: 'This action may have side effects.', type: 'warning' })">
        Warning
    </xushi:button>

    <xushi:button variant="soft" color="danger"
        @click="$dispatch('xushi-toast', { title: 'Error', body: 'Something went wrong. Try again.', type: 'danger' })">
        Danger
    </xushi:button>

    <xushi:button variant="outline" color="base"
        @click="$dispatch('xushi-toast', { title: 'Persistent', body: 'This will not auto-dismiss.', type: 'info', duration: 0 })">
        Persistent
    </xushi:button>
</div>

{{-- Tooltip --}}
<h2>Tooltip</h2>
<div style="
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 16px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:feedback.tooltip text="This is a tooltip">
        <x-slot:trigger>
            <xushi:button variant="outline" color="base">Hover me</xushi:button>
        </x-slot:trigger>
    </xushi:feedback.tooltip>

    <xushi:feedback.tooltip text="Delete this item permanently">
        <x-slot:trigger>
            <xushi:icon name="trash" size="1.25rem" color="var(--xushi-color-danger)" />
        </x-slot:trigger>
    </xushi:feedback.tooltip>

    <xushi:feedback.tooltip text="Verified account — all checks passed">
        <x-slot:trigger>
            <xushi:icon name="check-circle" size="1.25rem" color="var(--xushi-color-success)" />
        </x-slot:trigger>
    </xushi:feedback.tooltip>

    {{-- Custom slot content instead of text prop --}}
    <xushi:feedback.tooltip>
        <x-slot:trigger>
            <xushi:button variant="soft" color="primary" size="sm">Rich tooltip</xushi:button>
        </x-slot:trigger>
        <strong>Custom content</strong><br>Any HTML works in the slot.
    </xushi:feedback.tooltip>
</div>
</x-layouts.layout>