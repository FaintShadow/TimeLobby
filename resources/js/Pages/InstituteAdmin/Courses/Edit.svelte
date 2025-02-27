<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import { router, useForm } from "@inertiajs/svelte";

    // Vars
    export let errors, success, course;

    const form = useForm({
        name: course.name
    });

    // Reactive
    $: isFormUnchanged = form.name === course.name;

    async function handleSubmit() {
        router.put(`/admin/courses/update/${course.id}`, form);
    }
</script>

<AuthenticatedLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control w-full max-w-md mx-auto gap-0.5">
        <!-- Name Field -->
        <label class="form-control">
            <div class="label">
                <span class="label-text">Course Name</span>
            </div>
            <input
                type="text"
                class="input input-sm input-bordered input-disabled"
                bind:value={form.name}
                disabled
                readonly
            />
        </label>

        <!-- Submit Button -->
        <div class="flex justify-end mt-6">
            <button
                type="submit"
                class="btn btn-sm btn-neutral"
                disabled={isFormUnchanged}
            >
                Apply
            </button>
        </div>
    </form>
</AuthenticatedLayout>
