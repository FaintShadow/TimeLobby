<script>
    import autoAnimate from "@formkit/auto-animate";
    export let columns = [];
    export let onToggleAll;
    export let allSelected = false;
    export let showCheckbox = true;
</script>

<div class="bg-base-200 flex flex-row justify-items-center p-1.5 rounded-md my-1" use:autoAnimate>
    {#if showCheckbox}
        <div class="flex justify-center border-r-2 pr-2 border-base-100">
            <label class="h-0">
                <input
                    type="checkbox"
                    on:change={onToggleAll}
                    checked={allSelected}
                    class="checkbox"
                />
            </label>
        </div>
    {/if}

    {#each columns as column}
        <div
            class="text-base-content px-2 {column.class ?? ''} {column.borderClass ?? 'border-base-100 border-r-2'}"
            class:hidden={column.hideOnMobile && innerWidth <= 640}
        >
            {column.label}
        </div>
    {/each}
</div>
