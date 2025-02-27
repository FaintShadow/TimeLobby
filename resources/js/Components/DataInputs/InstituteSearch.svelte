<script>
    import { debounce } from 'lodash-es';

    // Props
    export let onSelect = () => {};
    export let onAssign = () => {};
    export let selectedId = null;
    export let disabled = false;
    export let placeholder = "Select an institute";

    // Internal state
    let searchQuery = "";
    let isSearching = false;
    let searchError = null;
    let institutes = [];

    // Debounced search function
    const handleSearch = debounce(async () => {
        // Reset state
        searchError = null;
        institutes = [];

        // Validation
        if (!searchQuery || searchQuery.trim().length < 3) {
            searchError = 'Please enter at least 3 characters';
            return;
        }

        try {
            isSearching = true;
            const response = await axios.post('/api/institutes/search', {
                search: searchQuery.trim()
            });

            if (response.data.length === 0) {
                searchError = 'No institutes found';
            } else {
                institutes = response.data;
            }
        } catch (error) {
            console.error('Search error:', error);
            searchError = 'Failed to search institutes. Please try again.';
        } finally {
            isSearching = false;
        }
    }, 500);

    $: if (searchQuery) handleSearch();
</script>

<form on:submit|preventDefault={() => onAssign(selectedId)} class="w-full gap-2 flex flex-row">
    <details class="dropdown w-full">
        <summary class="select select-sm select-bordered w-full text-left overflow-hidden">
            {selectedId && institutes.find(i => i.id === selectedId)
                ? institutes.find(i => i.id === selectedId).name
                : placeholder}
        </summary>
        <ul class="menu dropdown-content w-full bg-base-100 rounded-box z-[1] p-2 shadow">
            <li class="inline">
                <label class="input input-bordered input-sm w-full flex items-center gap-2 mb-2">
                    <input
                        type="text"
                        class="grow w-full"
                        placeholder="Search by name"
                        bind:value={searchQuery}
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

            {#if searchError}
                <div class="text-error text-xs p-2">
                    {searchError}
                </div>
            {/if}

            {#if institutes && institutes.length > 0}
                <span class="text-xs italic">{institutes.length} results</span>
                {#each institutes as institute}
                    <li>
                        <div class="form-control p-0 flex">
                            <label class="label cursor-pointer w-full">
                                <span>{institute.name}</span>
                                <input
                                    type="radio"
                                    name="institute-select"
                                    value={institute.id}
                                    on:change={() => onSelect(institute)}
                                    class="radio checked:bg-base-300"
                                />
                            </label>
                        </div>
                    </li>
                {/each}
            {:else if searchQuery}
                <span class="text-xs italic">0 results</span>
            {/if}
        </ul>
    </details>
    <button
        type="submit"
        class="btn btn-sm w-fit"
        {disabled}
    >
        Assign
    </button>
</form>
