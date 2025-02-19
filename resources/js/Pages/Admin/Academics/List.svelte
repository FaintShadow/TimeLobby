<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import { page, router } from "@inertiajs/svelte";
    import PaginateLayout from "@/Components/Paginate.svelte";
    import autoAnimate from "@formkit/auto-animate";
    import { debounce } from 'lodash-es';

    // Vars
    export let success, academics;

    $: {
        console.log(academics)
    }

    let innerWidth;
    let innerHeight;
    let values = [];
    let isSearching = false;
    let searchErrors = {};

    // Reactive variables
    $: selected = [];
    $: institutes = [];
    $: searchQueries = {};

    // Initialize values based on academics data
    $: {
        values = academics.data.map(item => item.id);
    }

    // Toggle all selections
    function toggleAll(e) {
        selected = e.target.checked ? [...values] : [];
    }

    // Bulk delete selected academics
    function removeSelected() {
        if (selected.length === 0) {
            // Show a toast or alert for no selection
            return;
        }

        if (confirm(`Are you sure you want to remove ${selected.length} selected items?`)) {
            router.delete('academics/bulkdelete', {
                data: { ids: selected },
                preserveScroll: true,
                onSuccess: () => {
                    selected = [];
                },
                onError: (errors) => {
                    // Handle potential errors
                    console.error('Bulk delete errors:', errors);
                }
            });
        }
    }

    // Edit first selected academic
    function editSelected() {
        if (selected.length !== 1) {
            // Show a toast or alert for invalid selection
            return;
        }
        router.get(`academics/edit/${selected[0]}`);
    }

    // Pagination handler
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

    // Debounced institute search with improved error handling
    const instituteSearch = debounce(async (academic) => {
        const query = searchQueries[academic.id];

        // Reset previous state and errors
        searchErrors[academic.id] = null;
        institutes = [];

        // Validation
        if (!query || query.trim().length < 3) {
            searchErrors[academic.id] = 'Please enter at least 3 characters';
            return;
        }

        try {
            isSearching = true;
            const response = await axios.post('/api/institutes/search', {
                search: query.trim()
            });

            if (response.data.length === 0) {
                searchErrors[academic.id] = 'No institutes found';
            } else {
                institutes = response.data;
            }
        } catch (error) {
            console.error('Search error:', error);
            searchErrors[academic.id] = 'Failed to search institutes. Please try again.';
        } finally {
            isSearching = false;
            searchQueries = {...searchQueries}; // Trigger reactivity
            institutes = [...institutes]; // Trigger reactivity
        }
    }, 500);

    // Handle institute assignment
    function handleAssignment(academic) {
        const selectedInstituteIndex = academic.institute_id;

        if (!institutes[selectedInstituteIndex]) {
            // Show error that no institute is selected
            return;
        }

        const form = {
            id: academic.id,
            institute_id: institutes[selectedInstituteIndex].id
        };

        router.put(`/admin/academics/assign/${academic.id}`, form, {
            preserveScroll: true,
            onSuccess: () => {
                // Reset search state after successful assignment
                searchQueries[academic.id] = null;
                institutes = [];
            },
            onError: (errors) => {
                console.error('Assignment errors:', errors);
                // Optionally show error toast
            }
        });
    }
</script>

<svelte:window bind:innerWidth bind:innerHeight/>

<AuthenticatedLayout mainClass="max-sm:flex-col-reverse max-sm:flex-1 max-sm:flex" bodyClass="max-sm:flex max-sm:flex-col">
    <div class="w-screen px-4 max-sm: mb-2">
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

    <div id="academics" class="px-4 w-screen my-1 max-sm:flex-col-reverse max-sm:flex" use:autoAnimate>
        <!-- Table Header -->
        <div class="bg-base-200 flex flex-row justify-items-center p-1.5 rounded-md my-1">
            <div class="flex justify-center border-r-2 pr-2 border-base-100">
                <label class="h-0">
                    <input
                        type="checkbox"
                        on:change={toggleAll}
                        checked={selected.length === values.length}
                        class="checkbox"
                    />
                </label>
            </div>
            <div class="text-base-content px-2 sm:min-w-64 max-sm:w-full">Name</div>
            <div class="min-w-24 text-base-content px-2 border-base-100 border-r-2 text-right max-sm:border-r-0">
                Role
            </div>
            {#if innerWidth > 640}
                <div class="w-full text-base-content px-2 border-base-100 sm:inline">Institute</div>
            {/if}
        </div>

        {#if academics.data}
            {#each academics.data as academic}
                <div class="flex flex-row justify-items-center p-1.5 rounded-md my-1">
                    <div class="flex justify-center border-r-2 border-base-200 pr-2">
                        <label class="h-0">
                            <input
                                type="checkbox"
                                bind:group={selected}
                                class="checkbox min-h-fit"
                                name="academics"
                                value="{academic.id}"
                            />
                        </label>
                    </div>

                    <!-- Academic Name -->
                    <div class="px-2 sm:min-w-64 max-sm:w-full content-center">
                        {academic.firstname[0] + '. ' + academic.lastname}
                    </div>

                    <!-- Role Badge -->
                    <div class="min-w-24 px-2 border-r-2 border-base-200 text-right max-sm:border-base-100 max-sm:pr-0² content-center">
                        <div class="badge badge-info text-info-content mx-0">
                            {academic.role?.replace("institute-", "") ?? "none"}
                        </div>
                    </div>

                    {#if innerWidth > 640}
                        <form
                            on:submit|preventDefault={() => handleAssignment(academic)}
                            class="w-full pl-2 gap-2 sm:flex min-w-fit"
                            class:flex={!academic.institute}
                            class:flex-row={!academic.institute}
                            class:flex-justify-center={!academic.institute}
                        >
                            {#if academic.institute}
                                {academic.institute.name}
                            {:else}
                                <details class="dropdown w-full">
                                    <summary
                                        class="select select-sm select-bordered w-full text-left overflow-hidden"
                                    >
                                        {academic.institute_id && institutes[academic.institute_id]
                                            ? institutes[academic.institute_id].name
                                            : "Select an institute"}
                                    </summary>
                                    <ul
                                        class="menu dropdown-content w-full bg-base-100 rounded-box z-[1] p-2 shadow"
                                    >
                                        <li class="inline">
                                            <label class="input input-bordered input-sm w-full flex items-center gap-2 mb-2">
                                                <input
                                                    type="text"
                                                    class="grow w-full"
                                                    placeholder="Search by name"
                                                    bind:value={searchQueries[academic.id]}
                                                    on:input={() => instituteSearch(academic)}
                                                />
                                                {#if isSearching}
                                                    <span class="loading loading-spinner loading-sm"></span>
                                                {:else}
                                                    <span>
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 16 16"
                                                            fill="currentColor"
                                                            class="h-4 w-4 opacity-70"
                                                        >
                                                            <path
                                                                fill-rule="evenodd"
                                                                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                                                clip-rule="evenodd"
                                                            />
                                                        </svg>
                                                    </span>
                                                {/if}
                                            </label>
                                        </li>

                                        {#if searchErrors[academic.id]}
                                            <div class="text-error text-xs p-2">
                                                {searchErrors[academic.id]}
                                            </div>
                                        {/if}

                                        {#if institutes && institutes.length > 0}
                                            <span class="text-xs italic">{institutes.length} results</span>
                                            {#each Object.entries(institutes) as [iid, inst]}
                                                <li>
                                                    <div class="form-control p-0 flex">
                                                        <label class="label cursor-pointer w-full">
                                                            <span>{inst.name}</span>
                                                            <input
                                                                type="radio"
                                                                name="sIF-{academic.id}"
                                                                value="{iid}"
                                                                on:change={(e) => {
                                                                    academic.institute_id = e.target.value;
                                                                }}
                                                                class="radio checked:bg-base-300"
                                                            />
                                                        </label>
                                                    </div>
                                                </li>
                                            {/each}
                                        {:else if searchQueries[academic.id]}
                                            <span class="text-xs italic">0 results</span>
                                        {/if}
                                    </ul>
                                </details>
                                <button
                                    type="submit"
                                    class="btn btn-sm w-fit"
                                    disabled={!academic.institute_id}
                                >
                                    Assign
                                </button>
                            {/if}
                        </form>
                    {/if}
                </div>
            {/each}
        {/if}
        <PaginateLayout links={academics.links} {loadPage}/>
    </div>
</AuthenticatedLayout>
