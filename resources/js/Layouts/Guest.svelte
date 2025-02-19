<script>
    import ApplicationLogo from "@/Components/ApplicationLogo.svelte";
    import { inertia } from "@inertiajs/svelte";
</script>

<div class="min-h-screen flex flex-col sm:justify-center items-center justify-end pt-6 sm:pt-0">
    <div>
        <a href="/" class="flex flex-row items-center" use:inertia>
            <ApplicationLogo class="w-16 h-16 fill-current text-gray-500"/>
            <span class="ml-2 text-xl font-semibol d">Time Lobby</span>
        </a>
    </div>

    <div class="w-fit sm:min-w-96 m-6 px-6 py-4 bg-base-200 overflow-hidden rounded-lg">
        <slot />
    </div>
</div>
