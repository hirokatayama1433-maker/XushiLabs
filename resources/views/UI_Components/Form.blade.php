<x-layouts.layout>
    {{-- Autocomplete --}}
<h2>Autocomplete</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.autocomplete
        name="framework"
        placeholder="Search framework..."
        :options="['Laravel', 'Livewire', 'Inertia', 'Filament', 'Volt']"
    />

    <xushi:forms.autocomplete
        name="country"
        placeholder="Search country..."
        variant="soft"
        color="primary"
        :options="[
            ['label' => 'Philippines', 'value' => 'ph'],
            ['label' => 'Japan', 'value' => 'jp'],
            ['label' => 'United States', 'value' => 'us'],
            ['label' => 'Germany', 'value' => 'de'],
        ]"
    />

    <xushi:forms.autocomplete
        name="disabled_field"
        placeholder="Disabled autocomplete"
        :disabled="true"
        :options="['Option A', 'Option B']"
    />
</div>

{{-- Calendar --}}
<h2>Calendar</h2>
<div style="
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Single date --}}
    <xushi:forms.calendar name="date_single" mode="single" />

    {{-- Range mode --}}
    <xushi:forms.calendar name="date_range" mode="range" />

    {{-- Multiple mode with week numbers --}}
    <xushi:forms.calendar
        name="date_multi"
        mode="multiple"
        :weeknumbers="true"
        :showtoday="true"
    />
</div>

{{-- Checkbox --}}
<h2>Checkbox</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.checkbox name="agree" value="1">Accept terms and conditions</xushi:forms.checkbox>
    <xushi:forms.checkbox name="newsletter" value="1" :checked="true" color="primary">Subscribe to newsletter</xushi:forms.checkbox>
    <xushi:forms.checkbox name="notify" value="1" color="success">Enable notifications</xushi:forms.checkbox>
    <xushi:forms.checkbox name="warnings" value="1" color="warning">Show warnings</xushi:forms.checkbox>
    <xushi:forms.checkbox name="delete" value="1" color="danger">Allow deletions</xushi:forms.checkbox>
    <xushi:forms.checkbox name="soft_check" value="1" variant="soft" color="primary" :checked="true">Soft variant</xushi:forms.checkbox>
    <xushi:forms.checkbox name="disabled_cb" value="1" :disabled="true">Disabled checkbox</xushi:forms.checkbox>
</div>

{{-- Color Picker --}}
<h2>Color Picker</h2>
<div style="
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    {{-- Popover mode (default) --}}
    <xushi:forms.color-picker name="brand_color" value="#6366f1" format="hex" mode="popover" />

    {{-- With alpha channel --}}
    <xushi:forms.color-picker name="overlay_color" value="#6366f1" format="hex" :alpha="true" mode="popover" />

    {{-- Inline (embedded) --}}
    <xushi:forms.color-picker name="bg_color" value="#22c55e" format="hex" mode="inline" />
</div>

{{-- Date Picker --}}
<h2>Date Picker</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.date-picker name="start_date" placeholder="Pick a date" />

    <xushi:forms.date-picker
        name="end_date"
        placeholder="Pick end date"
        variant="soft"
        color="primary"
        format="YYYY-MM-DD"
        min="2025-01-01"
        max="2026-12-31"
    />

    <xushi:forms.date-picker name="disabled_date" placeholder="Disabled" :disabled="true" />
</div>

{{-- Fieldset --}}
<h2>Fieldset</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 10px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.fieldset label="Username" hint="Must be at least 4 characters.">
        <xushi:forms.input name="username" placeholder="Enter username" />
    </xushi:forms.fieldset>

    <xushi:forms.fieldset label="Email" error="This email is already taken.">
        <xushi:forms.input name="email" type="email" placeholder="you@example.com" color="danger" />
    </xushi:forms.fieldset>

    <xushi:forms.fieldset label="Notifications">
        <xushi:forms.checkbox name="email_notify" value="1">Email</xushi:forms.checkbox>
        <xushi:forms.checkbox name="sms_notify" value="1">SMS</xushi:forms.checkbox>
    </xushi:forms.fieldset>
</div>

{{-- File --}}
<h2>File</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.file name="avatar" accept="image/*" />
    <xushi:forms.file name="documents" :multiple="true" accept=".pdf,.doc,.docx" variant="soft" color="primary" />
    <xushi:forms.file name="disabled_file" :disabled="true" />
</div>

{{-- Input --}}
<h2>Input</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.input name="text_default" placeholder="Default outline input" />
    <xushi:forms.input name="text_soft" placeholder="Soft input" variant="soft" color="primary" />
    <xushi:forms.input name="text_success" placeholder="Success state" color="success" />
    <xushi:forms.input name="text_danger" placeholder="Error state" color="danger" :invalid="true" />
    <xushi:forms.input name="with_icon" placeholder="Search..." icon="search" />
    <xushi:forms.input name="password" type="password" placeholder="Password" :viewable="true" />
    <xushi:forms.input name="copyable_field" value="copy-me-value" :copyable="true" />
    <xushi:forms.input name="clearable_field" placeholder="Clearable input" :clearable="true" />
    <xushi:forms.input name="with_kbd" placeholder="Press to search" kbd="⌘K" />
    <xushi:forms.input name="disabled_input" placeholder="Disabled" :disabled="true" />
    <xushi:forms.input name="sm_input" placeholder="Small input" size="sm" />
    <xushi:forms.input name="lg_input" placeholder="Large input" size="lg" />
</div>

{{-- OTP --}}
<h2>OTP</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 10px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.otp name="otp_code" :length="6" size="md" type="numeric" />
    <xushi:forms.otp name="otp_alpha" :length="4" size="lg" type="alphanumeric" color="primary" />
    <xushi:forms.otp name="otp_sm" :length="6" size="sm" variant="soft" color="primary" />
    <xushi:forms.otp name="otp_disabled" :length="6" :disabled="true" />
</div>

{{-- Pillbox --}}
<h2>Pillbox</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.pillbox name="tags[]" placeholder="Add tag..." />

    <xushi:forms.pillbox
        name="skills[]"
        placeholder="Add skill..."
        :value="['Laravel', 'Alpine.js']"
        tagcolor="success"
        tagvariant="soft"
    />

    <xushi:forms.pillbox
        name="keywords[]"
        placeholder="Add keyword..."
        :max="3"
        variant="soft"
        color="primary"
    />
</div>

{{-- Radio --}}
<h2>Radio</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.radio name="plan" value="free">Free</xushi:forms.radio>
    <xushi:forms.radio name="plan" value="pro" :checked="true" color="primary">Pro</xushi:forms.radio>
    <xushi:forms.radio name="plan" value="enterprise" color="secondary">Enterprise</xushi:forms.radio>
    <xushi:forms.radio name="plan_soft" value="soft" variant="soft" color="primary" :checked="true">Soft variant</xushi:forms.radio>
    <xushi:forms.radio name="plan_disabled" value="disabled" :disabled="true">Disabled</xushi:forms.radio>
</div>

{{-- Range --}}
<h2>Range</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.range name="volume" :min="0" :max="100" :step="1" :value="50" />
    <xushi:forms.range name="brightness" :min="0" :max="100" :step="10" :value="70" />
    <xushi:forms.range name="disabled_range" :min="0" :max="100" :value="30" :disabled="true" />

    {{-- With live value display --}}
    <div x-data="{ val: 40 }" style="display:flex; align-items:center; gap:10px;">
        <xushi:forms.range name="live_range" :min="0" :max="100" :step="5" x-model="val" style="flex:1;" />
        <xushi:feedback.badge variant="soft" color="primary" x-text="val + '%'"></xushi:feedback.badge>
    </div>
</div>

{{-- Select --}}
<h2>Select</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.select name="role">
        <option value="">Select a role...</option>
        <option value="admin">Admin</option>
        <option value="editor">Editor</option>
        <option value="viewer">Viewer</option>
    </xushi:forms.select>

    <xushi:forms.select name="status" variant="soft" color="primary">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
        <option value="pending">Pending</option>
    </xushi:forms.select>

    <xushi:forms.select name="disabled_select" :disabled="true">
        <option>Disabled select</option>
    </xushi:forms.select>
</div>

{{-- Textarea --}}
<h2>Textarea</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.textarea name="bio" placeholder="Tell us about yourself..." :rows="4" />
    <xushi:forms.textarea name="notes" placeholder="Soft primary textarea..." variant="soft" color="primary" :rows="3" />
    <xushi:forms.textarea name="error_field" placeholder="Something went wrong..." color="danger" :rows="3" />
    <xushi:forms.textarea name="disabled_ta" placeholder="Disabled textarea" :disabled="true" :rows="2" />
</div>

{{-- Time Picker --}}
<h2>Time Picker</h2>
<div style="
    display: flex;
    flex-direction: column;
    gap: 6px;
    border: 1px solid #faf8f8;
    padding: 10px;
    border-radius: 10px;
">
    <xushi:forms.time-picker name="meeting_time" placeholder="Pick a time" />

    <xushi:forms.time-picker
        name="event_time"
        placeholder="Pick time with seconds"
        :seconds="true"
        variant="soft"
        color="primary"
    />

    <xushi:forms.time-picker
        name="schedule_time"
        placeholder="12-hour format"
        :meridiem="true"
        value="14:30"
    />

    <xushi:forms.time-picker name="disabled_time" placeholder="Disabled" :disabled="true" />
</div>
</x-layouts.layout>