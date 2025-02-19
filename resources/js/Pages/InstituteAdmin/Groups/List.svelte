<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte"
    import autoAnimate from "@formkit/auto-animate"
    import {router, useForm, page} from "@inertiajs/svelte"
    import {fade} from "svelte/transition"
    import Input from "@/Components/DataInputs/Input/Input.svelte";
    import {LabelTextConsts} from "@/Components/DataInputs/Input/LabelType";

    export let errors, success, years, links
    let tabHovered = false

    console.log(links)

    let newYear = useForm({
        name: null,
    });

    let tabState = {
        selectedId: years?.[0]?.id ?? null,
        isEditing: false,
        isDeleting: false
    }

    $: {
        console.log(tabState.selectedId)
    }

    const year_TL = {
        left: {
            text: 'Name:'
        }
    }

    $: year_BL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.name,
        },
        show: errors.name ?? false
    }

    $: selectedYear = years?.find(y => y.id === tabState.selectedId)
    const handleTabSelect = (yearId) => tabState.selectedId = yearId
    const handleEditHover = (hovering) => tabState.isEditing = hovering
    const handleDeleteHover = (hovering) => tabState.isDeleting = hovering
    function handleYearSubmit() {
        router.post(links['years.store'], newYear, {
            onSuccess: () => {
                newYear.name = null;
            },
            onError: (errors) => console.error('Adding Year Error:', errors)
        });
    }

    function getSelectedGroups(year) {
        return year.groups.filter(g => g.selected === true).map(item => item.id)
    }

    function resetSelectedGroups(year) {
        for (const group of year.groups) {
            group.selected = false
        }
    }

    function editSelected(year) {
        if (getSelectedGroups(year).length !== 1) return
        console.log(getSelectedGroups(year))
        console.log(links['groups.edit'].replace('replace-me', getSelectedGroups(year)[0]))
        router.get(links['groups.edit'].replace('replace-me', getSelectedGroups(year)[0]))
    }

    function removeSelected(year) {
        if (getSelectedGroups(year).length === 0) return

        if (confirm(`Are you sure you want to remove ${getSelectedGroups(year).length} selected groups?`)) {
            router.delete(links['groups.bulk-delete'],
                {
                    data: {
                        ids: getSelectedGroups(year)
                    },
                    preserveScroll: true,
                    onSuccess: () => {
                        resetSelectedGroups(year)
                    },
                });
        }
    }

    function handleYearDelete(year) {
        if (confirm(`Are you sure you want to delete "${year.name}"?`)) {
            const yearIndex = years.findIndex(y => y.id === year.id)
            const index = years.length > 1 ? yearIndex > 0 ? yearIndex - 1 : yearIndex + 1 : -1
            console.log(index, yearIndex)
            tabState.selectedId = years[index]?.id ?? index
            router.delete(links['years.delete'].replace('replace-me', year.id),
                {
                    preserveScroll: true,
                    onSuccess: () => {tabState.selectedId = years[yearIndex > index ? index : index - 1]?.id ?? index},
                    onError: (errors) => console.error('Deleting Year Error:', errors)
                }
            )
        }
    }

</script>

<svelte:head>
    <title>TL: Groups</title>
</svelte:head>

<AuthenticatedLayout mainClass="mx-4">
    <div role="tablist" class="tabs tabs-boxed rounded-bl-none tabs-lg" use:autoAnimate>
        {#if years?.length > 0}
            {#each years as year (year.id)}
                <input
                    type="radio"
                    name="years"
                    role="tab"
                    class="tab"
                    aria-label="{year.name}"
                    checked={year.id === tabState.selectedId}

                    on:mouseenter={() => tabHovered = true}
                    on:mouseleave={() => tabHovered = false}
                    on:click={() => handleTabSelect(year.id)}

                    class:tab-transition={!tabHovered}
                    class:tab-error={tabState.isDeleting && selectedYear === year}
                    class:tab-accent={tabState.isEditing && selectedYear === year}
                />
                <div
                    role="tabpanel"
                    class="tab-content border-base-300 rounded pt-4 px-4"
                    class:gap-2={year.groups?.length}
                    class:bg-base-300={year.id === tabState.selectedId}
                >
                    <div class="flex flex-col">

                        {#if year.groups.length > 0}
                            {#each Object.entries(year.groups) as [gid, group]}
                                <div
                                    class="flex flex-row items-center relative"
                                    role="group"
                                    class:mt-2={gid > 0}
                                    on:mouseenter={() => group.hovered = true}
                                    on:mouseleave={() => group.hovered = false}
                                    transition:fade
                                >
                                    {#if group.hovered || group.selected}
                                        <input
                                            type="checkbox"
                                            class="checkbox border-2 bg-base-200 z-10 absolute"
                                            style="transform: translate(50%, 0)"
                                            bind:checked={group.selected}
                                            class:checkbox-primary={group.selected}
                                            transition:fade
                                        />
                                    {/if}
                                    <div
                                        class="collapse border-2 border-base-100 collapse-plus transition-padding"
                                        class:border-primary={group.selected}
                                        class:pl-6={group.hovered || group.selected}
                                    >
                                        <input
                                            type="checkbox"
                                            name="group"
                                        />
                                        <div
                                            class="collapse-title text-xl font-medium flex flex-row items-center gap-2"
                                        >
                                            <span>{group.name}</span>
                                        </div>
                                        <div class="collapse-content">
                                            <div class="max-sm:flex max-sm:flex-col sm:grid sm:grid-cols-4 gap-2">
                                                {#if group.subgroups.length > 0}
                                                    {#each group.subgroups as subgroup}
                                                        <div>
                                                            <span>{subgroup.name}</span>
                                                            <button class="btn btn-sm">
                                                                view
                                                            </button>
                                                            <button class="btn btn-sm btn-error">
                                                                delete
                                                            </button>
                                                        </div>
                                                    {/each}
                                                {:else}
                                                    <span class="text-error italic">No Subgroups Found !</span>
                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {/each}
                        {:else}
                            <span class="text-error italic ml-4">No groups found !</span>
                        {/if}

                        <div class="my-2 pb-2">
                            <a href="{links['groups.add']}" class="btn btn-primary">Add Group</a>
                            <button
                                class="btn bg-base-200"
                                disabled="{getSelectedGroups(year).length <= 0}"
                                on:click={removeSelected(year)}
                            >
                                Remove Selected Group{getSelectedGroups(year).length > 1 ? "s" : ""}
                                ({getSelectedGroups(year).length})
                            </button>
                            <button
                                on:click={editSelected(year)}
                                class="btn bg-base-200"
                                disabled="{getSelectedGroups(year).length !== 1}"
                            >
                                Edit Group
                            </button>
                        </div>

                    </div>

                </div>
            {/each}
        {/if}

        <input
            type="radio"
            name="years"
            role="tab"
            class="tab"
            aria-label="+"

            on:mouseenter={() => tabHovered = true}
            on:mouseleave={() => tabHovered = false}
            on:click={() => handleTabSelect(-1)}
            checked={tabState.selectedId === -1}

        />
        <div
            role="tabpanel"
            class="tab-content border-base-300 rounded p-6"
            class:bg-base-300={tabState.selectedId === -1}
        >
            <form on:submit|preventDefault={handleYearSubmit} class="form-control w-full max-w-md mx-auto gap-2">

                <Input
                    topLabel={year_TL}
                    bottomLabel={year_BL}
                    inputSize="md"
                    placeholder="e.g: 1st year"
                    bind:value={newYear.name}
                />

                <button class="btn btn-primary sm:btn-sm md:btn-md">Add year</button>

            </form>
        </div>
    </div>
    {#if selectedYear && tabState.selectedId !== null}
        <div class="flex">
            <button
                class="btn btn-sm border-top-r-0 btn-error"
                on:click|preventDefault={handleYearDelete(selectedYear)}
                on:mouseenter={() => handleDeleteHover(true)}
                on:mouseleave={() => handleDeleteHover(false)}
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24">
                    <path fill="currentColor"
                          d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2"/>
                </svg>
            </button>
            <button
                class="btn border-top-r-0 btn-sm btn-accent"
                on:click|preventDefault={handleYearEdit(selectedYear)}
                on:mouseenter={() => handleEditHover(true)}
                on:mouseleave={() => handleEditHover(false)}
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24">
                    <path fill="currentColor"
                          d="M20.71 7.04c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.37-.39-1.02-.39-1.41 0l-1.84 1.83l3.75 3.75M3 17.25V21h3.75L17.81 9.93l-3.75-3.75z"/>
                </svg>
            </button>
        </div>
    {/if}

</AuthenticatedLayout>

<style>
    .border-top-r-0 {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .transition-padding {
        transition: padding .2s ease-in .3s;
    }

    .transition-padding:hover {
        transition: padding .2s ease-out;
    }

    .tab-transition {
        transition: background .3s ease-in .2s, color .3s ease-in .2s;
    }

    .tab-error {
        color: oklch(var(--erc)) !important;
        background-color: oklch(var(--er)) !important;
    }

    .tab-accent {
        color: oklch(var(--ac)) !important;
        background-color: oklch(var(--a)) !important;
    }
</style>
