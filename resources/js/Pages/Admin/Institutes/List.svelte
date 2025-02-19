<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import {router} from "@inertiajs/svelte";
    import PaginateLayout from "@/Components/Paginate.svelte";
    import autoAnimate from "@formkit/auto-animate";

    // Vars
    export let success, institutes;

    let values = []
    let innerWidth;
    let innerHeight;

    $: selected = [];

    // Functions:
    $: {
        values = institutes.data.map(item => item.id);
    }

    function toggleAll(e) {
        selected = e.target.checked ? [...values] : [];
    }

    function removeSelected() {
        // TODO: add alert if there is nothing selected
        if (selected.length === 0) return;

        if (confirm(`Are you sure you want to remove ${selected.length} selected items?`)) {
            router.delete('institutes/bulkdelete',
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
        // TODO: add alert if there is nothing selected
        if (selected.length === 0) return;
        router.get(`institutes/edit/${selected[0]}`);
    }

    function loadPage(url) {
        if (!url) return;
        router.get(url, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (page) => {
                institutes = page.props.institutes;
            }
        });
    }

</script>

<svelte:window bind:innerWidth bind:innerHeight/>

<AuthenticatedLayout>
    <div class="w-screen px-4">
        <a href="institutes/add" class="btn">
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
    <div id="institutes" class="px-4 w-screen my-1" use:autoAnimate>
        <div class="bg-base-200 flex flex-row justify-items-center p-1.5 rounded-md my-1">
            <div class="flex justify-center border-r-2 pr-2 border-base-100">
                <label class="h-0">
                    <input
                        type="checkbox"
                        on:change={toggleAll}
                        checked={selected.length === values.length}
                        class="checkbox"/>
                </label>
            </div>
            <div class="w-full text-base-content px-2 border-r-0 border-base-100 sm:border-r-2">Name</div>
            <div class="min-w-20 text-base-content px-2 hidden border-base-100 sm:inline border-r-2">Students</div>
            <div class="min-w-12 text-base-content px-2 hidden border-base-100 sm:inline">Staff</div>
        </div>
        {#if institutes}
            {#each Object.entries(institutes.data) as [id, institute]}
                <div class="flex flex-row justify-items-center p-1.5 rounded-md my-1" use:autoAnimate>
                    <div class="flex justify-center border-r-2 pr-2 border-base-200">
                        <label class="h-0">
                            <input type="checkbox" bind:group={selected} class="checkbox"
                                   name="institutes" value="{institute.id}"/>
                        </label>
                    </div>
                    <div class="w-full px-2 border-r-0 sm:border-r-2 border-base-200">{institute.name}</div>
                    {#if innerWidth > 640}
                        <div class="min-w-20 px-2 border-r-2 border-base-200">{institute.students}</div>
                        <div class="min-w-12 px-2">{institute.academics}</div>
                    {/if}
                </div>
            {/each}
        {/if}
    </div>
    <PaginateLayout links={institutes.links} {loadPage}/>
</AuthenticatedLayout>
