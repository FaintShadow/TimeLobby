<script>
    export let links;
    export let loadPage; // Accept loadPage function as a prop in the parent component

    $: navigate = {
        previous: links[0],
        next: links[links.length - 1],
    };
</script>

<div>
    <div class="join">
        <!-- Previous Button -->
        <button on:click|preventDefault="{() => loadPage?.(navigate.previous.url)}" class="join-item btn" class:disabled={!navigate.previous.url}>
            «
        </button>

        <!-- First Page Link -->
        <button on:click|preventDefault="{() => loadPage?.(links[1].url)}" class="join-item btn" class:btn-active={links[1].active}>
            {links[1].label}
        </button>

        <!-- Page Links (showing nearby active pages) -->
        {#each links.slice(2, links.length - 2) as link}
            {#if link.active}
                <button on:click|preventDefault="{() => loadPage?.(link.url)}" class="join-item btn" class:btn-active={link.active}>
                    {link.label}
                </button>
            {/if}
        {/each}

        <!-- Last Page Link -->
        <button on:click|preventDefault="{() => loadPage?.(links[links.length - 2].url)}" class="join-item btn" class:btn-active={links[links.length - 2].active}>
            {links[links.length - 2].label}
        </button>

        <!-- Next Button -->
        <button on:click|preventDefault="{() => loadPage?.(navigate.next.url)}" class="join-item btn" class:disabled={!navigate.next.url}>
            »
        </button>
    </div>
</div>
