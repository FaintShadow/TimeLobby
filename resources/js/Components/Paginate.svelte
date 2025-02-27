<script>
    export let links;
    export let loadPage;

    $: totalPages = links.length > 3
        ? parseInt(links[links.length - 2].label)
        : 1;

    $: currentPage = links.find(link => link.active)?.label || "1";

    $: navigate = {
        previous: links[0],
        next: links[links.length - 1],
        first: links[1],
        last: links[links.length - 2] || links[1],
        current: links.find(link => link.active && link.label !== "1" && link.label !== totalPages.toString())
    };

    $: showCurrentPageButton = currentPage !== "1" && currentPage !== totalPages.toString();
</script>

{#if totalPages > 1}
    <div>
        <div class="join">
            <!-- Previous Button -->
            <button
                on:click|preventDefault={() => loadPage?.(navigate.previous.url)}
                class="join-item btn"
                class:disabled={!navigate.previous.url}
                aria-label="Previous page"
            >
                «
            </button>

            <!-- First Page (1) -->
            <button
                on:click|preventDefault={() => loadPage?.(navigate.first.url)}
                class="join-item btn"
                class:btn-active={navigate.first.active}
                aria-label="Page 1"
            >
                1
            </button>

            <!-- Current Page (if different from first and last) -->
            {#if showCurrentPageButton}
                <button
                    on:click|preventDefault={() => loadPage?.(navigate.current.url)}
                    class="join-item btn btn-active"
                    aria-label="Current page {navigate.current.label}"
                >
                    {navigate.current.label}
                </button>
            {/if}

            <!-- Last Page (if different from first) -->
            {#if totalPages > 1}
                <button
                    on:click|preventDefault={() => loadPage?.(navigate.last.url)}
                    class="join-item btn"
                    class:btn-active={navigate.last.active}
                    aria-label="Last page {navigate.last.label}"
                >
                    {navigate.last.label}
                </button>
            {/if}

            <!-- Next Button -->
            <button
                on:click|preventDefault={() => loadPage?.(navigate.next.url)}
                class="join-item btn"
                class:disabled={!navigate.next.url}
                aria-label="Next page"
            >
                »
            </button>
        </div>
    </div>
{/if}
