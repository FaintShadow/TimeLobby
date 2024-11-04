<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import {router, useForm, page} from "@inertiajs/svelte";

    let institute = $page.props.institute;

    $: errors = $page.props.errors;
    $: success = $page.props.success;

    let form = useForm({
        description: null
    });

    function handleSubmit() {
        router.post('/admin/institutes/edit', form)
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
                <span class="badge badge-info">Optional</span>
            </div>
            <textarea
                id="description"
                class="input input-md input-bordered w-full { errors.description ? 'input-error' : null }"
                bind:value={form.description}
            />
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
