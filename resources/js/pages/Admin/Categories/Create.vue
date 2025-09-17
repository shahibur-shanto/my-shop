<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold mb-4">Add New Category</h1>

        <div v-if="successMessage"
             class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ successMessage }}
        </div>

        <form ref="nativeForm" @submit.prevent="submit" class="bg-white p-6 rounded-lg shadow-md space-y-4">
            <!-- Name -->
            <div>
                <label class="block font-semibold">Name</label>
                <input v-model="form.name" required type="text" class="w-full border p-2 rounded" />
                <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block font-semibold">Category Image</label>
                <!-- key forces a fresh DOM node when we increment fileInputKey -->
                <input
                    ref="fileInput"
                    :key="fileInputKey"
                    type="file"
                    @change="previewImage"
                    accept="image/*"
                    class="w-full border p-2 rounded"
                />
                <div v-if="form.errors.image" class="text-red-500 text-sm">{{ form.errors.image }}</div>

                <div v-if="imagePreview" class="mt-4">
                    <p class="text-gray-600 text-sm">Preview:</p>
                    <img :src="imagePreview" alt="Category Preview" class="w-32 h-32 object-cover border rounded" />
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 cursor-pointer rounded">
                Save Category
            </button>
        </form>
    </AdminLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import AdminLayout from "@/layouts/AdminLayout.vue";

const page = usePage()

const form = useForm({
    name: '',
    image: null,
})

const imagePreview = ref(null)
const fileInput = ref(null)       // native file input element
const nativeForm = ref(null)      // native <form> element
const fileInputKey = ref(0)       // increment to force recreate file input
const successMessage = ref(page.props.flash?.success || '')

// keep flash reactive
watch(() => page.props.flash, (flash) => {
    successMessage.value = flash?.success || ''
})

function previewImage(e) {
    const file = e.target.files?.[0] ?? null
    if (!file) {
        form.image = null
        if (imagePreview.value) {
            URL.revokeObjectURL(imagePreview.value)
            imagePreview.value = null
        }
        return
    }

    // basic client-side type check
    if (!file.type.startsWith('image/')) {
        form.errors.image = 'Please select a valid image file.'
        form.image = null
        return
    }

    // revoke old preview if present
    if (imagePreview.value) {
        URL.revokeObjectURL(imagePreview.value)
    }

    form.image = file
    imagePreview.value = URL.createObjectURL(file)
    form.errors.image = null
}

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

function submit() {
        if (!form.image) {
        form.errors.image = 'Please select an image.'
        return
    }


    form.post(route('admin.categories.store'), {
        preserveScroll: true,
        onSuccess: () => {
            // clear Inertia form state
            form.reset()
            form.image = null

            // revoke object url and clear preview
            if (imagePreview.value) {
                URL.revokeObjectURL(imagePreview.value)
                imagePreview.value = null
            }

            // DOM-level clearing
            clearFileInputDom()

            // set success message from flash (will arrive via Inertia share)
            successMessage.value = page.props.flash?.success || 'Category added successfully!'
        },
        onError: () => {
            // keep preview if validation failed
        },
    })
}
</script>















<!--<script setup>-->
<!--import AdminLayout from "../../../../js/layouts/AdminLayout.vue";-->
<!--import { useForm, usePage } from "@inertiajs/vue3";-->
<!--import { reactive, ref } from 'vue'-->

<!--const form = useForm({-->
<!--    name: '',-->
<!--    image: null,-->
<!--});-->
<!--const imagePreview = ref(null)-->
<!--const fileInput = ref(null)-->
<!--const page = usePage()-->
<!--const successMessage = ref(page.props.flash?.success || '')-->
<!--const previewImage = (e) => {-->
<!--    const file = e.target.files[0];-->
<!--    if (!file) {-->
<!--        form.image = null;-->
<!--        imagePreview.value = null;-->
<!--        return;-->
<!--    }-->

<!--    // Validate file type (image only)-->
<!--    if (!file.type.startsWith("image/")) {-->
<!--        form.errors.image = "Please select a valid image file.";-->
<!--        form.image = null;-->
<!--        imagePreview.value = null;-->
<!--        return;-->
<!--    }-->

<!--    form.image = file;-->
<!--    imagePreview.value = URL.createObjectURL(file);-->
<!--    form.errors.image = null;-->
<!--};-->

<!--const submit = () => {-->
<!--    // Frontend validation: make sure image is selected-->
<!--    if (!form.image) {-->
<!--        form.errors.image = "Image is required.";-->
<!--        return;-->
<!--    }-->

<!--    // Use FormData to send file-->
<!--    const formData = new FormData();-->
<!--    formData.append("name", form.name);-->
<!--    formData.append("image", form.image);-->

<!--    form.post(route("admin.categories.store"), {-->
<!--        data: formData,-->
<!--        forceFormData: true, // required for file upload-->
<!--        onSuccess: () => {-->
<!--            successMessage.value = page.props.flash.success || 'Category added successfully!'-->
<!--            form.reset()         // ✅ reset all fields-->
<!--            imagePreview.value = null-->

<!--            if (fileInput.value) {-->
<!--                fileInput.value.value = ''-->
<!--            }-->
<!--        }-->
<!--    });-->
<!--};-->
<!--</script>-->

<!--<template>-->
<!--    <AdminLayout>-->

<!--        <h1 class="text-2xl font-bold mb-4">Add New Category</h1>-->
<!--        <div v-if="successMessage" class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">-->
<!--            {{ successMessage }}-->
<!--        </div>-->
<!--        <form @submit.prevent="submit" class="bg-white p-6 rounded-lg shadow-md space-y-4">-->
<!--            &lt;!&ndash; Name &ndash;&gt;-->
<!--            <div>-->
<!--                <label class="block font-semibold">Name</label>-->
<!--                <input v-model="form.name" type="text" class="w-full border p-2 rounded" />-->
<!--                <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>-->
<!--            </div>-->

<!--            &lt;!&ndash; Image Upload &ndash;&gt;-->
<!--            <div>-->
<!--                <label class="block font-semibold">Category Image</label>-->
<!--                <input ref="fileInput" type="file" @change="previewImage" accept="image/*" class="w-full border p-2 rounded" />-->
<!--                <div v-if="form.errors.image" class="text-red-500 text-sm">{{ form.errors.image }}</div>-->

<!--                &lt;!&ndash; Immediate Preview &ndash;&gt;-->
<!--                <div v-if="imagePreview" class="mt-4">-->
<!--                    <p class="text-gray-600 text-sm">Preview:</p>-->
<!--                    <img :src="imagePreview" alt="Category Preview" class="w-32 h-32 object-cover border rounded" />-->
<!--                </div>-->
<!--            </div>-->

<!--            &lt;!&ndash; Submit &ndash;&gt;-->
<!--            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">-->
<!--                Save Category-->
<!--            </button>-->
<!--        </form>-->
<!--    </AdminLayout>-->
<!--</template>-->
