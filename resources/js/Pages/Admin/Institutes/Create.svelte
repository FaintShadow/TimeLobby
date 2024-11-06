<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import {router, useForm, page} from "@inertiajs/svelte";

    export let errors;
    export let success;

    $: errs = errors || $page.props.errors;
    $: succes = success || $page.props.success;

    console.log($page.props);

    let form = useForm({
        name: null,
        description: null,
        established_at: null,
    });

    function handleSubmit() {
        router.post('/admin/institutes/add', form)
    }
</script>

<AuthenticatedLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control" type="x-www-form-urlencoded">
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Full institute name</span>
            </div>
            <input
                id="name"
                type="text"
                class="input input-sm input-bordered w-full { errors.name ? 'input-error' : null }"
                required
                bind:value={form.name}
            />
            <div class="label">
                {#if (errors.name)}
                    <span class="label-text-alt text-red-600">{errors.name}</span>
                {/if}
                <span class="label-text-alt"></span>
            </div>
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
                class="input input-sm input-bordered w-full { errors.established_at ? 'input-error' : null }"
                required
                bind:value={form.established_at}
            />
            <div class="label">
                {#if (errors.established_at)}
                    <span class="label-text-alt text-red-600">{errors.established_at}</span>
                {/if}
                <span class="label-text-alt"></span>
            </div>
        </label>

        <div class="flex items-center justify-end mt-4">
            <button disabled={form["processing"]} class="btn btn-sm btn-neutral ml-4">
                Add Institute
            </button>
        </div>
    </form>
</AuthenticatedLayout>
