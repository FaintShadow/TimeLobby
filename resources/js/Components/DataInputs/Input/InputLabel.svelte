<script lang="ts">
    import {LabelTextConsts} from "./LabelType";
    import type {LabelType} from "./LabelType";

    export let label: LabelType;
</script>

{#if label.show === undefined || label.show}
    <div
        class="label"
        class:p-0.5={label.position === LabelTextConsts.BOTTOM}
    >
        <span
            class="label-text{label.position === LabelTextConsts.BOTTOM ? '-alt' : null} {label.left.styling ?? null}"
            class:badge={label.left.type === LabelTextConsts.BADGE}
        >
            {@html label.left.text.toString().replace('.,', '.<br>')}
        </span>

        {#if label.right}
            <span
                class="label-text-alt {label.right.styling ?? null}"
                class:badge={label.right.type === LabelTextConsts.BADGE}
            >
                {label.right.text}
            </span>
        {/if}
    </div>
{/if}
