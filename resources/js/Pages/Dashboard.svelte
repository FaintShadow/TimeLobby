<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
</script>

<svelte:head>
    <title>Dashboard</title>
</svelte:head>

<AuthenticatedLayout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight" slot="header">
        Dashboard
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
