<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import {router, useForm, page} from "@inertiajs/svelte";

    let institute = $page.props.institute;
    console.log(institute);

    $: errors = $page.props.errors;
    $: success = $page.props.success;

    let form = useForm({
        id: institute.id,
        name: institute.name,
        description: institute.description,
        established_at: institute.established_at,
    });

    function handleSubmit() {
        errors = {};
        router.put(`/admin/institutes/update/${institute.id}`, form);
    }
</script>

<AuthenticatedLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control">
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Full institute name</span>
            </div>
            <input
                id="name"
                type="text"
                class="input input-sm input-bordered w-full"
                value={institute.name}
                readonly
            />
        </label>

        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Description</span>
            </div>
            <textarea
                id="description"
                class="input input-md input-bordered w-full"
                class:input-error={errors.description}
                on:input={(e) => form.description = e.target.value}
            >{institute.description ? institute.description : ""}</textarea>
            <div class="label">
                {#if (errors.description)}
                    <span class="label-text-alt text-red-600">{errors.description}</span>
                {/if}
                <span class="label-text-alt"></span>
            </div>
        </label>

        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Establishment Date</span>
            </div>
            <input
                id="description"
                type="date"
                class="input input-sm input-bordered w-full"
                value="{institute.established_at}"
                required
                readonly
            />
        </label>

        <div class="flex items-center justify-end mt-4">
            <button disabled={form["processing"]} class="btn btn-sm btn-neutral ml-4">
                Add Institute
            </button>
        </div>
    </form>
</AuthenticatedLayout>
