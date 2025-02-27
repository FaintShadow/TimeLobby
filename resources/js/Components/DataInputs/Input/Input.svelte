<script lang="ts">
    import InputLabel from "./InputLabel.svelte"
    import type {LabelType} from "./LabelType"

    // Labels:
    export let topLabel: LabelType
    export let bottomLabel!: LabelType

    // Input props
    export let type: "text" | "email" | "number" | "date" | "textarea" = "text"
    export let styling = ''
    export let min
    export let max
    export let inputSize = "sm";
    export let maxlength
    export let required = true
    export let placeholder: string
    export let value: string | number = ''
    export let readonly: boolean = false

    $: {
        console.log("input value: ", value)
    }
</script>

<label class="form-control {styling}">
    <InputLabel
        label={topLabel}
    />
    {#if type === "number"}
        <input
            type="number"
            {required}
            {placeholder}
            bind:value
            {min}
            {max}
            {maxlength}
            class="input input-{inputSize} input-bordered w-full"
            class:input-error={bottomLabel?.show}
            class:input-disabled={readonly}
            {readonly}
        />
    {:else if type === "email"}
        <input
            type="email"
            {required}
            {placeholder}
            bind:value
            class="input input-{inputSize} input-bordered w-full"
            class:input-error={bottomLabel?.show}
            class:input-disabled={readonly}
            {readonly}
        />
    {:else if type === "date"}
        <input
            type="date"
            {required}
            {placeholder}
            bind:value
            class="input input-{inputSize} input-bordered w-full"
            class:input-error={bottomLabel?.show}
            class:input-disabled={readonly}
            {readonly}
        />
    {:else if type === "textarea"}
        <textarea
            {required}
            {placeholder}
            bind:value
            class="textarea leading-normal h-16 textarea-{inputSize} textarea-bordered w-full"
            class:textarea-error={bottomLabel?.show}
            class:textarea-disabled={readonly}
            {readonly}
        />
    {:else}
        <input
            type="text"
            {required}
            {placeholder}
            bind:value
            class="input input-{inputSize} input-bordered w-full"
            class:input-error={bottomLabel?.show}
            class:input-disabled={readonly}
            {readonly}
        />
    {/if}

    {#if bottomLabel}
        <InputLabel
            label={bottomLabel}
        />
    {/if}
</label>
