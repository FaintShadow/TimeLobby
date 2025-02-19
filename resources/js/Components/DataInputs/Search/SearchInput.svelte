<script lang="ts">
    import { fade } from 'svelte/transition';
    import type { ActionButton } from './SearchTypes';

    // Props
    export let onSearch: (query: string) => Promise<any[]>
    export let displayFormat: (item: any) => string
    export let multiSelect = false
    export let externalError = false
    export let debounceTime = 300;
    export let placeholder = "Search..."
    export let id
    export let initialText: string | undefined = undefined
    export let minSearchLength = 2
    export let actionButton: ActionButton | undefined = undefined
    export let errorMessages = {
        searchFailed: "Search failed. Please try again.",
        minimumLength: "Please enter at least {n} characters",
        noResults: "No results found"
    }

    // Internal state
    let searchResults: any[] = []
    let selectedItems: any[] = []
    let isSearching = false
    let searchError: string | null = null
    let searchTimeout: NodeJS.Timeout
    let searchInput: string = ""
    let dropdownOpen = false

    // Reactive statements
    $: isActionButtonVisible = actionButton && (
        actionButton.showCondition === 'always' ||
        (actionButton.showCondition === 'hasSelection' && selectedItems.length > 0) ||
        (actionButton.showCondition === 'hasResults' && searchResults.length > 0) ||
        (typeof actionButton.showCondition === 'function' &&
            actionButton.showCondition(searchResults, selectedItems))
    )

    // Functions
    async function handleSearch(query: string) {
        if (!query || query.trim().length < minSearchLength) {
            searchError = errorMessages.minimumLength.replace('{n}', minSearchLength.toString())
            searchResults = []
            return
        }

        try {
            isSearching = true
            searchError = null
            const results = await onSearch(query.trim())
            searchResults = results

            if (results.length === 0) {
                searchError = errorMessages.noResults
            }
        } catch (error) {
            searchError = errorMessages.searchFailed
            searchResults = []
        } finally {
            isSearching = false
        }
    }

    function handleSearchInput(event: Event) {
        const input = (event.target as HTMLInputElement).value
        searchInput = input

        clearTimeout(searchTimeout)
        searchTimeout = setTimeout(() => {
            handleSearch(input)
        }, debounceTime)
    }

    function handleSelection(item: any) {
        if (multiSelect) {
            const index = selectedItems.findIndex(i => i.id === item.id)
            if (index === -1) {
                selectedItems = [...selectedItems, item]
            } else {
                selectedItems = selectedItems.filter(i => i.id !== item.id)
            }
        } else {
            selectedItems = [item]
            dropdownOpen = false
        }
        initialText = undefined
        dispatch('selectionChange', selectedItems)
    }

    function handleActionClick() {
        if (actionButton?.onAction) {
            actionButton.onAction(selectedItems)
        }
    }

    function isItemSelected(item: any): boolean {
        return selectedItems.some(i => i.id === item.id)
    }

    // Event dispatcher
    import { createEventDispatcher } from 'svelte'
    const dispatch = createEventDispatcher()
</script>

<div class="search-component w-full">
    <div class="relative">
        <details
            class="dropdown w-full"
            bind:open={dropdownOpen}
        >
            <summary
                class="select select-sm select-bordered w-full text-left flex items-center justify-between"
                class:select-error={!initialText && (!!searchError || externalError)}
            >
                <span class="truncate">
                    {selectedItems.length > 0
                        ? selectedItems.map(item => item.name).join(', ')
                        : initialText ?? placeholder}
                </span>
                {#if actionButton && isActionButtonVisible}
                    <button
                        class="btn btn-sm btn-ghost"
                        disabled={isSearching}
                        on:click|stopPropagation={handleActionClick}
                    >
                        {#if actionButton.icon}
                            <span class="mr-2">{actionButton.icon}</span>
                        {/if}
                        {actionButton.text || ''}
                    </button>
                {/if}
            </summary>

            <div
                class="dropdown-content menu w-full bg-base-100 rounded-box shadow-lg z-[1]"
                transition:fade
            >
                <div class="p-2">
                    <label class="input input-bordered flex items-center gap-2">
                        <input
                            {id}
                            type="text"
                            class="grow"
                            {placeholder}
                            bind:value={searchInput}
                            on:input={handleSearchInput}
                            autocomplete="off"
                        />
                        {#if isSearching}
                            <span class="loading loading-spinner loading-sm"></span>
                        {:else}
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 16 16"
                                fill="currentColor"
                                class="w-4 h-4 opacity-70"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        {/if}
                    </label>

                    {#if searchError}
                        <div class="text-error text-sm mt-2" transition:fade>
                            {searchError}
                        </div>
                    {/if}

                    {#if searchResults.length > 0}
                        <div class="mt-2">
                            <span class="text-xs opacity-70">{searchResults.length} results</span>
                            <ul class="menu menu-sm">
                                {#each searchResults as item (item.id)}
                                    <li>
                                        <label
                                            class="flex justify-between cursor-pointer"
                                        >
                                            <span>{@html displayFormat ? displayFormat(item) : item.name}</span>
                                            <input
                                                type={multiSelect ? "checkbox" : "radio"}
                                                checked={isItemSelected(item)}
                                                class={multiSelect ? "checkbox checkbox-sm" : "radio radio-sm"}
                                                autocomplete="off"
                                                on:change={() => handleSelection(item)}
                                            />
                                        </label>
                                    </li>
                                {/each}
                            </ul>
                        </div>
                    {/if}
                </div>
            </div>
        </details>
    </div>
</div>
