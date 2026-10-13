<x-layouts.layout>
    {{-- Drawer --}}
<h2>Drawer</h2>
<div style="
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Left (default) --}}
    <xushi:overlay.drawer position="left">
        <x-slot:trigger>
            <xushi:button variant="outline" color="base">Left drawer</xushi:button>
        </x-slot:trigger>
        <xushi:content.heading level="3" margin="0 0 1rem">Left Drawer</xushi:content.heading>
        <xushi:content.text variant="body">Slides in from the left. Click outside or press Esc to close.</xushi:content.text>
    </xushi:overlay.drawer>

    {{-- Right --}}
    <xushi:overlay.drawer position="right" width="400px">
        <x-slot:trigger>
            <xushi:button variant="outline" color="base">Right drawer</xushi:button>
        </x-slot:trigger>
        <xushi:content.heading level="3" margin="0 0 1rem">Right Drawer</xushi:content.heading>
        <xushi:content.text variant="body">Custom 400px width, slides from the right.</xushi:content.text>
    </xushi:overlay.drawer>

    {{-- Top --}}
    <xushi:overlay.drawer position="top" height="260px">
        <x-slot:trigger>
            <xushi:button variant="outline" color="base">Top drawer</xushi:button>
        </x-slot:trigger>
        <xushi:content.heading level="3" margin="0 0 1rem">Top Drawer</xushi:content.heading>
        <xushi:content.text variant="body">Slides down from the top.</xushi:content.text>
    </xushi:overlay.drawer>

    {{-- Bottom --}}
    <xushi:overlay.drawer position="bottom" height="300px">
        <x-slot:trigger>
            <xushi:button variant="outline" color="base">Bottom drawer</xushi:button>
        </x-slot:trigger>
        <xushi:content.heading level="3" margin="0 0 1rem">Bottom Drawer</xushi:content.heading>
        <xushi:content.text variant="body">Slides up from the bottom. Useful for mobile sheets.</xushi:content.text>
    </xushi:overlay.drawer>
</div>

{{-- Dropdown --}}
<h2>Dropdown</h2>
<div style="
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Basic action menu --}}
    <xushi:overlay.dropdown>
        <x-slot:trigger>
            <xushi:button variant="outline" color="base">
                Actions
                <xushi:icon name="chevron-down" size="0.875rem" />
            </xushi:button>
        </x-slot:trigger>
        <xushi:navigation.menu>
            <xushi:navigation.menu-item icon="pencil" href="#">Edit</xushi:navigation.menu-item>
            <xushi:navigation.menu-item icon="copy" href="#">Duplicate</xushi:navigation.menu-item>
            <xushi:navigation.menu-item icon="archive" href="#">Archive</xushi:navigation.menu-item>
            <xushi:navigation.menu-item icon="trash" color="danger">Delete</xushi:navigation.menu-item>
        </xushi:navigation.menu>
    </xushi:overlay.dropdown>

    {{-- User menu --}}
    <xushi:overlay.dropdown>
        <x-slot:trigger>
            <xushi:content.avatar size="md" alt="Zayne Admin" style="cursor:pointer;" />
        </x-slot:trigger>
        <xushi:navigation.menu style="min-width:200px;">
            <div style="padding: 0.5rem 0.625rem 0.375rem;">
                <xushi:content.profile name="Zayne Admin" role="Lead Developer" layout="compact" />
            </div>
            <div style="height:1px; background:var(--xushi-color-base-border); margin: 0.25rem 0;"></div>
            <xushi:navigation.menu-item icon="user" href="/profile">Profile</xushi:navigation.menu-item>
            <xushi:navigation.menu-item icon="settings" href="/settings">Settings</xushi:navigation.menu-item>
            <div style="height:1px; background:var(--xushi-color-base-border); margin: 0.25rem 0;"></div>
            <xushi:navigation.menu-item icon="log-out" color="danger">Sign out</xushi:navigation.menu-item>
        </xushi:navigation.menu>
    </xushi:overlay.dropdown>

    {{-- With badge in right slot --}}
    <xushi:overlay.dropdown>
        <x-slot:trigger>
            <xushi:button variant="soft" color="primary">
                Notifications
                <xushi:feedback.badge variant="solid" color="danger" size="sm">5</xushi:feedback.badge>
            </xushi:button>
        </x-slot:trigger>
        <xushi:navigation.menu style="min-width:220px;">
            <xushi:navigation.menu-item icon="bell">
                New message from Jane
                <x-slot:right>2m</x-slot:right>
            </xushi:navigation.menu-item>
            <xushi:navigation.menu-item icon="check-circle" color="success">
                Deployment succeeded
                <x-slot:right>1h</x-slot:right>
            </xushi:navigation.menu-item>
            <xushi:navigation.menu-item icon="triangle-alert" color="warning">
                Disk usage at 90%
                <x-slot:right>3h</x-slot:right>
            </xushi:navigation.menu-item>
        </xushi:navigation.menu>
    </xushi:overlay.dropdown>
</div>

{{-- Modal --}}
<h2>Modal</h2>
<div style="
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Default md --}}
    <xushi:overlay.modal size="md">
        <x-slot:trigger>
            <xushi:button variant="outline" color="base">Open modal</xushi:button>
        </x-slot:trigger>
        <div style="display:flex; flex-direction:column; gap:1rem;">
            <xushi:content.heading level="3" margin="0">Confirm action</xushi:content.heading>
            <xushi:content.text variant="body">
                Are you sure you want to proceed? This action cannot be undone.
            </xushi:content.text>
            <div style="display:flex; justify-content:flex-end; gap:0.5rem; margin-top:0.5rem;">
                <xushi:button variant="ghost" color="base" @click="hide()">Cancel</xushi:button>
                <xushi:button variant="solid" color="danger">Delete</xushi:button>
            </div>
        </div>
    </xushi:overlay.modal>

    {{-- Small --}}
    <xushi:overlay.modal size="sm">
        <x-slot:trigger>
            <xushi:button variant="outline" color="base">Small modal</xushi:button>
        </x-slot:trigger>
        <xushi:content.heading level="3" margin="0 0 0.75rem">Small modal</xushi:content.heading>
        <xushi:content.text variant="body">A compact dialog for quick confirmations.</xushi:content.text>
    </xushi:overlay.modal>

    {{-- Large with form --}}
    <xushi:overlay.modal size="lg">
        <x-slot:trigger>
            <xushi:button variant="soft" color="primary">Edit profile</xushi:button>
        </x-slot:trigger>
        <div style="display:flex; flex-direction:column; gap:1rem;">
            <xushi:content.heading level="3" margin="0">Edit profile</xushi:content.heading>
            <xushi:forms.fieldset label="Full name">
                <xushi:forms.input name="modal_name" placeholder="Enter your name" value="Zayne Admin" />
            </xushi:forms.fieldset>
            <xushi:forms.fieldset label="Email">
                <xushi:forms.input name="modal_email" type="email" placeholder="you@example.com" />
            </xushi:forms.fieldset>
            <xushi:forms.fieldset label="Bio">
                <xushi:forms.textarea name="modal_bio" placeholder="Tell us about yourself..." :rows="3" />
            </xushi:forms.fieldset>
            <div style="display:flex; justify-content:flex-end; gap:0.5rem;">
                <xushi:button variant="ghost" color="base" @click="hide()">Cancel</xushi:button>
                <xushi:button variant="solid" color="primary">Save changes</xushi:button>
            </div>
        </div>
    </xushi:overlay.modal>

    {{-- No outside close --}}
    <xushi:overlay.modal size="sm" :closeOnOutside="false">
        <x-slot:trigger>
            <xushi:button variant="outline" color="warning">Persistent modal</xushi:button>
        </x-slot:trigger>
        <xushi:content.heading level="3" margin="0 0 0.75rem">Persistent</xushi:content.heading>
        <xushi:content.text variant="body">Clicking outside won't close this. Use the button below.</xushi:content.text>
        <div style="display:flex; justify-content:flex-end; margin-top:1rem;">
            <xushi:button variant="solid" color="primary" @click="hide()">Got it</xushi:button>
        </div>
    </xushi:overlay.modal>
</div>

{{-- Popover --}}
<h2>Popover</h2>
<div style="
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Info popover --}}
    <xushi:overlay.popover>
        <x-slot:trigger>
            <xushi:button variant="outline" color="base">
                Info
                <xushi:icon name="info" size="0.875rem" />
            </xushi:button>
        </x-slot:trigger>
        <xushi:content.heading level="4" margin="0 0 0.5rem">What is XushiUI?</xushi:content.heading>
        <xushi:content.text variant="body">
            A CSS token-driven component engine for Laravel + Blade. No Tailwind, no build step.
        </xushi:content.text>
    </xushi:overlay.popover>

    {{-- Filter popover --}}
    <xushi:overlay.popover minwidth="260px">
        <x-slot:trigger>
            <xushi:button variant="soft" color="primary">
                <xushi:icon name="filter" size="0.875rem" />
                Filters
            </xushi:button>
        </x-slot:trigger>
        <div style="display:flex; flex-direction:column; gap:0.75rem;">
            <xushi:content.heading level="4" margin="0">Filter results</xushi:content.heading>
            <xushi:forms.fieldset label="Status">
                <xushi:forms.select name="filter_status">
                    <option value="">All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </xushi:forms.select>
            </xushi:forms.fieldset>
            <xushi:forms.fieldset label="Role">
                <xushi:forms.select name="filter_role">
                    <option value="">Any</option>
                    <option value="admin">Admin</option>
                    <option value="editor">Editor</option>
                </xushi:forms.select>
            </xushi:forms.fieldset>
            <div style="display:flex; justify-content:flex-end; gap:0.5rem;">
                <xushi:button size="sm" variant="ghost" color="base" @click="hide()">Reset</xushi:button>
                <xushi:button size="sm" variant="solid" color="primary" @click="hide()">Apply</xushi:button>
            </div>
        </div>
    </xushi:overlay.popover>

    {{-- Profile card popover --}}
    <xushi:overlay.popover minwidth="240px">
        <x-slot:trigger>
            <xushi:content.profile name="Zayne Admin" role="Lead Developer" layout="compact" style="cursor:pointer;" />
        </x-slot:trigger>
        <div style="display:flex; flex-direction:column; gap:0.75rem;">
            <xushi:content.profile name="Zayne Admin" role="Lead Developer" email="zayne@example.com" avatarSize="lg" />
            <div style="height:1px; background:var(--xushi-color-base-border);"></div>
            <xushi:navigation.menu>
                <xushi:navigation.menu-item icon="user" href="/profile">View profile</xushi:navigation.menu-item>
                <xushi:navigation.menu-item icon="settings" href="/settings">Settings</xushi:navigation.menu-item>
                <xushi:navigation.menu-item icon="log-out" color="danger">Sign out</xushi:navigation.menu-item>
            </xushi:navigation.menu>
        </div>
    </xushi:overlay.popover>
</div>
    </x-layouts.layout>