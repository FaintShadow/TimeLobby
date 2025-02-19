<script>
    import autoAnimate from "@formkit/auto-animate";
    export let item;
    export let selected = [];
    export let columns = [];
    export let showCheckbox = true;
</script>

<div class="flex flex-row justify-items-center p-1.5 rounded-md my-1" use:autoAnimate>
    {#if showCheckbox}
        <div class="flex justify-center border-r-2 border-base-200 pr-2">
            <label class="h-0">
                <input
                        type="checkbox"
                        bind:group={selected}
                        class="checkbox min-h-fit"
                        value={item.id}
                />
            </label>
        </div>
    {/if}

    {#each columns as column}
        <div
                class="px-2 {column.class ?? ''} {column.borderClass ?? 'border-base-200 border-r-2'}"
                class:hidden={column.hideOnMobile && innerWidth <= 640}
        >
            {#if column.template}
                {@html column.template(item)}
            {:else}
                {item[column.field]}
            {/if}
        </div>
    {/each}
</div>
