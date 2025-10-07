<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import AppLayout from "@/layouts/AppLayout.vue";

const orders = ref([]);
const loading = ref(true);

onMounted(async () => {
    try {
        const res = await axios.get("/api/orders", {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
        });
        orders.value = res.data;
    } catch (error) {
        console.error("Failed to load orders:", error);
    } finally {
        loading.value = false;
    }
});
</script>

<template>
    <AppLayout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">My Orders</h1>
        <div v-if="loading" class="text-gray-500">Loading...</div>
        <div v-else>
            <div v-if="orders.length === 0" class="text-gray-500">No orders yet.</div>
            <table v-else class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Order #</th>
                    <th class="border p-2">Items</th>
                    <th class="border p-2">Total</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Date</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="order in orders" :key="order.id" class="text-center hover:bg-gray-50">
                    <td class="border p-2">{{ order.order_number }}</td>
                    <td class="border p-2">{{ order.items_count }}</td>
                    <td class="border p-2">${{ order.total_amount }}</td>
                    <td class="border p-2 capitalize">{{ order.status }}</td>
                    <td class="border p-2">{{ new Date(order.created_at).toLocaleString() }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </AppLayout>
</template>
