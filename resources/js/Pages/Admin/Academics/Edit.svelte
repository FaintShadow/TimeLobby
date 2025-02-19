<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import { router, useForm } from "@inertiajs/svelte";
    import SearchInput from "@/Components/DataInputs/Search/SearchInput.svelte";
    import InputLabel from "@/Components/DataInputs/Input/InputLabel.svelte";
    import Input from "@/Components/DataInputs/Input/Input.svelte";
    import {LabelTextConsts} from "@/Components/DataInputs/Input/LabelType";

    // Vars
    export let errors, academic;

    $: {
        console.log(isFormUnchanged)
    }

    const form = useForm({
        institute_id: academic.institute?.id | null,
        role: academic.role | null
    });

    $: isFormUnchanged = $form.institute_id === academic.institute?.id && $form.role === academic.role;
    $: displayName = `${academic.firstname[0]}. ${academic.lastname}`;

    async function handleSubmit() {
        router.put(`/admin/academics/update/${academic.id}`, form);
    }

    const name_TL = {
        left: {
            text: "Name:",
        },
        right: {
            type: LabelTextConsts.BADGE,
            styling: "badge-error text-error-content",
            text: "REQUIRED"
        }
    }

    $: institute_TL = {
        left: {
            text: 'Institute:',
        },
        right: {
            type: LabelTextConsts.BADGE,
            styling: "badge-error text-error-content",
            text: "REQUIRED"
        }
    }

    $: institute_BL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.institute_id
        },
        show: errors.institute_id ?? false
    }

    const role_TL = {
        left: {
            text: "Role:",
        },
        right: {
            type: LabelTextConsts.BADGE,
            styling: "badge-error text-error-content",
            text: "REQUIRED"
        }
    }

    $: role_BL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.role
        },
        show: errors.role ?? false
    }

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

    function handleInstituteSelectionChange(event) {
        const [selected] = event.detail;

        if (selected) {
            form.institute_id = selected.id
        }
    }


</script>

<AuthenticatedLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control w-full max-w-md mx-auto gap-0.5">
        <!-- Name Field -->
        <Input
            topLabel={name_TL}
            bind:value={displayName}
            readonly="{true}"
        />

        <!-- Institute Field -->
        <label for="institute_search" class="form-control w-full">
            <InputLabel
                label={institute_TL}
            />
            <SearchInput
                id="institute_search"
                onSearch={handleInstituteSearch}
                initialText={academic.institute?.name}
                externalError={errors.institute_id ?? false}
                placeholder="Search for institute..."
                minSearchLength={4}
                debounceTime={500}
                errorMessages={{
                        searchFailed: "Failed to search institutes. Please try again.",
                        minimumLength: "Please enter at least 4 characters",
                        noResults: "No institute found"
                    }}
                on:selectionChange={handleInstituteSelectionChange}
            />
            <InputLabel
                label={institute_BL}
            />
        </label>

        <!-- Role Field -->
        <label class="form-control">
            <InputLabel label={role_TL}/>
            <select
                class="select select-sm select-bordered w-full"
                on:change={(e) => form.role = e.target.value}
            >
                <option disabled>Select a role</option>
                <option value="institute-admin" selected={academic.role === 'institute-admin'}>Admin</option>
                <option value="institute-manager" selected={academic.role === 'institute-manager'}>Manager</option>
                <option value="teacher" selected={academic.role === 'teacher'}>Teacher</option>
                <option value="student" selected={academic.role === 'student'}>Student</option>
            </select>
            <InputLabel label={role_BL}/>
        </label>

        <!-- Submit Button -->
        <div class="flex justify-end mt-6">
            <button
                type="submit"
                class="btn btn-sm  btn-neutral"
                class:btn-disabled={isFormUnchanged}
                disabled={isFormUnchanged}
            >
                Apply
            </button>
        </div>
    </form>
</AuthenticatedLayout>
