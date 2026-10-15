<x-layouts.layout>
<div style="width:100%; display:flex; flex-direction:column; gap:1.5rem;">

    {{-- ========================================================
         ACCORDION
    ========================================================= --}}
    <h2>Accordion</h2>
    <p>A collapsible content component for showing and hiding sections.</p>

    @php $code = <<<'BLADE'
<xushi:accordion variant="default" default="item-1">
    <xushi:accordion-item value="item-1">
        <x-slot:heading>What is XushiUI?</x-slot:heading>
        A CSS token-driven component engine for Laravel + Blade.
    </xushi:accordion-item>
    <xushi:accordion-item value="item-2">
        <x-slot:heading>Does it use Tailwind?</x-slot:heading>
        No. XushiUI is entirely token-driven with no build step required.
    </xushi:accordion-item>
    <xushi:accordion-item value="item-3" disabled>
        <x-slot:heading>Disabled item</x-slot:heading>
        This item is not interactive.
    </xushi:accordion-item>
</xushi:accordion>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <div style="width:100%;">
                <xushi:accordion variant="default" default="item-1">
                    <xushi:accordion-item value="item-1">
                        <x-slot:heading>What is XushiUI?</x-slot:heading>
                        A CSS token-driven component engine for Laravel + Blade.
                    </xushi:accordion-item>
                    <xushi:accordion-item value="item-2">
                        <x-slot:heading>Does it use Tailwind?</x-slot:heading>
                        No. XushiUI is entirely token-driven with no build step required.
                    </xushi:accordion-item>
                    <xushi:accordion-item value="item-3" disabled>
                        <x-slot:heading>Disabled item</x-slot:heading>
                        This item is not interactive.
                    </xushi:accordion-item>
                </xushi:accordion>
            </div>
        </x-slot:preview>
    </xushi:democode>

    <h4>Separated</h4>
    <p>Use <code>variant="separated"</code> to render each item as its own bordered card. Pass <code>:multiple="true"</code> to allow multiple items open at once.</p>
    @php $code = <<<'BLADE'
<xushi:accordion variant="separated" :multiple="true">
    <xushi:accordion-item value="sep-1">
        <x-slot:heading>Separated + multiple open</x-slot:heading>
        Each item is its own bordered card.
    </xushi:accordion-item>
    <xushi:accordion-item value="sep-2">
        <x-slot:heading>Second item</x-slot:heading>
        Both items can be open at the same time.
    </xushi:accordion-item>
</xushi:accordion>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <div style="width:100%;">
                <xushi:accordion variant="separated" :multiple="true">
                    <xushi:accordion-item value="sep-1">
                        <x-slot:heading>Separated + multiple open</x-slot:heading>
                        Each item is its own bordered card.
                    </xushi:accordion-item>
                    <xushi:accordion-item value="sep-2">
                        <x-slot:heading>Second item</x-slot:heading>
                        Both items can be open at the same time.
                    </xushi:accordion-item>
                </xushi:accordion>
            </div>
        </x-slot:preview>
    </xushi:democode>


    {{-- ========================================================
         AVATAR
    ========================================================= --}}
    <h2>Avatar</h2>
    <p>A user avatar component with initials fallback, color variants, and sizes.</p>

    @php $code = <<<'BLADE'
<xushi:avatar size="sm" alt="John Doe" />
<xushi:avatar size="md" alt="Jane Smith" variant="solid" color="primary" />
<xushi:avatar size="lg" alt="Alex Ray" variant="soft" color="secondary" />
<xushi:avatar size="xl" src="https://i.pravatar.cc/80" alt="Photo" />
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:avatar size="sm" alt="John Doe" />
            <xushi:avatar size="md" alt="Jane Smith" variant="solid" color="primary" />
            <xushi:avatar size="lg" alt="Alex Ray" variant="soft" color="secondary" />
            <xushi:avatar size="xl" src="https://i.pravatar.cc/80" alt="Photo" />
        </x-slot:preview>
    </xushi:democode>


    {{-- ========================================================
         CARD
    ========================================================= --}}
    {{-- <h2>Card</h2>
    <p>A flexible content container with optional header, footer, and image zones.</p>

    @php $code = <<<'BLADE'
<xushi:card title="Basic card" description="A solid base card with title and description.">
    Card body content goes here.
</xushi:card>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:card color="base" title="Basic card" description="A solid base card with title and description.">
                Card body content goes here.
            </xushi:card>
        </x-slot:preview>
    </xushi:democode>

    <h4>With Image and Footer</h4>
    <p>Use <code>imgsrc</code> to add an image zone above the content, and the <code>footer</code> slot for actions.</p>
    @php $code = <<<'BLADE'
<xushi:card
    imgsrc="https://picsum.photos/seed/xushi/600/200"
    imgalt="Sample image"
    title="Card with image"
    description="imgsrc adds an image zone above the content."
    variant="outline"
    color="primary"
>
    <x-slot:footer>
        <xushi:button size="sm" variant="ghost">Cancel</xushi:button>
        <xushi:button size="sm" variant="solid" color="primary">Save</xushi:button>
    </x-slot:footer>
    Body text under the image.
</xushi:card>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:card
                imgsrc="https://i.pravatar.cc/80 "
                imgalt="Sample image"
                title="Card with image"
                description="imgsrc adds an image zone above the content."
                variant="outline"
                color="primary"
            >
                <x-slot:footer>
                    <xushi:button size="sm" variant="ghost">Cancel</xushi:button>
                    <xushi:button size="sm" variant="solid" color="primary">Save</xushi:button>
                </x-slot:footer>
                Body text under the image.
            </xushi:card>
        </x-slot:preview>
    </xushi:democode> --}}


            {{-- ========================================================
         CARD
    ========================================================= --}}
    <h2>Card</h2>
    <p>A flexible content container with optional header, body, footer, and image zones.</p>

    {{-- Basic --}}
    @php $code = <<<'BLADE'
<xushi:card title="Basic card" description="A solid base card with title and description.">
    Card body content goes here.
</xushi:card>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:card title="Basic card" description="A solid base card with title and description.">
                Card body content goes here.
            </xushi:card>
        </x-slot:preview>
    </xushi:democode>

    {{-- Sections --}}
    <h4>Sections</h4>
    <p>Use <code>sections="flush"</code> (default), <code>sections="ruled"</code>, or <code>sections="banded"</code> to control how header and footer are separated from the body.</p>
    @php $code = <<<'BLADE'
{{-- flush: no dividers --}}
<xushi:card sections="flush" title="Notifications" description="Choose what you hear about">
    <div style="display:flex;flex-direction:column;gap:0.75rem;">
        <div style="display:flex;justify-content:space-between;"><span>Product updates</span><xushi:toggle name="t1" :checked="true" /></div>
        <div style="display:flex;justify-content:space-between;"><span>Weekly digest</span><xushi:toggle name="t2" /></div>
        <div style="display:flex;justify-content:space-between;"><span>Security alerts</span><xushi:toggle name="t3" :checked="true" /></div>
    </div>
</xushi:card>

{{-- ruled: border lines --}}
<xushi:card sections="ruled" title="Notifications" description="Choose what you hear about">
    <div style="display:flex;flex-direction:column;gap:0.75rem;">
        <div style="display:flex;justify-content:space-between;"><span>Product updates</span><xushi:toggle name="t4" /></div>
        <div style="display:flex;justify-content:space-between;"><span>Weekly digest</span><xushi:toggle name="t5" /></div>
        <div style="display:flex;justify-content:space-between;"><span>Security alerts</span><xushi:toggle name="t6" /></div>
    </div>
</xushi:card>

{{-- banded: tinted header and footer --}}
<xushi:card sections="banded" title="Notifications" description="Choose what you hear about">
    <div style="display:flex;flex-direction:column;gap:0.75rem;">
        <div style="display:flex;justify-content:space-between;"><span>Product updates</span><xushi:toggle name="t7" :checked="true" /></div>
        <div style="display:flex;justify-content:space-between;"><span>Weekly digest</span><xushi:toggle name="t8" /></div>
        <div style="display:flex;justify-content:space-between;"><span>Security alerts</span><xushi:toggle name="t9" :checked="true" /></div>
    </div>
</xushi:card>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <div style="display:flex;gap:16px;flex-wrap:wrap;align-items:flex-start;">
                <xushi:card sections="flush" title="Notifications" description="Choose what you hear about" style="width:260px;">
                    <div style="display:flex;flex-direction:column;gap:0.75rem;">
                        <div style="display:flex;justify-content:space-between;align-items:center;"><span>Product updates</span><xushi:toggle name="t1" :checked="true" /></div>
                        <div style="display:flex;justify-content:space-between;align-items:center;"><span>Weekly digest</span><xushi:toggle name="t2" /></div>
                        <div style="display:flex;justify-content:space-between;align-items:center;"><span>Security alerts</span><xushi:toggle name="t3" :checked="true" /></div>
                    </div>
                </xushi:card>
                <xushi:card sections="ruled" title="Notifications" description="Choose what you hear about" style="width:260px;">
                    <div style="display:flex;flex-direction:column;gap:0.75rem;">
                        <div style="display:flex;justify-content:space-between;align-items:center;"><span>Product updates</span><xushi:toggle name="t4" /></div>
                        <div style="display:flex;justify-content:space-between;align-items:center;"><span>Weekly digest</span><xushi:toggle name="t5" /></div>
                        <div style="display:flex;justify-content:space-between;align-items:center;"><span>Security alerts</span><xushi:toggle name="t6" /></div>
                    </div>
                </xushi:card>
                <xushi:card sections="banded" title="Notifications" description="Choose what you hear about" style="width:260px;">
                    <div style="display:flex;flex-direction:column;gap:0.75rem;">
                        <div style="display:flex;justify-content:space-between;align-items:center;"><span>Product updates</span><xushi:toggle name="t7" :checked="true" /></div>
                        <div style="display:flex;justify-content:space-between;align-items:center;"><span>Weekly digest</span><xushi:toggle name="t8" /></div>
                        <div style="display:flex;justify-content:space-between;align-items:center;"><span>Security alerts</span><xushi:toggle name="t9" :checked="true" /></div>
                    </div>
                </xushi:card>
            </div>
        </x-slot:preview>
    </xushi:democode>

    {{-- Header + Footer --}}
    <h4>With Header and Footer</h4>
    <p>Use the <code>header</code> slot for a fully custom header bar and the <code>footer</code> slot for actions.</p>
    @php $code = <<<'BLADE'
<xushi:card sections="ruled">
    <x-slot:header>
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <div>
                <div style="font-weight:600;">Terms of Service</div>
                <div style="font-size:0.85em;opacity:0.6;">Review the terms before accepting the agreement.</div>
            </div>
            <xushi:button variant="ghost" size="sm"><xushi:icon name="log-out" size="1em" /></xushi:button>
        </div>
    </x-slot:header>
    <p>These terms govern your use of the workspace, including access to shared documents, project files, and collaboration tools.</p>
    <p>You are responsible for the content you upload and for ensuring that your team has the appropriate permissions.</p>
    <p>We may update features or limits as the service evolves. We will notify your workspace of material changes.</p>
    <x-slot:footer>
        <div style="display:flex;justify-content:flex-end;gap:8px;">
            <xushi:button variant="outline">Decline</xushi:button>
            <xushi:button variant="solid" color="base">Agree</xushi:button>
        </div>
    </x-slot:footer>
</xushi:card>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <div style="display:flex;gap:16px;flex-wrap:wrap;align-items:flex-start;">
                <xushi:card sections="ruled" style="width:300px;">
                    <x-slot:header>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div>
                                <div style="font-weight:600;">Terms of Service</div>
                                <div style="font-size:0.85em;opacity:0.6;">Review the terms before accepting the agreement.</div>
                            </div>
                            <xushi:button variant="ghost" size="sm"><xushi:icon name="log-out" size="1em" /></xushi:button>
                        </div>
                    </x-slot:header>
                    <p style="margin-bottom:10px;">These terms govern your use of the workspace, including access to shared documents, project files, and collaboration tools.</p>
                    <p style="margin-bottom:10px;">You are responsible for the content you upload and for ensuring that your team has the appropriate permissions.</p>
                    <p>We may update features or limits as the service evolves. We will notify your workspace of material changes.</p>
                    <x-slot:footer>
                        <div style="display:flex;justify-content:flex-end;gap:8px;">
                            <xushi:button variant="outline">Decline</xushi:button>
                            <xushi:button variant="solid" color="base">Agree</xushi:button>
                        </div>
                    </x-slot:footer>
                </xushi:card>
                <xushi:card sections="ruled" variant="solid" color="base" style="width:300px;">
                    <x-slot:header>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div>
                                <div style="font-weight:600;">Terms of Service</div>
                                <div style="font-size:0.85em;opacity:0.6;">Review the terms before accepting the agreement.</div>
                            </div>
                            <xushi:button variant="ghost" size="sm"><xushi:icon name="log-out" size="1em" /></xushi:button>
                        </div>
                    </x-slot:header>
                    <p style="margin-bottom:10px;">These terms govern your use of the workspace, including access to shared documents, project files, and collaboration tools.</p>
                    <p style="margin-bottom:10px;">You are responsible for the content you upload and for ensuring that your team has the appropriate permissions.</p>
                    <p>We may update features or limits as the service evolves. We will notify your workspace of material changes.</p>
                    <x-slot:footer>
                        <div style="display:flex;justify-content:flex-end;gap:8px;">
                            <xushi:button variant="outline">Decline</xushi:button>
                            <xushi:button variant="solid" color="base">Agree</xushi:button>
                        </div>
                    </x-slot:footer>
                </xushi:card>
            </div>
        </x-slot:preview>
    </xushi:democode>

    {{-- Image + Footer --}}
    <h4>With Image and Footer</h4>
    <p>Use <code>imgsrc</code> to add a cover image above the content, and the <code>footer</code> slot for actions.</p>
    @php $code = <<<'BLADE'
<xushi:card
    imgsrc="https://picsum.photos/seed/xushi/600/300"
    imgalt="Design systems meetup"
    title="Design systems meetup"
    description="A practical talk on component APIs, accessibility, and shipping faster."
>
    <x-slot:footer>
        <xushi:button variant="solid" color="base" style="width:100%;">Check out</xushi:button>
    </x-slot:footer>
</xushi:card>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <div style="display:flex;gap:16px;flex-wrap:wrap;align-items:flex-start;">
                <xushi:card
                    imgsrc="https://picsum.photos/seed/xushi/600/300"
                    imgalt="Design systems meetup"
                    title="Design systems meetup"
                    description="A practical talk on component APIs, accessibility, and shipping faster."
                    style="width:300px;"
                >
                    <x-slot:footer>
                        <xushi:button variant="solid" color="base" style="width:100%;">Check out</xushi:button>
                    </x-slot:footer>
                </xushi:card>
                <xushi:card
                    imgsrc="https://picsum.photos/seed/xushi2/600/300"
                    imgalt="Design systems meetup"
                    title="Design systems meetup"
                    description="A practical talk on component APIs, accessibility, and shipping faster."
                    variant="solid"
                    color="base"
                    style="width:300px;"
                    sections="ruled"
                >
                    <x-slot:footer>
                        <xushi:button variant="outline" style="width:100%;">Check out</xushi:button>
                    </x-slot:footer>
                </xushi:card>
            </div>
        </x-slot:preview>
    </xushi:democode>

    {{-- Login Card --}}
    <h4>Login Card</h4>
    <p>Cards work well as form containers for auth flows.</p>
    @php $code = <<<'BLADE'
<xushi:card sections="ruled" style="width:320px;">
    <div style="margin-bottom:16px;">
        <div style="font-size:1.3em;font-weight:700;">Login to your account</div>
        <div style="font-size:0.85em;opacity:0.6;">Review the terms before accepting the agreement.</div>
    </div>
    <xushi:forms.fieldset label="Email">
        <xushi:forms.input name="email" type="email" placeholder="your email..." />
    </xushi:forms.fieldset>
    <xushi:forms.fieldset label="Password">
        <xushi:forms.input name="password" type="password" placeholder="your password..." :viewable="true" />
    </xushi:forms.fieldset>
    <x-slot:footer>
        <xushi:button variant="solid" color="base" style="width:100%;margin-bottom:8px;">Log in</xushi:button>
        <xushi:button variant="ghost" style="width:100%;">log in with Google</xushi:button>
    </x-slot:footer>
</xushi:card>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <div style="display:flex;gap:16px;flex-wrap:wrap;align-items:flex-start;">
                <xushi:card footeralign="end" sections="ruled" style="width:320px;">
                    <div style="margin-bottom:16px;">
                        <div style="font-size:1.3em;font-weight:700;">Login to your account</div>
                        <div style="font-size:0.85em;opacity:0.6;">Review the terms before accepting the agreement.</div>
                    </div>
                    <xushi:forms.fieldset label="Email">
                        <xushi:forms.input name="email" type="email" placeholder="your email..." />
                    </xushi:forms.fieldset>
                    <xushi:forms.fieldset label="Password">
                        <xushi:forms.input name="password" type="password" placeholder="your password..." :viewable="true" />
                    </xushi:forms.fieldset>
                    <x-slot:footer>
                        <xushi:button variant="solid" color="base" style="width:100%;margin-bottom:8px;">Log in</xushi:button>
                        <xushi:button variant="ghost" style="width:100%;">log in with Google</xushi:button>
                    </x-slot:footer>
                </xushi:card>
                <xushi:card footeralign="center" sections="ruled" variant="solid" color="base" style="width:320px;">
                    <div style="margin-bottom:16px;">
                        <div style="font-size:1.3em;font-weight:700;">Login to your account</div>
                        <div style="font-size:0.85em;opacity:0.6;">Review the terms before accepting the agreement.</div>
                    </div>
                    <xushi:forms.fieldset label="Email">
                        <xushi:forms.input name="email" type="email" placeholder="your email..." />
                    </xushi:forms.fieldset>
                    <xushi:forms.fieldset label="Password">
                        <xushi:forms.input name="password" type="password" placeholder="your password..." :viewable="true" />
                    </xushi:forms.fieldset>
                    <x-slot:footer>
                        <xushi:button variant="outline" style="width:100%;margin-bottom:8px;">Log in</xushi:button>
                        <xushi:button variant="ghost" style="width:100%;">log in with Google</xushi:button>
                    </x-slot:footer>
                </xushi:card>
            </div>
        </x-slot:preview>
    </xushi:democode>



    {{-- ========================================================
         HEADING
    ========================================================= --}}
    <h2>Heading</h2>
    <p>Semantic heading levels with independent size and muted controls.</p>

    @php $code = <<<'BLADE'
<xushi:heading level="1">Heading level 1</xushi:heading>
<xushi:heading level="2">Heading level 2</xushi:heading>
<xushi:heading level="3">Heading level 3</xushi:heading>
<xushi:heading level="4">Heading level 4</xushi:heading>
<xushi:heading level="2" size="sm" :muted="true">Level 2, size sm, muted</xushi:heading>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <div style="width:100%;">
                <xushi:heading level="1">Heading level 1</xushi:heading>
                <xushi:heading level="2">Heading level 2</xushi:heading>
                <xushi:heading level="3">Heading level 3</xushi:heading>
                <xushi:heading level="4">Heading level 4</xushi:heading>
                <xushi:heading level="2" size="sm" :muted="true">Level 2, size sm, muted</xushi:heading>
            </div>
        </x-slot:preview>
    </xushi:democode>


    {{-- ========================================================
         ICON
    ========================================================= --}}
    <h2>Icon</h2>
    <p>Inline SVG icons from the XushiUI icon map. Use <code>name</code>, <code>size</code>, and <code>color</code> props.</p>

    @php $code = <<<'BLADE'
<xushi:icon name="star" size="1rem" />
<xushi:icon name="heart" size="1.5rem" />
<xushi:icon name="bell" size="2rem" color="var(--xushi-color-primary)" />
<xushi:icon name="trash" size="1.25rem" color="var(--xushi-color-danger)" />
<xushi:icon name="check-circle" size="1.5rem" color="var(--xushi-color-success)" />
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:icon name="star" size="1rem" />
            <xushi:icon name="heart" size="1.5rem" />
            <xushi:icon name="bell" size="2rem" color="var(--xushi-color-primary)" />
            <xushi:icon name="trash" size="1.25rem" color="var(--xushi-color-danger)" />
            <xushi:icon name="check-circle" size="1.5rem" color="var(--xushi-color-success)" />
        </x-slot:preview>
    </xushi:democode>


    {{-- ========================================================
         PROFILE
    ========================================================= --}}
    <h2>Profile</h2>
    <p>A user profile block combining an avatar, name, role, and optional email or trailing slot.</p>

    @php $code = <<<'BLADE'
<xushi:profile name="Zayne Admin" role="Lead Developer" email="zayne@example.com" />
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:profile name="Zayne Admin" role="Lead Developer" email="zayne@example.com" />
        </x-slot:preview>
    </xushi:democode>

    <h4>With Photo</h4>
    @php $code = <<<'BLADE'
<xushi:profile name="Jane Smith" role="Designer" src="https://i.pravatar.cc/80?u=jane" avatarSize="lg" />
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:profile name="Jane Smith" role="Designer" src="https://i.pravatar.cc/80?u=jane" avatarSize="lg" />
        </x-slot:preview>
    </xushi:democode>

    <h4>Layouts</h4>
    <p>Use the <code>layout</code> prop to switch between <code>horizontal</code>, <code>vertical</code>, and <code>compact</code>.</p>
    @php $code = <<<'BLADE'
<xushi:profile name="Alex Ray"   role="Product Manager" layout="vertical" avatarSize="xl" />
<xushi:profile name="Sam Lee"    role="DevOps"          layout="compact" />
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:profile name="Alex Ray" role="Product Manager" layout="vertical" avatarSize="xl" />
            <xushi:profile name="Sam Lee"  role="DevOps"          layout="compact" />
        </x-slot:preview>
    </xushi:democode>

    <h4>With Trailing Slot</h4>
    @php $code = <<<'BLADE'
<xushi:profile name="Chris Wong" role="Backend" href="/users/chris">
    <x-slot:trailing>
        <xushi:icon name="chevron-right" size="1rem" />
    </x-slot:trailing>
</xushi:profile>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:profile name="Chris Wong" role="Backend" href="/users/chris">
                <x-slot:trailing>
                    <xushi:icon name="chevron-right" size="1rem" />
                </x-slot:trailing>
            </xushi:profile>
        </x-slot:preview>
    </xushi:democode>


    {{-- ========================================================
         TEXT
    ========================================================= --}}
    <h2>Text</h2>
    <p>Semantic inline and block text variants for body copy, captions, code, and emphasis.</p>

    @php $code = <<<'BLADE'
<xushi:text variant="body">Body text — default paragraph.</xushi:text>
<xushi:text variant="strong">Strong — rendered as &lt;strong&gt;.</xushi:text>
<xushi:text variant="caption">Caption — rendered as &lt;span&gt;.</xushi:text>
<xushi:text variant="code">echo 'inline code snippet';</xushi:text>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <div style="width:100%; display:flex; flex-direction:column; gap:0.5rem;">
                <xushi:text variant="body">Body text — default paragraph.</xushi:text>
                <xushi:text variant="strong">Strong — rendered as &lt;strong&gt;.</xushi:text>
                <xushi:text variant="caption">Caption — rendered as &lt;span&gt;.</xushi:text>
                <xushi:text variant="code">echo 'inline code snippet';</xushi:text>
            </div>
        </x-slot:preview>
    </xushi:democode>

</div>
</x-layouts.layout>