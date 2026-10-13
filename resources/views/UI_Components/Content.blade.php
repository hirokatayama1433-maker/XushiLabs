<x-layouts.layout>
<h2>Accordion</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:content.accordion variant="default" default="item-1">
        <xushi:content.accordion-item value="item-1">
            <x-slot:heading>What is XushiUI?</x-slot:heading>
            A CSS token-driven component engine for Laravel + Blade.
        </xushi:content.accordion-item>
        <xushi:content.accordion-item value="item-2">
            <x-slot:heading>Does it use Tailwind?</x-slot:heading>
            No. XushiUI is entirely token-driven with no build step required.
        </xushi:content.accordion-item>
        <xushi:content.accordion-item value="item-3" disabled>
            <x-slot:heading>Disabled item</x-slot:heading>
            This item is not interactive.
        </xushi:content.accordion-item>
    </xushi:content.accordion>

    <xushi:content.accordion variant="separated" :multiple="true">
        <xushi:content.accordion-item value="sep-1">
            <x-slot:heading>Separated + multiple open</x-slot:heading>
            Each item is its own bordered card.
        </xushi:content.accordion-item>
        <xushi:content.accordion-item value="sep-2">
            <x-slot:heading>Second item</x-slot:heading>
            Both items can be open at the same time.
        </xushi:content.accordion-item>
    </xushi:content.accordion>
</div>

{{-- Avatar --}}
<h2>Avatar</h2>
<div style="
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:content.avatar size="sm" alt="John Doe" />
    <xushi:content.avatar size="md" alt="Jane Smith" variant="solid" color="primary" />
    <xushi:content.avatar size="lg" alt="Alex Ray" variant="soft" color="secondary" />
    <xushi:content.avatar size="xl" src="https://i.pravatar.cc/80" alt="Photo" />
</div>

{{-- Card --}}
<h2>Card</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:content.card title="Basic card" description="A solid base card with title and description.">
        Card body content goes here.
    </xushi:content.card>

    <xushi:content.card
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
    </xushi:content.card>
</div>

{{-- Heading --}}
<h2>Heading</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:content.heading level="1">Heading level 1</xushi:content.heading>
    <xushi:content.heading level="2">Heading level 2</xushi:content.heading>
    <xushi:content.heading level="3">Heading level 3</xushi:content.heading>
    <xushi:content.heading level="4">Heading level 4</xushi:content.heading>
    <xushi:content.heading level="2" size="sm" :muted="true">Level 2, size sm, muted</xushi:content.heading>
</div>

{{-- Icon --}}
<h2>Icon</h2>
<div style="
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:icon name="star" size="1rem" />
    <xushi:icon name="heart" size="1.5rem" />
    <xushi:icon name="bell" size="2rem" color="var(--xushi-color-primary)" />
    <xushi:icon name="trash" size="1.25rem" color="var(--xushi-color-danger)" />
    <xushi:icon name="check-circle" size="1.5rem" color="var(--xushi-color-success)" />
</div>

{{-- Profile --}}
<h2>Profile</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:content.profile name="Zayne Admin" role="Lead Developer" email="zayne@example.com" />
    <xushi:content.profile name="Jane Smith" role="Designer" src="https://i.pravatar.cc/80?u=jane" avatarSize="lg" />
    <xushi:content.profile name="Alex Ray" role="Product Manager" layout="vertical" avatarSize="xl" />
    <xushi:content.profile name="Sam Lee" role="DevOps" layout="compact" />
    <xushi:content.profile name="Chris Wong" role="Backend" href="/users/chris">
        <x-slot:trailing>
            <xushi:icon name="chevron-right" size="1rem" />
        </x-slot:trailing>
    </xushi:content.profile>
</div>

{{-- Text --}}
<h2>Text</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:content.text variant="body">Body text — default paragraph.</xushi:content.text>
    <xushi:content.text variant="strong">Strong — rendered as &lt;strong&gt;.</xushi:content.text>
    <xushi:content.text variant="caption">Caption — rendered as &lt;span&gt;.</xushi:content.text>
    <xushi:content.text variant="code">echo 'inline code snippet';</xushi:content.text>
</div>
</x-layouts.layout>