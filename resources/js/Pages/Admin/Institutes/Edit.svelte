<script>
    import AuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import {router, useForm} from "@inertiajs/svelte";
    import Input from "@/Components/DataInputs/Input/Input.svelte";
    import {LabelTextConsts} from "@/Components/DataInputs/Input/LabelType";
    import { writable } from "svelte/store";

    export let errors, institute

    const form = useForm({
        description: institute.description
    });

    const nameTL = {
        left: {
            text: 'Institute Full Name:'
        }
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
        }
    }

    $: {
        console.log("Form desc: ", $form.description)
    }


    function handleSubmit() {
        router.put(`/admin/institutes/update/${institute.id}`, $form);
    }
</script>

<AuthenticatedLayout>
    <form on:submit|preventDefault={handleSubmit} class="form-control w-full max-w-md mx-auto gap-0.5">
        <Input
            topLabel={nameTL}
            bind:value={institute.name}
            readonly="{true}"
        />

        <Input
            topLabel={descTL}
            bottomLabel={descBL}
            type="textarea"
            placeholder="This institute is..."
            bind:value={$form.description}
        />

        <Input
            topLabel={dateTL}
            bind:value={institute.established_at}
            readonly="{true}"
        />

        <div class="flex items-center justify-end mt-4">
            <button disabled={form["processing"]} class="btn btn-sm btn-neutral ml-4">
                Apply
            </button>
        </div>
    </form>
</AuthenticatedLayout>
