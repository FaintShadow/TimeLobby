<script>
    export let selected = [];
    export let onRemove;
    export let onEdit;
    export let showAddButton = false;
    export let addUrl = '';
    export let entityName = 'Selected';
</script>

<div class="w-screen px-4 max-sm:mb-2">
    {#if showAddButton}
        <a href={addUrl} class="btn">
            Add
        </a>
    {/if}
    <button
        class="btn btn-md"
        class:btn-disabled={selected.length === 0}
        disabled={selected.length === 0}
        on:click={onRemove}
    >
        Remove {entityName} ({selected.length})
    </button>
    <button
        class="btn"
        class:btn-disabled={selected.length !== 1}
        disabled={selected.length !== 1}
        on:click={onEdit}
    >
        Edit
    </button>
</div>
