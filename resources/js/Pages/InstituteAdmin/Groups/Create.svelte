<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import autoAnimate from "@formkit/auto-animate";
    import {router, useForm} from "@inertiajs/svelte";
    import Input from "@/Components/DataInputs/Input/Input.svelte"
    import SearchInput from "@/Components/DataInputs/Search/SearchInput.svelte";
    import InputLabel from "@/Components/DataInputs/Input/InputLabel.svelte";
    import {LabelTextConsts} from "@/Components/DataInputs/Input/LabelType";

    // Vars
    export let errors

    let form = useForm({
        name: null,
        academic_year: null,
        maxCapacity: null,
        minCapacity: null,
        main_group_id: null,
        year_id: null,
        groupType: null,
    })

    const nameTL = {
        left: {
            text: 'Name:'
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
            text: errors.name,
        },
        show: errors.name ?? false
    }

    const yearTL = {
        left: {
            text: 'Year:'
        },
        right: {
            type: LabelTextConsts.BADGE,
            styling: "badge-error text-error-content",
            text: "REQUIRED"
        }
    }

    $: yearBL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.year_id,
        },
        show: errors.year_id ?? false
    }

    const groupTL = {
        left: {
            text: 'Group:'
        },
        right: {
            type: LabelTextConsts.BADGE,
            styling: "badge-error text-error-content",
            text: "REQUIRED"
        }
    }

    $: groupBL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.main_group_id,
        },
        show: errors.main_group_id ?? false
    }

    const academicYearTL = {
        left: {
            text: 'Academic Year:'
        },
        right: {
            type: LabelTextConsts.BADGE,
            styling: "badge-error text-error-content",
            text: "REQUIRED"
        }
    }

    $: academicYearBL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.academic_year,
        },
        show: errors.academic_year ?? false
    }

    const typeTL = {
        left: {
            text: 'Type:'
        }
    }

    const minCapTL = {
        left: {
            text: 'Minimum Capacity:'
        }
    }

    const maxCapTL = {
        left: {
            text: 'Maximum Capacity:'
        }
    }

    $: minCapBL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.minCapacity,
        },
        show: errors.minCapacity ?? false
    }

    $: maxCapBL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.maxCapacity,
        },
        show: errors.maxCapacity ?? false
    }

    function handleSubmit() {
        try {
            router.post('/institute/admin/groups/store', form)
        } catch (e) {
            console.log('Submit error, please try again')
        }
    }

    async function handleGroupSearch(query) {
        try {
            const response = await axios.post('/api/groups/search', {
                search: query.trim(),
                type: "group"
            });
            return response.data;
        } catch (error) {
            console.error('Search error:', error);
            throw error;
        }
    }

    function handleGroupSelectionChange(event) {
        const [selected] = event.detail;

        if (selected) {
            form.main_group_id = selected.id
        }
    }

    async function handleYearSearch(query) {
        try {
            const response = await axios.post('/api/years/search', {
                search: query.trim()
            });
            return response.data;
        } catch (error) {
            console.error('Search error:', error);
            throw error;
        }
    }

    function handleYearSelectionChange(event) {
        const [selected] = event.detail;

        if (selected) {
            form.year_id = selected.id
        }
    }
</script>

<svelte:head>
    <title>TL : Add Group</title>
</svelte:head>

<AuthenticatedLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control w-full max-w-md mx-auto gap-0.5" use:autoAnimate>
        <Input
            topLabel={nameTL}
            bottomLabel={nameBL}
            bind:value={form.name}
            required="{true}"
        />

        <Input
            topLabel={academicYearTL}
            bottomLabel={academicYearBL}
            type="number"
            maxlength="4"
            placeholder="e.g: 2025"
            required="{true}"
            bind:value={form.academic_year}
        />

        <label class="form-control">
            <InputLabel label={typeTL}/>
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
            <label for="group_search" class="form-control w-full">
                <InputLabel
                    label={groupTL}
                />
                <SearchInput
                    id="group_search"
                    onSearch={handleGroupSearch}
                    displayFormat={(group) => group.year.name + ' : ' + group.name}
                    externalError={errors?.main_group_id ?? false}
                    placeholder="Search for group..."
                    minSearchLength={3}
                    debounceTime={500}
                    errorMessages={{
                        searchFailed: "Failed to search groups. Please try again.",
                        minimumLength: "Please enter at least 3 characters",
                        noResults: "No groups found"
                    }}
                    on:selectionChange={handleGroupSelectionChange}
                />
                <InputLabel
                    label={groupBL}
                />
            </label>
        {:else if form.groupType === "group"}
            <label for="year_search" class="form-control w-full">
                <InputLabel
                    label={yearTL}
                />
                <SearchInput
                    id="year_search"
                    onSearch={handleYearSearch}
                    externalError={errors?.year_id ?? false}
                    placeholder="Search for year..."
                    minSearchLength={3}
                    debounceTime={500}
                    errorMessages={{
                        searchFailed: "Failed to search years. Please try again.",
                        minimumLength: "Please enter at least 3 characters",
                        noResults: "No years found"
                    }}
                    on:selectionChange={handleYearSelectionChange}
                />
                <InputLabel
                    label={yearBL}
                />
            </label>
        {/if}

        <div class="flex flex-row gap-2">
            <Input
                topLabel={minCapTL}
                bottomLabel={minCapBL}
                placeholder="Default: 1"
                styling="flex-1"
                type="number"
                min="1"
                bind:value={form.minCapacity}
                required="{false}"
            />

            <Input
                topLabel={maxCapTL}
                bottomLabel={maxCapBL}
                placeholder="Default: 30"
                styling="flex-1"
                type="number"
                bind:value={form.maxCapacity}
                required="{false}"
            />
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
