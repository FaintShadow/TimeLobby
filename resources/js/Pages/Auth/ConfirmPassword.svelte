<script>
    import Guest from "@/Layouts/Guest.svelte";
    import { useForm } from "@inertiajs/svelte";
    const form = useForm({
        password: "",
    });
    const submit = () => {
        $form.post(window.route("password.confirm"), {
            onFinish: () => $form.reset(),
        });
    };
</script>

<svelte:head>
    <title>Confirm Password</title>
</svelte:head>

<Guest>
    <div class="mb-4 text-sm text-gray-600">
        This is a secure area of the application. Please confirm your password
        before continuing.
    </div>

    <form on:submit|preventDefault={submit}>
        <label class="form-control">
            <div class="label">
                <span class="label-text">Password:</span>
            </div>
            <input
                id="password"
                type="password"
                class="input input-sm input-bordered"
                value={form.password}
                required
                autocomplete="current-password"
                autofocus
                on:input={(evt) => ($form.password = evt.detail)}
            />
        </label>

        <div class="flex justify-end mt-4">
            <button
                class="btn btn-primary"
                class:opacity-25={form.processing}
                disabled={form.processing}
            >
                Confirm
            </button>
        </div>
    </form>
</Guest>
