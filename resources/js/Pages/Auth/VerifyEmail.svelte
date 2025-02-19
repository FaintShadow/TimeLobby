<script>
    import GuestLayout from "@/Layouts/Guest.svelte";
    import {useForm} from "@inertiajs/svelte";

    export let message;
    const form = useForm();
    let verificationLinkSent;

    const onSubmit = () => {
        $form.post('/email/verification-notification');
    };

    $: {
        verificationLinkSent = message;
    }
</script>

<svelte:head>
    <title>TL : Email Verification</title>
</svelte:head>

<GuestLayout>
    <div class="sm:max-w-2xl">
        <div class="mb-4 text-sm text-base-content">
            <h1 class="text-xl font-bold mb-2">Thanks for signing up!</h1>
            Before getting started, could you verify your
            email address by clicking on the link we just emailed to you? If you
            didn't receive the email, we will gladly send you another.
        </div>

        {#if verificationLinkSent}
            <div
                class="mb-4 font-medium text-sm text-green-600"
            >
                A new verification link has been sent to the email address you
                provided during registration.
            </div>
        {/if}

        <form on:submit|preventDefault={onSubmit}>
            <div class="mt-4 flex items-center justify-between max-sm:flex-col-reverse">
                <button
                    class="btn btn-neutral"
                    class:opacity-25={form.processing}
                    disabled={form.processing}
                >
                    Resend Verification Email
                </button>

                <a
                    href="/logout"
                    class="btn"
                >
                    Log Out
                </a>
            </div>
        </form>
    </div>
</GuestLayout>
