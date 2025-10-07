<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";


const page = usePage();
const order = ref(null);
const loading = ref(true);
const error = ref("");

const orderId = page.url.split("/").pop();

onMounted(async () => {
    try {
        const res = await axios.get(`/api/orders/${orderId}`);
        order.value = res.data;
    } catch (err) {
        error.value = "Failed to load order: " + err.message;
    } finally {
        loading.value = false;
    }
});
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Order Details</h1>
        <div v-if="loading" class="text-gray-500">Loading...</div>

        <div v-else-if="order">
            <p><strong>Order Number:</strong> {{ order.order_number }}</p>
            <p><strong>Status:</strong> {{ order.status }}</p>
            <p><strong>Total:</strong> ${{ order.total_amount }}</p>

            <h2 class="text-xl font-semibold mt-4 mb-2">Items</h2>
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Product</th>
                    <th class="border p-2">Variant</th>
                    <th class="border p-2">Price</th>
                    <th class="border p-2">Qty</th>
                    <th class="border p-2">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in order.items" :key="item.id" class="text-center hover:bg-gray-50">
                    <td class="border p-2">{{ item.product_name }}</td>
                    <td class="border p-2">{{ item.variant_name || '-' }}</td>
                    <td class="border p-2">${{ item.price }}</td>
                    <td class="border p-2">{{ item.quantity }}</td>
                    <td class="border p-2">${{ item.total }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
