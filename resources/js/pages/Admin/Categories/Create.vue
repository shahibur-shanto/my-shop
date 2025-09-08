<script setup>
import AdminLayout from "../../../../js/layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: ""
});

const submit = () => {
    form.post(route("admin.categories.store"));
};
</script>

<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold mb-4">Add New Category</h1>
        <form @submit.prevent="submit" class="bg-white p-6 rounded-lg shadow-md space-y-4">
            <div>
                <label class="block font-semibold">Name</label>
                <input v-model="form.name" type="text" class="w-full border p-2 rounded" />
                <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Save Category
            </button>
        </form>
    </AdminLayout>
</template>
