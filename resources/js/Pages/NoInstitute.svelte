<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
</script>

<AuthenticatedLayout showNavLinks={true} class="absolute inset-0 flex items-center justify-center -z-10">
        <div class="flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
            <h1 class="mt-4 text-3xl font-semibold tracking-tight text-error sm:text-5xl">No Institute Found !</h1>
            <p class="mt-6 text-center text-xl leading-7 text-gray-600 w-3/4">Sorry, we can't allow you to continue since you are not you assigned to any institute.</p>
            <p class="mt-2 text-base leading-7 italic text-gray-600">Please contact your administration, and comeback</p>
        </div>
</AuthenticatedLayout>
