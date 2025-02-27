<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import autoAnimate from "@formkit/auto-animate";
    import {router, useForm} from "@inertiajs/svelte";

    // Vars
    export let errors, success
    let isSearching = false
    let searchTimeout

    let form = useForm({
        name: null,
        academic_year: null,
        maxCapacity: null,
        minCapacity: null,
        main_group_id: null,
        year_id: null,
        groupType: null,
    })

    // Reactive
    $: searchGroups = []
    $: searchYears = []
    $: selectedgroup = null;
    $: selectedyear = null;

    // Functions
    $: {
        if (form.main_group_id) {
            selectedgroup = searchGroups.find(b => b.id === form.main_group_id);
        }

        if (form.year_id) {
            selectedyear = searchYears.find(b => b.id === form.year_id);
        }
    }

    function handleSubmit() {
        try {
            router.post('/institute/admin/groups/store', form)
        } catch (e) {
            console.log('Submit error, please try again')
        }
    }

    async function groupSearch(query) {
        console.log(query)
        if (!query || query === null || query.replace(/\s/g, '').length === 0) {
            searchGroups = []
            form.main_group_id = null
            return;
        }

        try {
            isSearching = true;
            const {data} = await axios.post('/api/groups/search', {
                search: query
            })
            if (data.length === 0) {
                searchGroups = []
            } else {
                searchGroups = data
            }
        } catch (error) {
            console.error('Search error:', error);
            searchGroups = []
        } finally {
            isSearching = false
        }
    }

    async function yearSearch(query) {
        console.log(query)
        if (!query || query === null || query.replace(/\s/g, '').length === 0) {
            searchYears = []
            form.year_id = null
            return;
        }

        try {
            isSearching = true;
            const {data} = await axios.post('/api/years/search', {
                search: query
            })
            if (data.length === 0) {
                searchYears = []
            } else {
                searchYears = data
            }
        } catch (error) {
            console.error('Search error:', error);
            searchYears = []
        } finally {
            isSearching = false
        }
    }

    function handleGroupSearchInput(event) {
        clearTimeout(searchTimeout)
        searchTimeout = setTimeout(() => {
            groupSearch(event.target.value)
        }, 300);
    }

    function handleYearSearchInput(event) {
        clearTimeout(searchTimeout)
        searchTimeout = setTimeout(() => {
            yearSearch(event.target.value)
        }, 300);
    }
</script>

<AuthenticatedLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control w-full max-w-md mx-auto gap-0.5" use:autoAnimate>
        <label class="form-control">
            <div class="label">
                <span class="label-text">Name:</span>
            </div>
            <input
                id="name"
                type="text"
                class="input input-sm input-bordered"
                class:input-error={errors.name}
                bind:value={form.name}
                required
            />
            {#if (errors.name)}
                <div class="label">
                    <span class="label-text-alt text-red-600">{errors.name}</span>
                </div>
            {/if}
        </label>

        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Year:</span>
            </div>
            <div>
                <details class="dropdown w-full">
                    <summary
                        class="select select-sm select-bordered w-full text-left overflow-hidden"
                        class:select-error={errors.year_id}
                    >
                        { selectedyear ? selectedyear.name : "Search for a year" }
                    </summary>
                    <ul class="menu dropdown-content w-full bg-base-100 rounded-box z-[1] p-2 shadow">
                        <li class="inline">
                            <label
                                class="input input-bordered input-sm w-full flex items-center gap-2 mb-2">
                                <input
                                    type="text"
                                    class="grow w-full"
                                    placeholder="Search by name"
                                    on:input={handleYearSearchInput}
                                />
                                {#if isSearching}
                                    <span class="loading loading-spinner loading-sm"></span>
                                {:else}
                                        <span>
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
                                        </span>
                                {/if}
                            </label>
                        </li>
                        {#if searchYears.length > 0}
                            <span class="text-xs italic">{searchYears.length} results</span>
                            {#each searchYears as year}
                                <li>
                                    <div class="form-control p-0 flex">
                                        <label class="label cursor-pointer w-full">
                                            <span>{year.name}</span>
                                            <input
                                                type="radio"
                                                name="group"
                                                on:change={() => form.year_id = year.id}
                                                class="radio"/>
                                        </label>
                                    </div>
                                </li>
                            {/each}
                        {:else}
                            <span class="text-xs italic">0 results</span>
                        {/if}
                    </ul>
                </details>
            </div>
            <div class="label">
                {#if (errors.year_id)}
                    <span class="label-text-alt text-red-600">{errors.year_id}</span>
                {/if}
                <span class="label-text-alt"></span>
            </div>
        </label>

        <label class="form-control">
            <div class="label">
                <span class="label-text">Academic Year:</span>
            </div>
            <input
                id="name"
                type="number"
                maxlength="4"
                placeholder="e.g: 2001"
                autocomplete="off"
                class="input input-sm input-bordered"
                class:input-error={errors.academic_year}
                bind:value={form.academic_year}
                required
            />
            {#if (errors.academic_year)}
                <div class="label">
                    <span class="label-text-alt text-red-600">{errors.academic_year}</span>
                </div>
            {/if}
        </label>

        <label class="form-control">
            <div class="label">
                <span class="label-text">Type:</span>
            </div>
            <div class="flex flex-row gap-2">
                <div class="form-control w-full">
                    <label
                        class="label cursor-pointer btn btn-primary justify-center"
                        class:btn-neutral={form.groupType !== "group"}
                    >
                        <span class="text">Group</span>
                        <input
                            type="radio"
                            name="type"
                            class="radio hidden"
                            on:change={() => {
                                form.groupType = "group"
                                form.main_group_id = null
                                errors.main_group_id = null
                            }}/>
                    </label>
                </div>

                <div class="form-control w-full">
                    <label
                        class="label cursor-pointer btn btn-primary justify-center"
                        class:btn-neutral={form.groupType !== "subgroup"}
                    >
                        <span class="text">Subgroup</span>
                        <input
                            type="radio"
                            name="type"
                            class="radio hidden"
                            on:change={() => {
                                form.groupType = "subgroup"
                                form.main_group_id = null
                                errors.main_group_id = null
                            }}/>
                    </label>
                </div>
            </div>
        </label>

        {#if form.groupType === "subgroup"}
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Groups:</span>
                </div>
                <div>
                    <details class="dropdown w-full">
                        <summary
                            class="select select-sm select-bordered w-full text-left overflow-hidden"
                            class:select-error={errors.main_group_id}
                        >
                            { selectedgroup ? selectedgroup.name : "Search for a group" }
                        </summary>
                        <ul class="menu dropdown-content w-full bg-base-100 rounded-box z-[1] p-2 shadow">
                            <li class="inline">
                                <label
                                    class="input input-bordered input-sm w-full flex items-center gap-2 mb-2">
                                    <input
                                        type="text"
                                        class="grow w-full"
                                        placeholder="Search by name"
                                        on:input={handleGroupSearchInput}
                                    />
                                    {#if isSearching}
                                        <span class="loading loading-spinner loading-sm"></span>
                                    {:else}
                                        <span>
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
                                        </span>
                                    {/if}
                                </label>
                            </li>
                            {#if searchGroups.length > 0}
                                <span class="text-xs italic my-1">{searchGroups.length} results</span>
                                {#each searchGroups as group}
                                    <li>
                                        <div class="form-control p-0 flex">
                                            <label class="label cursor-pointer w-full">
                                                <span>{group.year.name} : {group.name}</span>
                                                <input
                                                    type="radio"
                                                    name="group"
                                                    on:change={() => form.main_group_id = group.id}
                                                    class="radio"/>
                                            </label>
                                        </div>
                                    </li>
                                {/each}
                            {:else}
                                <span class="text-xs italic my-1">0 results</span>
                            {/if}
                        </ul>
                    </details>
                </div>
                {#if (errors.main_group_id)}
                    <div class="label">
                        <span class="label-text-alt text-red-600">{errors.main_group_id}</span>
                    </div>
                {/if}
            </label>
        {/if}

        <div class="flex flex-row gap-2">

            <label class="form-control flex-1">
                <div class="label">
                    <span class="label-text">Min capacity:</span>
                </div>
                <input
                    type="number"
                    class="input input-sm input-bordered"
                    placeholder="Default: 1"
                    min=1
                    max={form.maxCapacity - 1}
                    class:input-error={errors.minCapacity}
                    bind:value={form.minCapacity}
                />
                {#if (errors.minCapacity)}
                    <div class="label">
                        <span class="label-text-alt text-red-600">{errors.minCapacity}</span>
                    </div>
                {/if}
            </label>

            <label class="form-control flex-1">
                <div class="label">
                    <span class="label-text">Max capacity:</span>
                </div>
                <input
                    type="number"
                    class="input input-sm input-bordered"
                    placeholder="Default: 30"
                    min={form.minCapacity}
                    class:input-error={errors.maxCapacity}
                    bind:value={form.maxCapacity}
                />
                {#if (errors.maxCapacity)}
                    <div class="label">
                        <span class="label-text-alt text-red-600">{errors.maxCapacity}</span>
                    </div>
                {/if}
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button
                class="btn btn-sm ml-4"
                class:btn-primary={form.groupType}
                disabled={form["processing"] || form.groupType == null}
            >
                Add {form.groupType ? form.groupType : '?'}
            </button>
        </div>
    </form>
</AuthenticatedLayout>
