<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import {router, useForm} from "@inertiajs/svelte";
    import Input from "@/Components/DataInputs/Input/Input.svelte";
    import {LabelTextConsts} from "@/Components/DataInputs/Input/LabelType";

    // Vars
    export let errors, links

    let form = useForm({
        name: null,
        description: null,
        established_at: null,
    });

    console.log(links)

    $: {
        console.log(errors)
    }

    const nameTL = {
        left: {
            text: 'Institute Full Name:'
        },
        right: {
            type: LabelTextConsts.BADGE,
            styling: "badge-error text-error-content",
            text: "REQUIRED"
        }
    }

    $: nameBL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.name
        },
        show: errors.name ?? false
    }

    const descTL = {
        left: {
            text: 'Description:'
        }
    }

    $: descBL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.description,
        },
        show: errors.description ?? false
    }

    const dateTL = {
        left: {
            text: 'Establishment Date:'
        },
        right: {
            type: LabelTextConsts.BADGE,
            styling: "badge-error text-error-content",
            text: "REQUIRED"
        }
    }

    $: dateBL = {
        position: LabelTextConsts.BOTTOM,
        left: {
            styling: 'text-error',
            text: errors.established_at,
        },
        show: errors.established_at ?? false
    }


    // Functions:
    function handleSubmit() {
        router.post(links["admin.institutes.store"], form)
    }
</script>

<svelte:head>
    <title>TL : Add Institute</title>
</svelte:head>

<AuthenticatedLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control w-full max-w-md mx-auto gap-0.5" type="x-www-form-urlencoded">
        <Input
            topLabel={nameTL}
            bottomLabel={nameBL}
            bind:value={form.name}
        />

        <Input
            type="textarea"
            placeholder="This institute is..."
            topLabel={descTL}
            bottomLabel={descBL}
            required="{false}"
            bind:value={form.description}
        />

        <Input
            topLabel={dateTL}
            bottomLabel={dateBL}
            required="{false}"
            type="date"
            bind:value={form.established_at}
        />

        <div class="flex items-center justify-end mt-4">
            <button disabled={form["processing"]} class="btn btn-sm btn-neutral ml-4">
                Add Institute
            </button>
        </div>
    </form>
</AuthenticatedLayout>
