<script>
    import ApplicationLogo from "@/Components/ApplicationLogo.svelte";
    import { inertia } from "@inertiajs/svelte";
    import autoAnimate from '@formkit/auto-animate';
</script>

<div class="min-h-screen flex flex-col sm:justify-center items-center justify-end pt-6 sm:pt-0">
    <div>
        <a href="/" use:inertia>
            <ApplicationLogo class="w-20 h-20 fill-current text-gray-500"/>
        </a>
    </div>

    <div use:autoAnimate class="w-fit sm:min-w-96 m-6 px-6 py-4 bg-base-200 shadow-md overflow-hidden rounded-lg">
        <slot />
    </div>
</div>
