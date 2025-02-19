<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import autoAnimate from "@formkit/auto-animate";
    import SearchInput from "@/Components/DataInputs/Search/SearchInput.svelte";
    import InputLabel from "@/Components/DataInputs/Input/InputLabel.svelte";
    import Input from "@/Components/DataInputs/Input/Input.svelte";
    import {LabelTextConsts} from "@/Components/DataInputs/Input/LabelType";
    import {router, useForm} from "@inertiajs/svelte";

    // Vars
    export let errors, buildingMinCap, classroomMinCap

    let form = useForm({
        name: null,
        maxCapacity: null,
        building_id: null,
        type: null
    })

    // Labels:
    $: buildingTL = {
        left: {
            text: 'Building:',
        },
        right: {
            type: LabelTextConsts.BADGE,
            styling: "badge-error text-error-content",
            text: "REQUIRED"
        }
    }

    $: buildingBL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.building_id
        },
        show: errors.building_id ?? false
    }

    const maxCapTL = {
        left: {
            text: 'Maximum Capacity:'
        }
    }

    $: maxCapBL = {
        left: {
            styling: 'text-error',
            text: errors.maxCapacity,
        },
        show: errors.maxCapacity ?? false
    }

    $: nameTL = {
        left: {
            text: "Name:",
        },
        right: {
            type: LabelTextConsts.BADGE,
            styling: "badge-error text-error-content",
            text: "REQUIRED"
        }
    }

    $: nameBL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.name
        },
        show: errors.name ?? false
    }

    // Functions

    function handleSubmit() {
        try {
            router.post('/institute/admin/buildings/store', form)
        } catch (e) {
            console.log('Submit error, please try again')
        }
    }

    async function handleBuildingSearch(query) {
        try {
            const response = await axios.post('/api/buildings/search', {
                search: query.trim(),
                type: "building"
            });
            return response.data;
        } catch (error) {
            console.error('Search error:', error);
            throw error;
        }
    }

    function handleBuildingSelectionChange(event) {
        const [selected] = event.detail;

        if (selected) {
            form.building_id = selected.id
        }
    }
</script>

<svelte:head>
    <title>TL : Add Building</title>
</svelte:head>

<AuthenticatedLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control w-full max-w-md mx-auto gap-0.5" use:autoAnimate>
        <Input
            topLabel={nameTL}
            bottomLabel={nameBL}
            placeholder="e.g: Labs"
            bind:value={form.name}
        />

        <label class="form-control">
            <InputLabel
                label={{
                    left: {
                        text: "Type:"
                    }
                }}
            />
            <div class="flex flex-row gap-2">
                <!--CLASSROOM-->
                <div class="form-control w-full">
                    <label
                        class="label cursor-pointer btn justify-center"
                        class:btn-neutral={form.type !== "classroom"}
                        class:btn-primary={form.type === "classroom"}
                    >
                        <span class="text">Classroom</span>
                        <input
                            type="radio"
                            value="classroom"
                            name="type"
                            class="radio hidden"
                            on:change={(e) => {
                                form.type = e.target.value
                                form.building_id = null
                                errors.building_id = null
                                errors.maxCapacity = null
                            }}/>
                    </label>
                </div>

                <!--BUILDING-->
                <div class="form-control w-full">
                    <label
                        class="label cursor-pointer btn justify-center"
                        class:btn-neutral={form.type !== "building"}
                        class:btn-primary={form.type === "building"}

                    >
                        <span class="text">Building</span>
                        <input
                            type="radio"
                            value="building"
                            name="type"
                            class="radio hidden"
                            on:change={(e) => {
                                form.type = e.target.value
                                form.building_id = null
                                errors.building_id = null
                                errors.maxCapacity = null
                            }}/>
                    </label>
                </div>
            </div>
        </label>

        {#if form.type === "classroom"}
            <label for="building_search" class="form-control w-full">
                <InputLabel
                    label={buildingTL}
                />
                <SearchInput
                    id="building_search"
                    onSearch={handleBuildingSearch}
                    externalError={errors.building_id ?? null}
                    placeholder="Search for building..."
                    minSearchLength={3}
                    debounceTime={500}
                    errorMessages={{
                        searchFailed: "Failed to search buildings. Please try again.",
                        minimumLength: "Please enter at least 3 characters",
                        noResults: "No buildings found"
                    }}
                    on:selectionChange={handleBuildingSelectionChange}
                />
                <InputLabel
                    label={buildingBL}
                />
            </label>
        {/if}

        <Input
            topLabel={maxCapTL}
            bottomLabel={maxCapBL}
            type="number"
            placeholder="Default: 30 | Minimum: {form.type === 'classroom' ? classroomMinCap : form.type !== null ? buildingMinCap : '?'}"
            min={form.type === "classroom" ? classroomMinCap : buildingMinCap}
            bind:value={form.maxCapacity}
        />

        <div class="flex items-center justify-end mt-4">
            <button disabled={form["processing"] || form.type == null} class="btn btn-sm btn-neutral ml-4">
                Add {form.type ? form.type : '?'}
            </button>
        </div>
    </form>
</AuthenticatedLayout>
