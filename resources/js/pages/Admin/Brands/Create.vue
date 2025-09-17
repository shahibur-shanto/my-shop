<script setup>
import AdminLayout from "../../../../js/layouts/AdminLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {ref, watch} from "vue";



const fileInput = ref(null);
const page = usePage()
const nativeForm = ref(null)      // native <form> element
const fileInputKey = ref(0)

const form = useForm({
    name: "",
    description: "",
    url: "",
});

const successMessage = ref(page.props.flash?.success || '')
watch(() => page.props.flash, (flash) => {
    successMessage.value = flash?.success || ''
})

function clearFileInputDom() {
    // 1) try native form reset (clears most inputs incl file)
    if (nativeForm.value && typeof nativeForm.value.reset === 'function') {
        nativeForm.value.reset()
    }

    // 2) explicitly clear the file input DOM value
    if (fileInput.value) {
        try {
            fileInput.value.value = null
        } catch (err) {
            // some browsers might throw, ignore safely
        }
    }

    // 3) force recreate the file input element (guarantees clean element)
    fileInputKey.value++
}


const submit = () => {
    form.post(route("admin.brands.store"),{
        preserveScroll: true,
        onSuccess: () => {
            // clear Inertia form state
            form.reset()
            // DOM-level clearing
            clearFileInputDom()

            // set success message from flash (will arrive via Inertia share)
            successMessage.value = page.props.flash?.success || 'Brand added successfully!'
        },
        onError: () => {
            // keep preview if validation failed
        },
    });
};
</script>

<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold mb-4">Add New Brand</h1>
        <div v-if="successMessage"
             class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ successMessage }}
        </div>
        <form @submit.prevent="submit" class="bg-white p-6 rounded-lg shadow-md space-y-4">
            <div>
                <label class="block font-semibold">Name</label>
                <input v-model="form.name" type="text" class="w-full border p-2 rounded" />
                <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
            </div>
            <div>
                <label class="block font-semibold">Description</label>
                <textarea v-model="form.description" class="w-full border p-2 rounded"></textarea>
                <div v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</div>
            </div>

            <div>
                <label class="block font-semibold">Url</label>
                <input v-model="form.url" type="text" class="w-full border p-2 rounded" />
                <div v-if="form.errors.url" class="text-red-500 text-sm">{{ form.errors.url }}</div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">
                Save Brand
            </button>
        </form>
    </AdminLayout>
</template>
