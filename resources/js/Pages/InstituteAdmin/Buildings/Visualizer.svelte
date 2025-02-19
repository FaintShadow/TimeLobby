<!--
<script>
    import {createSwapy} from "swapy"
    import {onMount} from "svelte"
    import ApplicationLogo from "@/Components/ApplicationLogo.svelte";
    import {inertia} from "@inertiajs/svelte";

    export let buildings
    let building_container
    let innerWidth
    let innerHeight

    // Separate sizes for columns and rows
    let cols = 4
    let rows = 4

    // Calculate total grid cells
    $: totalCells = cols * rows
    $: gridCells = Array.from({ length: totalCells }, (_, i) => i + 1)

    onMount(() => {
        if (building_container) {
            const swapy = createSwapy(building_container)
        }
    })
</script>

<svelte:window bind:innerWidth bind:innerHeight/>

<div class="w-screen h-screen relative" bind:this={building_container}>
    &lt;!&ndash; Left sidebar &ndash;&gt;
    <div class="min-w-48 min-h-screen flex flex-col justify-center items-center fixed z-10">
        <a class="btn btn-active text-md absolute top-0 left-0 m-4" href="/" use:inertia>
            <ApplicationLogo class="h-6 w-6"></ApplicationLogo>
            <span>TimeLobby</span>
        </a>
        <div class="w-full bg-base-200 rounded-tr rounded-br flex gap-2 flex-col p-4">
            {#each Object.entries(buildings) as [id, build]}
                <div data-swapy-slot="slot-{id}">
                    <div class="p-2 rounded text-center border-2 border-base-200 bg-primary text-primary-content"
                         data-swapy-item="{build.id}"
                         draggable="true">
                        {build.name}
                    </div>
                </div>
            {/each}
        </div>
    </div>

    &lt;!&ndash; Grid layout &ndash;&gt;
    <div class="ml-48 h-full grid"
         style="grid-template-columns: repeat({cols}, 1fr); grid-template-rows: repeat({rows}, 1fr); gap: 0.5rem;">
        {#each gridCells as cell}
            <div class="bg-base-200 rounded-lg flex items-center justify-center min-h-20"
                 data-swapy-slot="grid-{cell}">
                &lt;!&ndash; Empty grid cell for dropping &ndash;&gt;
                <div class="w-full h-full flex items-center justify-center text-base-content/50">
                    {cell}
                </div>
            </div>
        {/each}
    </div>
</div>

<div class="fixed bottom-4 right-4 flex gap-2">
    <div class="flex flex-col gap-2">
        <label class="label">Columns</label>
        <input type="range" min="2" max="8" class="range range-primary range-sm" bind:value={cols}>
        <span class="text-center">{cols}</span>
    </div>
    <div class="flex flex-col gap-2">
        <label class="label">Rows</label>
        <input type="range" min="2" max="8" class="range range-primary range-sm" bind:value={rows}>
        <span class="text-center">{rows}</span>
    </div>
</div>
-->

<script>
    import {createSwapy} from "swapy"
    import {onMount} from "svelte"
    import ApplicationLogo from "@/Components/ApplicationLogo.svelte";
    import {inertia} from "@inertiajs/svelte";

    export let buildings
    let building_container
    let innerWidth
    let innerHeight

    // Separate sizes for columns and rows
    $: cols = 5
    $: rows = 4

    // Calculate total grid cells
    $: totalCells = cols * rows
    $: gridCells = Array.from({length: totalCells}, (_, i) => i + 1)

    onMount(() => {
        if (building_container) {
            const s1 = createSwapy(building_container, {
                animation: 'dynamic'
            })
        }
    })
</script>

<svelte:window bind:innerWidth bind:innerHeight/>
<svelte:head>
    <title>TL : Buildings UI</title>
</svelte:head>

<div class="w-screen h-screen flex flex-row gap-2" bind:this={building_container}>
    <!-- Sidebar -->
    <div class="min-w-48 min-h-screen flex flex-col justify-center items-center p-2">
        <a class="btn text w-full" href="/" use:inertia>
            <ApplicationLogo class="h-6 w-6"></ApplicationLogo>
            <span>TimeLobby</span>
        </a>

        <div class="w-full bg-base-200 rounded-lg m-auto flex gap-2 flex-col p-1">
            {#each Object.entries(buildings) as [id, build]}
                <div data-swapy-slot="side-{id}" class="w-full h-12 bg-base-300 rounded-lg">
                    <div
                        class="w-full h-full rounded flex justify-center items-center border-2 border-base-200 bg-base-100 text-base-content hover:z-30"
                        data-swapy-item="side-slot-{id}"
                    >
                        {build.name}
                    </div>
                </div>
            {/each}
        </div>

        <div class="bottom-4 left-4 flex flex-col w-full">
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Columns</span>
                    <span class="label-text-alt">{cols}</span>
                </div>
                <input type="range" min="2" max="8" class="range range-primary range-xs" bind:value={cols}>
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Rows</span>
                    <span class="label-text-alt">{rows}</span>
                </div>
                <input type="range" min="2" max="8" class="range range-primary range-xs" bind:value={rows}>
            </label>
        </div>
    </div>

    <!-- Grid container -->
    <div
        class="h-full w-full grid gap-1 z-0"
        style="grid-template-columns: repeat({cols}, 1fr); grid-template-rows: repeat({rows}, 1fr);"
    >
        {#each gridCells as cell}
            <div
                class="flex items-center justify-center border-2 border-base-200 bg-base-300 border-dashed rounded-lg relative">
                <!-- Cell number -->
                <span class="opacity-50 z-0">{cell}</span>
                <!-- Drop zone -->
                <div
                    class="h-full w-full absolute"
                    data-swapy-slot="grid-{cell}"
                >
                    <!-- Draggable item container - should be above the grid but below the sidebar -->
                    <div
                        data-swapy-item="grid-slot-{cell}"
                    ></div>
                </div>
            </div>
        {/each}
    </div>
</div>
