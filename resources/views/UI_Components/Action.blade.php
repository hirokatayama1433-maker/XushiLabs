<x-layouts.layout>
<div style="width:100%; display:flex; flex-direction:column; gap:1.5rem;">

    <h2>Button</h2>
    <p>A powerful and composable button component for your application.</p>

    @php $code = '<xushi:button>Button</xushi:button>'; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview><xushi:button>Button</xushi:button></x-slot:preview>
    </xushi:democode>

    <h4>Sizes</h4>
    <p>Use the <code>size</code> prop to change the size of the button.</p>
    @php $code = <<<'BLADE'
<xushi:button size="xs">Extra Small</xushi:button>
<xushi:button size="sm">Small</xushi:button>
<xushi:button size="md">Medium</xushi:button>
<xushi:button size="lg">Large</xushi:button>
<xushi:button size="xl">Extra Large</xushi:button>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:button size="xs">Extra Small</xushi:button>
            <xushi:button size="sm">Small</xushi:button>
            <xushi:button size="md">Medium</xushi:button>
            <xushi:button size="lg">Large</xushi:button>
            <xushi:button size="xl">Extra Large</xushi:button>
        </x-slot:preview>
    </xushi:democode>

    <h4>Variants</h4>
    <p>Use the <code>variant</code> prop to change the visual style of the button.</p>
    @php $code = <<<'BLADE'
<xushi:button variant="solid"   color="primary">Solid</xushi:button>
<xushi:button variant="soft"    color="primary">Soft</xushi:button>
<xushi:button variant="outline" color="primary">Outline</xushi:button>
<xushi:button variant="ghost"   color="primary">Ghost</xushi:button>
<xushi:button variant="dashed"  color="primary">Dashed</xushi:button>
<xushi:button variant="link"    color="primary">Link</xushi:button>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:button variant="solid"   color="primary">Solid</xushi:button>
            <xushi:button variant="soft"    color="primary">Soft</xushi:button>
            <xushi:button variant="outline" color="primary">Outline</xushi:button>
            <xushi:button variant="ghost"   color="primary">Ghost</xushi:button>
            <xushi:button variant="dashed"  color="primary">Dashed</xushi:button>
            <xushi:button variant="link"    color="primary">Link</xushi:button>
        </x-slot:preview>
    </xushi:democode>

    <h4>Colors</h4>
    <p>Use the <code>color</code> prop to apply a semantic color to the button.</p>
    @php $code = <<<'BLADE'
<xushi:button color="primary">Primary</xushi:button>
<xushi:button color="secondary">Secondary</xushi:button>
<xushi:button color="success">Success</xushi:button>
<xushi:button color="danger">Danger</xushi:button>
<xushi:button color="warning">Warning</xushi:button>
<xushi:button color="info">Info</xushi:button>
<xushi:button color="base">Base</xushi:button>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:button color="primary">Primary</xushi:button>
            <xushi:button color="secondary">Secondary</xushi:button>
            <xushi:button color="success">Success</xushi:button>
            <xushi:button color="danger">Danger</xushi:button>
            <xushi:button color="warning">Warning</xushi:button>
            <xushi:button color="info">Info</xushi:button>
            <xushi:button color="base">Base</xushi:button>
        </x-slot:preview>
    </xushi:democode>

    <h4>With Icons</h4>
    <p>Use the <code>icon</code> and <code>iconTrailing</code> props to add icons. Pass only an icon with no label for an icon-only button.</p>
    @php $code = <<<'BLADE'
<xushi:button icon="house">Leading Icon</xushi:button>
<xushi:button iconTrailing="arrow-right">Trailing Icon</xushi:button>
<xushi:button icon="house" iconTrailing="arrow-right">Both Icons</xushi:button>
<xushi:button icon="trash" color="danger" variant="soft" />
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:button icon="house">Leading Icon</xushi:button>
            <xushi:button iconTrailing="arrow-right">Trailing Icon</xushi:button>
            <xushi:button icon="house" iconTrailing="arrow-right">Both Icons</xushi:button>
            <xushi:button icon="trash" color="danger" variant="soft"/>
        </x-slot:preview>
    </xushi:democode>

    <h4>States</h4>
    <p>Use the <code>disabled</code> and <code>fullwidth</code> props to control button state and width.</p>
    @php $code = <<<'BLADE'
<xushi:button>Normal</xushi:button>
<xushi:button disabled>Disabled</xushi:button>
<xushi:button fullwidth>Full Width</xushi:button>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:button>Normal</xushi:button>
            <xushi:button disabled>Disabled</xushi:button>
            <xushi:button fullwidth>Full Width</xushi:button>
        </x-slot:preview>
    </xushi:democode>

    <h4>As Link</h4>
    <p>Pass an <code>href</code> prop to render the button as an anchor tag.</p>
    @php $code = <<<'BLADE'
<xushi:button href="#" color="primary">Anchor Button</xushi:button>
<xushi:button href="#" variant="outline" color="secondary" icon="arrow-right">Go somewhere</xushi:button>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:button href="#" color="primary">Anchor Button</xushi:button>
            <xushi:button href="#" variant="outline" color="secondary" icon="arrow-right">Go somewhere</xushi:button>
        </x-slot:preview>
    </xushi:democode>


    <h2>Toggle</h2>
    <p>A styled checkbox toggle for boolean on/off inputs.</p>

    @php $code = '<xushi:toggle>Enable notifications</xushi:toggle>'; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview><xushi:toggle>Enable notifications</xushi:toggle></x-slot:preview>
    </xushi:democode>

    <h4>Sizes</h4>
    <p>Use the <code>size</code> prop to change the size of the toggle.</p>
    @php $code = <<<'BLADE'
<xushi:toggle size="xs">Extra Small</xushi:toggle>
<xushi:toggle size="sm">Small</xushi:toggle>
<xushi:toggle size="md">Medium</xushi:toggle>
<xushi:toggle size="lg">Large</xushi:toggle>
<xushi:toggle size="xl">Extra Large</xushi:toggle>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:toggle size="xs">Extra Small</xushi:toggle>
            <xushi:toggle size="sm">Small</xushi:toggle>
            <xushi:toggle size="md">Medium</xushi:toggle>
            <xushi:toggle size="lg">Large</xushi:toggle>
            <xushi:toggle size="xl">Extra Large</xushi:toggle>
        </x-slot:preview>
    </xushi:democode>

    <h4>Colors</h4>
    <p>Use the <code>color</code> prop to apply a semantic color when the toggle is on.</p>
    @php $code = <<<'BLADE'
<xushi:toggle color="primary"   checked>Primary</xushi:toggle>
<xushi:toggle color="secondary" checked>Secondary</xushi:toggle>
<xushi:toggle color="success"   checked>Success</xushi:toggle>
<xushi:toggle color="danger"    checked>Danger</xushi:toggle>
<xushi:toggle color="warning"   checked>Warning</xushi:toggle>
<xushi:toggle color="info"      checked>Info</xushi:toggle>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:toggle color="primary"   :checked="true">Primary</xushi:toggle>
            <xushi:toggle color="secondary" :checked="true">Secondary</xushi:toggle>
            <xushi:toggle color="success"   :checked="true">Success</xushi:toggle>
            <xushi:toggle color="danger"    :checked="true">Danger</xushi:toggle>
            <xushi:toggle color="warning"   :checked="true">Warning</xushi:toggle>
            <xushi:toggle color="info"      :checked="true">Info</xushi:toggle>
        </x-slot:preview>
    </xushi:democode>

    <h4>Variants</h4>
    <p>Use the <code>variant</code> prop to switch between solid and soft track styles.</p>
    @php $code = <<<'BLADE'
<xushi:toggle variant="solid" color="primary" checked>Solid</xushi:toggle>
<xushi:toggle variant="soft"  color="primary" checked>Soft</xushi:toggle>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:toggle variant="solid" color="primary" :checked="true">Solid</xushi:toggle>
            <xushi:toggle variant="soft"  color="primary" :checked="true">Soft</xushi:toggle>
        </x-slot:preview>
    </xushi:democode>

    <h4>States</h4>
    <p>Toggles can be checked, unchecked, or disabled in either state.</p>
    @php $code = <<<'BLADE'
<xushi:toggle>Off</xushi:toggle>
<xushi:toggle checked>On</xushi:toggle>
<xushi:toggle disabled>Disabled Off</xushi:toggle>
<xushi:toggle checked disabled>Disabled On</xushi:toggle>
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:toggle>Off</xushi:toggle>
            <xushi:toggle :checked="true">On</xushi:toggle>
            <xushi:toggle disabled>Disabled Off</xushi:toggle>
            <xushi:toggle :checked="true" disabled>Disabled On</xushi:toggle>
        </x-slot:preview>
    </xushi:democode>

    <h4>Without Label</h4>
    <p>Omit the slot to render the toggle alone.</p>
    @php $code = <<<'BLADE'
<xushi:toggle size="xs" />
<xushi:toggle size="sm" />
<xushi:toggle size="md" />
<xushi:toggle size="lg" />
<xushi:toggle size="xl" />
BLADE; @endphp
    <xushi:democode :code="$code">
        <x-slot:preview>
            <xushi:toggle size="xs" />
            <xushi:toggle size="sm" />
            <xushi:toggle size="md" />
            <xushi:toggle size="lg" />
            <xushi:toggle size="xl" />
        </x-slot:preview>
    </xushi:democode>

</div>
</x-layouts.layout>