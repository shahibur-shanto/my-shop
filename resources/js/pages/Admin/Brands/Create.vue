<script setup>
import AdminLayout from "../../../../js/layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    description: "",
    url: "",
});

const submit = () => {
    form.post(route("admin.brands.store"));
};
</script>

<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold mb-4">Add New Brand</h1>
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

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Save Brand
            </button>
        </form>
    </AdminLayout>
</template>
