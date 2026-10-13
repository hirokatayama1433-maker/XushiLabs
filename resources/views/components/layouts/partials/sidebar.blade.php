

<xushi:sidebar  borderright="1px">
    <x-slot:header>
        <xushi:sidebar-brand src="{{ asset('storage/logo.svg') }}" href="/" name="MyVita" />
        <xushi:sidebar-search placeholder="Search..." />
    </x-slot:header>


    {{-- Group with no label --}}
    <xushi:sidebar-nav>
    <xushi:sidebar-navitem name="Home" icon="layout-dashboard" href="/dashboard" :active="true"  />
    </xushi:sidebar-nav>

    <xushi:sidebar-nav label="Xushi UI">
        <xushi:sidebar-navitem name="Installation"  icon="school"     href="/rules34rd24" />
        <xushi:sidebar-navtree name="Components" icon="shapes" >
            <xushi:sidebar-navitem  name="Actions" icon="mouse-pointer-click"   href="/ui-components/actions" :active="true"/>
            <xushi:sidebar-navitem  name="Content" icon="file-text"             href="/ui-components/content" />
            <xushi:sidebar-navitem  name="Forms"   icon="form"                  href="/ui-components/forms" />
            <xushi:sidebar-navitem  name="Data"    icon="database"              href="/ui-components/data" />
            <xushi:sidebar-navitem  name="Feedback" icon="message-circle"       href="/ui-components/feedback" />
            <xushi:sidebar-navitem  name="Navigation" icon="navigation"         href="/ui-components/navigation" />
            <xushi:sidebar-navitem  name="Overlay" icon="layers"                 href="/ui-components/overlay" />
        </xushi:sidebar-navtree>

    </xushi:sidebar-nav>


    <x-slot:footer>
        <xushi:sidebar-navitem icon="messages-square" name="Message Center" href="/4234dfsdf" color="white" background="linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);" radius="36px" />
        <div style="height:1rem;">
        </div>
        <xushi:popover>
            <x-slot:trigger>
                <xushi:sidebar-avatar
                    src="https://i.pravatar.cc/100?img=1"
                    alt="User"
                    name="Sample name"
                    email="example@example.com"
                />
            </x-slot:trigger>

            <xushi:sidebar-avatar
                src="https://i.pravatar.cc/100?img=1"
                alt="User"
                name="Sample name"
                email="example@example.com"
            />
            <div style="height:1rem;">

            </div>

            <xushi:separator orientation="horizontal" />

            <xushi:menu label="Quick Settings">
                <xushi:menu-item name="Portals"  icon="Boxes" />
                <xushi:menu-item name="Themes"   icon="paintbrush" />

                <xushi:modal size="md" height="80dvh">
                    <x-slot:trigger>
                        <xushi:menu-item name="Settings" icon="gear-5" />
                    </x-slot:trigger>
                            <xushi:tab
                                    title="Settings"
                                    defaultopen="profile"
                                    orientation="vertical"
                                    variant="underline"
                                    panelpadding="1rem"
                                >
                        <x-slot:tabs>
                            <xushi:tab-item name="profile" value="profile" >
                                Profile
                            </xushi:tab-item>

                            <xushi:tab-item name="account" value="account" disabled>
                                Account
                            </xushi:tab-item>

                            <xushi:tab-item name="billing" value="billing">
                                Billing
                            </xushi:tab-item>

                            <xushi:tab-item icon="cog" name="appearance" value="appearance">
                                Appearance
                            </xushi:tab-item>
                        </x-slot:tabs>

                        <x-slot:footer>
                            <xushi:button icon="circle-question" variant="solid" color="primary">
                                Help resources
                            </xushi:button>
                        </x-slot:footer>

                        <xushi:tab-panel value="profile">

                            {{-- ── Hero card: avatar + name + edit ── --}}
                            <xushi:card padding="1rem" margin="0 0 0.75rem" variant="soft">
                                <div style="display:flex; align-items:center; justify-content:space-between; gap:1rem;">
                                    <xushi:profile
                                        name="Ibrahim Mahdi"
                                        role="Team Manager"
                                        src="/images/avatar.jpg"
                                        avatar-size="xl"
                                    >
                                        <x-slot:sub>Maiduguri, Borno State</x-slot:sub>
                                    </xushi:profile>
                                    <xushi:button variant="outline" color="base" size="sm" icon="square-pen">
                                        Edit
                                    </xushi:button>
                                </div>
                            </xushi:card>

                            {{-- ── Personal Information ── --}}
                            <xushi:card padding="1rem" margin="0 0 0.75rem">
                                <div style="display:flex; align-items:center; justify-content:space-between; gap:1rem; margin-bottom:0.75rem;">
                                    <xushi:heading level="6" size="sm" weight="600">Personal Information</xushi:heading>
                                    <xushi:button variant="outline" color="base" size="sm" icon="square-pen">
                                        Edit
                                    </xushi:button>
                                </div>

                                <xushi:separator margin="0 0 0.75rem" />

                                <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem 1.5rem;">

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">First Name</xushi:text>
                                        <xushi:text>Ibrahim</xushi:text>
                                    </div>

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">Last Name</xushi:text>
                                        <xushi:text>Mahdi</xushi:text>
                                    </div>

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">Position</xushi:text>
                                        <xushi:text>Team Manager</xushi:text>
                                    </div>

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">Gender</xushi:text>
                                        <xushi:text>Male</xushi:text>
                                    </div>

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">Email Address</xushi:text>
                                        <xushi:text>ibrahimmahdi@example.com</xushi:text>
                                    </div>

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">Phone Number</xushi:text>
                                        <xushi:text>+2348000000000</xushi:text>
                                    </div>

                                </div>
                            </xushi:card>

                            {{-- ── Address ── --}}
                            <xushi:card padding="1rem">
                                <div style="display:flex; align-items:center; justify-content:space-between; gap:1rem; margin-bottom:0.75rem;">
                                    <xushi:heading level="6" size="sm" weight="600">Address</xushi:heading>
                                    <xushi:button variant="outline" color="base" size="sm" icon="square-pen">
                                        Edit
                                    </xushi:button>
                                </div>

                                <xushi:separator margin="0 0 0.75rem" />

                                <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem 1.5rem;">

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">Street Address</xushi:text>
                                        <xushi:text>Elkanemi Street</xushi:text>
                                    </div>

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">House Number</xushi:text>
                                        <xushi:text>Number 4016</xushi:text>
                                    </div>

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">City</xushi:text>
                                        <xushi:text>Maiduguri</xushi:text>
                                    </div>

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">State</xushi:text>
                                        <xushi:text>Borno</xushi:text>
                                    </div>

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">Country</xushi:text>
                                        <xushi:text>Nigeria</xushi:text>
                                    </div>

                                    <div>
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">Postal Code</xushi:text>
                                        <xushi:text>600006</xushi:text>
                                    </div>

                                    <div style="grid-column: span 2;">
                                        <xushi:text variant="muted" style="font-size:0.75rem; margin-bottom:0.125rem;">Tax Identification Number</xushi:text>
                                        <xushi:text>1234567890</xushi:text>
                                    </div>

                                </div>
                            </xushi:card>

                        </xushi:tab-panel>

                        <xushi:tab-panel value="account">
                            Account settings...
                        </xushi:tab-panel>

                        <xushi:tab-panel value="billing">
                            Billing settings...
                        </xushi:tab-panel>

                        <xushi:tab-panel value="appearance">
                                <xushi:theme-toggle/>
                        </xushi:tab-panel>
                    </xushi:tab>
                </xushi:modal>

                <xushi:menu-item name="Team"   icon="group" />
                <xushi:menu-item name="Logout" icon="square-arrow-left" color="danger" wire:click="logout" />
            </xushi:menu>
            </xushi:popover>
            <div style="height:5px;"></div>
    </x-slot:footer>
</xushi:sidebar>