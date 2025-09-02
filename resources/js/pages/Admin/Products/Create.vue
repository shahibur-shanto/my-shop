<script setup>
import AdminLayout from "../../../../js/layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    price: "",
    description: "",
    stock: "",
});

const submit = () => {
    form.post(route("admin.products.store"));
};
</script>

<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold mb-4">Add New Product</h1>
        <form @submit.prevent="submit" class="bg-white p-6 rounded-lg shadow-md space-y-4">
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
                <input v-model="form.stock" type="number" class="w-full border p-2 rounded" />
                <div v-if="form.errors.stock" class="text-red-500 text-sm">{{ form.errors.stock }}</div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Save Product
            </button>
        </form>
    </AdminLayout>
</template>
