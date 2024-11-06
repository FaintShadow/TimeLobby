<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import {page, router} from "@inertiajs/svelte";
    import {goto} from "@/Components/Goto.svelte";
    import PaginateLayout from "@/Components/Paginate.svelte";

    // Vars
    export let success
    let values = []

    // Reactive:
    $: academics = $page.props.academics
    $: succ = success || {}
    $: selected = []
    $: institutes = $page.props.searched_institutes


    // Functions:
    $: {
        values = academics.data.map(item => item.id);
    }

    function toggleAll(e) {
        selected = e.target.checked ? [...values] : []
    }

    function removeSelected() {
        // TODO: add alert if there is nothing selected
        if (selected.length === 0) return;

        if (confirm(`Are you sure you want to remove ${selected.length} selected items?`)) {
            router.delete('academics/bulkdelete',
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
        goto(`academics/edit/${selected[0]}`);
    }

    function loadPage(url) {
        if (!url) return;
        router.get(url, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (page) => {
                academics = page.props.academics;
            }
        });
    }

</script>

<AuthenticatedLayout>
    <div class="w-screen px-4">
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
    <div id="academics" class="px-4 w-screen my-1">
        <div class="bg-base-200 flex flex-row justify-items-center p-1.5 rounded-md my-1">
            <div class="flex justify-center border-r-2 pr-2 border-base-100">
                <label class="h-0">
                    <input
                        type="checkbox"
                        on:change={toggleAll}
                        checked={selected.length === academics.data.length}
                        class="checkbox"/>
                </label>
            </div>
            <div class="text-base-content px-2 sm:min-w-64 max-sm:w-full">Name</div>
            <div class="min-w-24 text-base-content px-2 border-base-100 border-r-2 text-right max-sm:border-r-0">Role
            </div>
            <div class="w-full text-base-content px-2 hidden border-base-100 sm:inline">Institute</div>
        </div>
        {#if academics.data}
            {#each Object.entries(academics.data) as [id, academic]}
                <div class="flex flex-row justify-items-center p-1.5 rounded-md my-1">
                    <div class="flex justify-center border-r-2 pr-2">
                        <label class="h-0">
                            <input type="checkbox" bind:group={selected} class="checkbox"
                                   name="academics" value="{academic.id}"/>
                        </label>
                    </div>
                    <div class="px-2 sm:min-w-64 max-sm:w-full">{academic.firstname + '. ' + academic.lastname}</div>
                    <div class="min-w-24 px-2 border-r-2 text-right max-sm:border-r-0">
                        <div class="badge badge-info text-info-content mx-0">
                            { academic.role.replace("institute-", "")}
                        </div>
                    </div>
                    <div
                        class="w-full pl-2 gap-2 sm:flex max-sm:hidden"
                        class:flex={!academic.institute}
                        class:flex-row={!academic.institute}
                        class:flex-justify-center={!academic.institute}
                    >
                        {#if academic.institute}
                            {academic.institute.name}
                        {:else}
                            <div class="dropdown w-full">
                                <div tabindex="0" role="button"
                                     class="select select-sm select-bordered w-full text-left overflow-hidden">Select an
                                    institute
                                </div>
                                <ul class="dropdown-content w-full menu bg-base-100 rounded-box z-[1] p-2 shadow">
                                    <li>
                                        <label
                                            class="input input-bordered input-sm w-full flex items-center gap-2 mb-2">
                                            <input type="text" class="grow w-full" placeholder="Search"/>
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 16 16"
                                                fill="currentColor"
                                                class="h-4 w-4 opacity-70">
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                                    clip-rule="evenodd"/>
                                            </svg>
                                        </label>
                                    </li>
                                    {#each Object.entries(institutes) as [id, inst]}
                                        <li>
                                            <label class="label cursor-pointer">
                                                <span class="label-text">{inst.name}</span>
                                                <input type="radio" name="institute" class="radio checked:bg-blue-500"/>
                                            </label>
                                        </li>
                                    {/each}
                                </ul>
                            </div>
                            <button
                                class="btn btn-sm w-fit"
                            >
                                Assign
                            </button>
                        {/if}
                    </div>
                </div>
            {/each}
        {/if}
        <PaginateLayout links={academics.links} {loadPage}/>
    </div>
</AuthenticatedLayout>
