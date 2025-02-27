<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte"
    import { router } from "@inertiajs/svelte"

    // Vars
    export let buildings
    let values = []

    // Reactive:
    $: selected = []

    // Functions:
    $: {
        values = buildings.data.map(item => item.id)
    }

    function toggleAll(e) {
        selected = e.target.checked ? [...values] : []
    }

    function removeSelected() {
        // TODO: add alert if there is nothing selected
        if (selected.length === 0) return;

        if (confirm(`Are you sure you want to remove ${selected.length} selected items?`)) {
            router.delete('buildings/bulkdelete',
                {
                    data: {
                        ids: selected
                    },
                    preserveScroll: true,
                    onSuccess: () => {
                        selected = [];
                    },
                });
        }
    }

    function editSelected() {
        if (selected.length !== 1) return;
        router.get(`buildings/edit/${selected[0]}`)
    }

</script>

<svelte:head>
    <title>TL : Buildings</title>
</svelte:head>

<AuthenticatedLayout>
    <div class="w-screen px-4">
        <a href="buildings/add" class="btn">
            Add
        </a>
        <button
            class="btn btn-md"
            class:btn-disabled={selected.length === 0}
            disabled={selected.length === 0}
            on:click={removeSelected}
        >
            Remove Selected ({selected.length})
        </button>
        <button
            class="btn"
            class:btn-disabled={selected.length !== 1}
            disabled={selected.length !== 1}
            on:click={editSelected}
        >
            Edit
        </button>
    </div>
    <!--Table -->
    <!--TODO: Manage what happens when there is nothing in the database-->
    {#if buildings.data.length > 0}
        <div id="buildings" class="px-4 w-screen my-1">
            <div class="bg-base-200 flex flex-row justify-items-center p-1.5 rounded-md my-1">
                <div class="flex justify-center border-r-2 border-base-100 pr-2">
                    <label class="h-0">
                        <input
                            type="checkbox"
                            on:change={toggleAll}
                            checked={selected.length === values.length}
                            class="checkbox"/>
                    </label>
                </div>
                <div class="w-full text-base-content px-2">Name</div>
                <div class="min-w-12 text-base-content px-2">Type</div>
            </div>
            {#each buildings.data as build}
                <div class="flex flex-row justify-items-center p-1.5 rounded-md my-1">
                    <div class="flex justify-center border-r-2 border-base-200 pr-2">
                        <label class="h-0">
                            <input type="checkbox" bind:group={selected} class="checkbox"
                                   name="buildings" value="{build.id}"/>
                        </label>
                    </div>
                    <div class="w-full px-2">{build.name}</div>
                    <div class="min-w-fit text-right px-2">
                        <div
                            class="badge mx-0"
                            class:badge-secondary={build.building_id}
                            class:badge-primary={!build.building_id}
                        >
                            {build.building_id ? "Classroom ➤ " + build.building.name : "Building"}
                        </div>
                    </div>
                </div>
            {/each}
        </div>
    {/if}
</AuthenticatedLayout>
