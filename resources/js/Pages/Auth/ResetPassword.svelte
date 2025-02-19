<script>
    import GuestLayout from "@/Layouts/Guest.svelte";
    import {useForm} from "@inertiajs/svelte";

    export let errors = {};
    export let email;
    export let token;

    const form = useForm({
        token: token,
        email: email,
        password: '',
        password_confirmation: '',
    });

    const onSubmit = () => {
        $form.post("/reset-password", {
            onSuccess: () => $form.reset("password", "password_confirmation"),
        });
    };
</script>

<svelte:head>
    <title>TL : Reset Password</title>
</svelte:head>

<GuestLayout>
    <form on:submit|preventDefault={onSubmit} class="form-control">
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Password</span>
            </div>
            <input type="password"
                   id="password"
                   class="input input-sm input-bordered w-full"
                   class:input-error={errors.password}
                   required
                   autocomplete="new-password"
                   bind:value={$form.password}
            />
            {#if (errors.password)}
                <div class="label">
                    <span class="label-text-alt text-red-600">{errors.password}</span>
                </div>
            {/if}

        </label>

        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Confirm password</span>
            </div>
            <input type="password"
                   id="password_confirmation"
                   class="input input-sm input-bordered w-full"
                   class:input-error={errors.password_confirmation}
                   required
                   bind:value={$form.password_confirmation}
            />
            {#if (errors.password_confirmation)}
                <div class="label">
                    <span class="label-text-alt text-red-600">{errors.password_confirmation}</span>
                </div>
            {/if}

        </label>

        <div class="flex items-center justify-end mt-4">
            <button
                class:opacity-25={form.processing}
                disabled={form.processing}
                class="btn btn-sm btn-primary"
            >
                Reset Password
            </button>
        </div>
    </form>
</GuestLayout>
