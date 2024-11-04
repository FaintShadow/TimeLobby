<script>
    import ApplicationLogo from "@/Components/ApplicationLogo.svelte";
    import { inertia } from "@inertiajs/svelte";
</script>

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-screen h-10">
        <a href="/" use:inertia class="flex items-center">
            <ApplicationLogo class="h-full fill-current"/>
            <span class="text-xl">TimeLobby</span>
        </a>
    </div>

    <div class="w-full sm:max-w-sm px-6 py-4 shadow-md">
        <slot />
    </div>
</div>
