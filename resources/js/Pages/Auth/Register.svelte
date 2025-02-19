<script>
    import GuestLayout from "@/Layouts/Guest.svelte";
    import {inertia, useForm, router, page} from "@inertiajs/svelte";

    export let errors

    let form = useForm({
        firstname: null,
        lastname: null,
        email: null,
        password: null,
        password_confirmation: null,
        terms: false,
    });

    function handleSubmit() {
        router.post('/register', form)
    }
</script>

<svelte:head>
    <title>TL : Register</title>
</svelte:head>

<GuestLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control">
        <div class="flex gap-2">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">First name</span>
                </div>
                <input
                    id="firstname"
                    type="text"
                    class="input input-sm input-bordered w-full { errors.firstname ? 'input-error' : null }"
                    bind:value={form.firstname}
                    required
                    autocomplete="name"
                />
                <div class="label">
                    {#if (errors.firstname)}
                        <span class="label-text-alt text-red-600">{errors.firstname}</span>
                    {/if}
                    <span class="label-text-alt"></span>
                </div>
            </label>
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Last name</span>
                </div>
                <input
                    id="lastname"
                    type="text"
                    class="input input-sm input-bordered w-full { errors.lastname ? 'input-error' : null }"
                    bind:value={form.lastname}
                    required
                    autocomplete="name"
                />
                {#if (errors.lastname)}
                    <div class="label">
                        <span class="label-text-alt"></span>
                        <span class="label-text-alt text-red-600">{errors.lastname}</span>
                    </div>
                {/if}
            </label>
        </div>

        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Email</span>
            </div>
            <input
                id="email"
                type="email"
                placeholder="example@email.com"
                class="input input-sm input-bordered w-full { errors.email ? 'input-error' : null }"
                required
                autocomplete="username"
                bind:value={form.email}
            />
            <div class="label">
                {#if (errors.email)}
                    <span class="label-text-alt text-red-600">{errors.email}</span>
                {/if}
                <span class="label-text-alt"></span>
            </div>
        </label>

        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Password</span>
            </div>
            <input type="password"
                   id="password"
                   class="input input-sm input-bordered w-full { errors.password ? 'input-error' : null }"
                   required
                   autocomplete="new-password"
                   bind:value={form.password}
            />
            <div class="label">
                {#if (errors.password)}
                    <span class="label-text-alt text-red-600">{errors.password}</span>
                {/if}
                <span class="label-text-alt"></span>
            </div>
        </label>

        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Confirm password</span>
            </div>
            <input type="password"
                   id="password_confirmation"
                   class="input input-sm input-bordered w-full { errors.password_confirmation ? 'input-error' : null }"
                   required
                   bind:value={form.password_confirmation}
            />
            <div class="label">
                {#if (errors.password_confirmation)}
                    <span class="label-text-alt text-red-600">{errors.password_confirmation}</span>
                {/if}
                <span class="label-text-alt"></span>
            </div>
        </label>

        <div class="flex items-center justify-end mt-4">
            <a
                href="/login"
                use:inertia
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >
                Already registered?
            </a>

            <button
                class="btn btn-sm btn-primary ml-4"
                disabled={form["processing"]}
            >
                Register
            </button>
        </div>
    </form>
</GuestLayout>
