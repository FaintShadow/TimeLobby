<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import {router, useForm} from "@inertiajs/svelte";

    export let errors, success, building

    const form = useForm({
        name: null,
    })

    form.name = building.name

    function handleSubmit() {
        errors = {}
        router.put(`/institute/admin/buildings/update/${building.id}`, form)
    }
</script>

<svelte:head>
    <title>TL : Edit Building</title>
</svelte:head>

<AuthenticatedLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control w-full max-w-md mx-auto gap-0.5">
        <label class="form-control">
            <div class="label">
                <span class="label-text">Building name</span>
            </div>
            <input
                id="name"
                type="text"
                class="input input-sm input-bordered"
                bind:value={form.name}
            />
        </label>

        <div class="flex items-center justify-end mt-4">
            <button disabled={form["processing"]} class="btn btn-sm btn-neutral ml-4">
               Proceed
            </button>
        </div>
    </form>
</AuthenticatedLayout>
