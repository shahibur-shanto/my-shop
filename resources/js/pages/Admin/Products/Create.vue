<script setup>
import AdminLayout from "../../../../js/layouts/AdminLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {ref, watch} from "vue";




const imagePreview = ref(null)
const fileInput = ref(null);
const nativeForm = ref(null)      // native <form> element
const fileInputKey = ref(0)

const page = usePage()
const categories = page.props.categories;
const brands = page.props.brands;



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


const form = useForm({
    name: "",
    price: "",
    category_id:'',
    brand_id:'',
    description: "",
    quantity: "",
    image:"",
});

const successMessage = ref(page.props.flash?.success || '')
watch(() => page.props.flash, (flash) => {
    successMessage.value = flash?.success || ''
})


function submit() {
    if (!form.image) {
        form.errors.image = 'Please select an image.'
        return
    }


    form.post(route('admin.products.store'), {
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

<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold mb-4">Add New Product</h1>

        <div v-if="successMessage"
             class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ successMessage }}
        </div>
        <form @submit.prevent="submit" class="bg-white p-6 rounded-lg shadow-md space-y-4">

            <!-- Category -->
            <div>
                <label class="block font-semibold">Category</label>
                <select v-model="form.category_id" class="w-full border p-2 rounded">
                    <option value="">Select Category</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                        {{ cat.name }}
                    </option>
                </select>
                <div v-if="form.errors.category_id" class="text-red-500 text-sm">
                    {{ form.errors.category_id }}
                </div>
            </div>

            <div>
                <label class="block font-semibold">Brand</label>
                <select v-model="form.brand_id" class="w-full border p-2 rounded">
                    <option value="">Select Brand</option>
                    <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                        {{ brand.name }}
                    </option>
                </select>
                <div v-if="form.errors.brand_id" class="text-red-500 text-sm">
                    {{ form.errors.brand_id }}
                </div>
            </div>

            <div>
                <label class="block font-semibold">Name</label>
                <input v-model="form.name" type="text" class="w-full border p-2 rounded" />
                <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
            </div>

            <div>
                <label class="block font-semibold">Price</label>
                <input v-model="form.price" type="number" step="0.01" class="w-full border p-2 rounded" />
                <div v-if="form.errors.price" class="text-red-500 text-sm">{{ form.errors.price }}</div>
            </div>

            <div>
                <label class="block font-semibold">Description</label>
                <textarea v-model="form.description" class="w-full border p-2 rounded"></textarea>
                <div v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</div>
            </div>

            <div>
                <label class="block font-semibold">Stock</label>
                <input v-model="form.quantity" type="number" class="w-full border p-2 rounded" />
                <div v-if="form.errors.quantity" class="text-red-500 text-sm">{{ form.errors.quantity }}</div>
            </div>
            <div>
                <label class="block font-semibold">Product Image</label>
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

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">
                Save Product
            </button>
        </form>
    </AdminLayout>
</template>
