<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import { page, router } from "@inertiajs/svelte";
    import PaginateLayout from "@/Components/Paginate.svelte";
    import autoAnimate from "@formkit/auto-animate";
    import SearchInput from "@/Components/DataInputs/Search/SearchInput.svelte";

    export let success, academics;

    $: {
        console.log(academics)
    }

    let innerWidth;
    let innerHeight;
    let values = [];
    $: selected = [];
    $: values = academics.data.map(item => item.id);

    async function handleInstituteSearch(query) {
        try {
            const response = await axios.post('/api/institutes/search', {
                search: query.trim()
            });
            return response.data;
        } catch (error) {
            console.error('Search error:', error);
            throw error;
        }
    }

    function handleAssignment(academic, selectedInstitutes) {
        if (!selectedInstitutes.length) return;

        const form = {
            id: academic.id,
            institute_id: selectedInstitutes[0].id
        };

        router.put(`/admin/academics/assign/${academic.id}`, form, {
            preserveScroll: true,
            onSuccess: () => academic.institute = selectedInstitutes[0],
            onError: (errors) => console.error('Assignment errors:', errors)
        });
    }

    function removeSelected() {
        if (selected.length === 0) return;
        if (confirm(`Remove ${selected.length} selected items?`)) {
            router.delete('academics/bulkdelete', {
                data: { ids: selected },
                preserveScroll: true,
                onSuccess: () => selected = [],
                onError: (errors) => console.error('Bulk delete errors:', errors)
            });
        }
    }

    function editSelected() {
        if (selected.length !== 1) return;
        router.get(`academics/edit/${selected[0]}`);
    }

    function loadPage(url) {
        if (!url) return;
        router.get(url, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (page) => academics = page.props.academics
        });
    }
</script>

<svelte:window bind:innerWidth bind:innerHeight/>

<AuthenticatedLayout mainClass="max-sm:flex-col-reverse max-sm:flex-1 max-sm:flex" bodyClass="max-sm:flex max-sm:flex-col">
    <div class="w-screen px-4 max-sm:mb-2">
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
        <div class="bg-base-200 flex flex-row justify-items-center p-1.5 rounded-md my-1">
            <div class="flex justify-center border-r-2 pr-2 border-base-100">
                <label class="h-0">
                    <input
                        type="checkbox"
                        on:change={(e) => selected = e.target.checked ? [...values] : []}
                        checked={selected.length === values.length}
                        class="checkbox"
                    />
                </label>
            </div>
            <div class="text-base-content px-2 sm:min-w-64 max-sm:w-full">Name</div>
            <div class="min-w-24 text-base-content px-2 border-base-100 border-r-2 text-right max-sm:border-r-0">Role</div>
            {#if innerWidth > 640}
                <div class="w-full text-base-content px-2 border-base-100 sm:inline">Institute</div>
            {/if}
        </div>

        {#if academics.data}
            {#each academics.data as academic}
                <div class="flex flex-row justify-items-center p-1.5 rounded-md my-1" use:autoAnimate>
                    <div class="flex justify-center border-r-2 border-base-200 pr-2">
                        <label class="h-0">
                            <input
                                type="checkbox"
                                bind:group={selected}
                                class="checkbox min-h-fit"
                                name="academics"
                                value={academic.id}
                            />
                        </label>
                    </div>

                    <div class="px-2 sm:min-w-64 max-sm:w-full content-center">
                        {academic.firstname[0] + '. ' + academic.lastname}
                    </div>

                    <div class="min-w-24 px-2 border-r-2 border-base-200 text-right max-sm:border-base-100 content-center">
                        <div class="badge badge-info text-info-content mx-0">
                            {academic.role?.replace("institute-", "") ?? "none"}
                        </div>
                    </div>

                    {#if innerWidth > 640}
                        <div class="w-full pl-2">
                            {#if !academic.institute}
                                <SearchInput
                                    onSearch={handleInstituteSearch}
                                    placeholder="Search for institute..."
                                    minSearchLength={3}
                                    debounceTime={500}
                                    actionButton={{
                                        text: "Assign",
                                        showCondition: "hasSelection",
                                        onAction: (selectedInstitutes) => handleAssignment(academic, selectedInstitutes)
                                    }}
                                    errorMessages={{
                                        searchFailed: "Failed to search institutes. Please try again.",
                                        minimumLength: "Please enter at least 3 characters",
                                        noResults: "No institutes found"
                                    }}
                                />
                            {:else}
                                {academic.institute.name}
                            {/if}
                        </div>
                    {/if}
                </div>
            {/each}
        {/if}
        <PaginateLayout links={academics.links} {loadPage}/>
    </div>
</AuthenticatedLayout>
