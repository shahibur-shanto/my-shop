<script setup>
import { Link } from "@inertiajs/vue3";

const menuItems = [
    { name: "Dashboard", icon: "📊", route: route("admin.dashboard") },
    { name: "Users", icon: "👤", route: "#" },
    { name: "Products", icon: "📦", route: "#" },
    { name: "Orders", icon: "🛒", route: "#" },
    { name: "Settings", icon: "⚙️", route: "#" },
];
</script>

<template>
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md p-5">
            <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
            <nav class="space-y-2">
                <Link
                    v-for="item in menuItems"
                    :key="item.name"
                    :href="item.route"
                    class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200"
                >
                    <span>{{ item.icon }}</span>
                    <span>{{ item.name }}</span>
                </Link>
            </nav>
        </aside>

        <!-- Page Content -->
        <main class="flex-1 p-6">
            <slot />
        </main>
    </div>
</template>
