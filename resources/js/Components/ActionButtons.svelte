<script>
    import { useBulkActions } from '@/Hooks/useBulkActions'

    export let path
    export let selected = []

    const { bulkDelete, editSelected } = useBulkActions(path)
</script>

<div class="w-screen px-4">
    <a href={`${path}/add`} class="btn">
        Add
    </a>
    <button
        class="btn btn-md"
        class:btn-disabled={selected.length === 0}
        disabled={selected.length === 0}
        on:click={() => bulkDelete(selected)}
    >
        Remove Selected ({selected.length})
    </button>
    <button
        class="btn"
        class:btn-disabled={selected.length !== 1}
        disabled={selected.length !== 1}
        on:click={() => editSelected(selected[0])}
    >
        Edit
    </button>
</div>
