<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import {router} from "@inertiajs/svelte";
    import PaginateLayout from "@/Components/Paginate.svelte";
    import autoAnimate from "@formkit/auto-animate";

    // Vars
    export let success, courses, links;

    $: {
        console.log(links)
    }

    let values = []
    let innerWidth;
    let innerHeight;

    $: selected = [];

    // Functions:
    $: {
        values = courses.data.map(item => item.id);
    }

    function toggleAll(e) {
        selected = e.target.checked ? [...values] : [];
    }

    function removeSelected() {
        // TODO: add alert if there is nothing selected
        if (selected.length === 0) return;

        if (confirm(`Are you sure you want to remove ${selected.length} selected courses?`)) {
            router.delete(links['courses.bulk-delete'],
                {
                    data: {
                        ids: selected
                    },
                    preserveScroll: true,
                    onSuccess: () => {
                        selected = [];
                    },
                });
        }
    }

    function editSelected() {
        if (selected.length === 0) return;
        router.get(links['courses.edit'].replace('replace-me', selected[0]));
    }

    function loadPage(url) {
        if (!url) return;
        router.get(url, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (page) => {
                courses = page.props.courses;
            }
        });
    }

</script>

<svelte:window bind:innerWidth bind:innerHeight/>

<AuthenticatedLayout>
    <div class="w-screen px-4">
        <a href="{links['courses.create']}" class="btn">
            Add
        </a>
        <button
            class="btn btn-md"
            class:btn-disabled={selected.length === 0}
            disabled={selected.length === 0}
            on:click={removeSelected}
        >
            Remove Selected ({selected.length})
        </button>
        <button
            class="btn"
            class:btn-disabled={selected.length !== 1}
            disabled={selected.length !== 1}
            on:click={editSelected}
        >
            Edit
        </button>
    </div>
    <!--Table -->
    {#if courses.data.length > 0}
        <div id="institutes" class="px-4 w-screen my-1" use:autoAnimate>
            <div class="bg-base-200 flex flex-row justify-items-center p-1.5 rounded-md my-1">
                <div class="flex justify-center border-r-2 pr-2 border-base-100">
                    <label class="h-0">
                        <input
                            type="checkbox"
                            on:change={toggleAll}
                            checked={selected.length === values.length}
                            class="checkbox"/>
                    </label>
                </div>
                <div class="w-full text-base-content px-2 border-r-0 border-base-100 sm:border-r-2">Name</div>
                <div class="min-w-20 text-base-content px-2 hidden border-base-100 sm:inline border-r-2">Teachers</div>
                <div class="min-w-12 text-base-content px-2 hidden border-base-100 sm:inline">Classes</div>
            </div>
            {#if courses}
                {#each courses.data as course (course.id)}
                    <div class="flex flex-row justify-items-center p-1.5 rounded-md my-1" use:autoAnimate>
                        <div class="flex justify-center border-r-2 pr-2 border-base-200">
                            <label class="h-0">
                                <input type="checkbox" bind:group={selected} class="checkbox"
                                       name="institutes" value="{course.id}"/>
                            </label>
                        </div>
                        <div class="w-full px-2 border-r-0 sm:border-r-2 border-base-200">{course.name}</div>
                        {#if innerWidth > 640}
                            <div class="min-w-20 px-2 border-r-2 border-base-200">{course.teachers}</div>
                            <div class="min-w-12 px-2">{course.classes}</div>
                        {/if}
                    </div>
                {/each}
            {/if}
        </div>
        <PaginateLayout links={courses.links} {loadPage}/>
    {/if}
</AuthenticatedLayout>
