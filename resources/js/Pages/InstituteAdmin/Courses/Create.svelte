<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import {router, useForm} from "@inertiajs/svelte";
    import InputLabel from "@/Components/DataInputs/Input/InputLabel.svelte";
    import Input from "@/Components/DataInputs/Input/Input.svelte";
    import SearchInput from "@/Components/DataInputs/Search/SearchInput.svelte";
    import {LabelTextConsts} from "@/Components/DataInputs/Input/LabelType";

    export let errors, links;

    let form = useForm({
        name: null,
        group_id: null,
    });

    const name_TL = {
        left: {
            text: "Name:"
        }
    }

    $: name_BL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.name,
        },
        show: errors.name ?? false
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
            text: errors.group_id,
        },
        show: errors.group_id ?? false
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
            form.group_id = selected.id
        }
    }

    function handleSubmit(event) {

    }

</script>

<AuthenticatedLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control w-full max-w-md mx-auto gap-0.5" type="x-www-form-urlencoded">

        <Input
            topLabel={name_TL}
            bottomLabel={name_BL}
            bind:value={form.name}
        />

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

        <div class="flex items-center justify-end mt-4">
            <button disabled={form["processing"]} class="btn btn-sm btn-neutral ml-4">
                Add Course
            </button>
        </div>
    </form>
</AuthenticatedLayout>
