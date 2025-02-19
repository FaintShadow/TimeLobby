<script>
    import GuestLayout from "@/Layouts/Guest.svelte";
    import {useForm, router} from "@inertiajs/svelte";

    export let status, errors, links;
    const form = useForm({
        email: null,
        processing: false,
    });
    function handleSubmit() {
        form.processing = true
        router.post(links['password.email'], form)
        form.processing = false
    }
</script>

<svelte:head>
    <title>Forgot Password</title>
</svelte:head>

<GuestLayout>
    <div class="sm:max-w-2xl">
        <div class="mb-4 text-sm text-base-content">
            Forgot your password? No problem. Just let us know your email address
            and we will email you a password reset link that will allow you to
            choose a new one.
        </div>

        {#if status}
            <div class="mb-4 font-medium text-sm text-green-600">
                {status}
            </div>
        {/if}

        <form on:submit|preventDefault={handleSubmit}>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Email:</span>
                </div>
                <input
                    bind:value={form.email}
                    placeholder="example@email.com"
                    class="input input-sm input-bordered"
                    autocomplete="email"
                    type="email"
                    id="email"
                    autofocus
                    required
                />
            </label>

            <div class="flex items-center justify-end mt-4">
                <button
                    class:opacity-25={form.processing}
                    disabled={form.processing}
                    class="btn btn-primary"
                >
                    Email Password Reset Link
                </button>
            </div>
        </form>
    </div>
</GuestLayout>
