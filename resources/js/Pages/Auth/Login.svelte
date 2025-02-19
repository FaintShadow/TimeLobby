<script>
    import GuestLayout from "@/Layouts/Guest.svelte";
    import {Link, router, useForm, page} from "@inertiajs/svelte";

    export let canResetPassword = true
    export let errors, links

    console.log(links)

    let form = useForm({
        email: null,
        password: null,
        remember: false,
    })

    function handleSubmit() {
        router.post(links['login'], form)
    }
</script>

<svelte:head>
    <title>TL : Log in</title>
</svelte:head>

<GuestLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control">
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

        <!-- svelte-ignore a11y-label-has-associated-control -->
        <div class="flex items-center justify-between">
            <div>
                <label class="label cursor-pointer pl-0">
                    <input type="checkbox" name="remember" class="checkbox checkbox-xs mr-1"
                           bind:checked={form["remember"]}/>
                    <span class="label-text">Remember me</span>
                </label>
            </div>

            {#if canResetPassword}
                <Link
                    href="{links['password.request']}"
                    class="underline text-sm hover:text-neutral"
                >
                    Forgot your password?
                </Link>
            {/if}
        </div>

        <div class="flex items-center justify-end mt-4">
            <Link
                href="{links['register']}"
                class="underline text-sm hover:text-neutral">
                Don't have an account ?
            </Link>
            <button
                disabled={form["processing"]}
                class="btn btn-sm btn-primary ml-4"
            >
                Login
            </button>
        </div>
    </form>
</GuestLayout>
