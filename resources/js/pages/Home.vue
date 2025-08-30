<script setup>
import { Link,usePage,router} from '@inertiajs/vue3';
import {computed} from 'vue';
const page = usePage()
const user = computed(() => page.props.auth.user)

const logout = () => {
    router.post(route('logout'));
};


const featuredProducts = [
    { id: 1, name: 'Product One', price: '$25', image: 'https://via.placeholder.com/150' },
    { id: 2, name: 'Product Two', price: '$30', image: 'https://via.placeholder.com/150' },
    { id: 3, name: 'Product Three', price: '$15', image: 'https://via.placeholder.com/150' },
    { id: 4, name: 'Product Four', price: '$50', image: 'https://via.placeholder.com/150' },
];
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Navbar -->
        <nav class="bg-white shadow-md">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <Link href="/" class="text-2xl font-bold text-gray-800">MyShop</Link>
                <div class="space-x-4">
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Home</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Shop</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">About</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Contact</Link>
                </div>
                <div>
                    <template v-if="user">
                        <span class="mr-4 text-gray-700 font-semibold">Hi, {{ user.name }}</span>

                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 cursor-pointer"
                        >
                            Log out
                        </Link>
                    </template>

                    <template v-else>
                        <Link :href="route('login')" class="px-4 mx-2 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Login</Link>
                        <Link :href="route('register')" class="px-4 mx-2 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Sign up</Link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-blue-600 text-white py-20">
            <div class="container mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to MyShop</h1>
                <p class="text-lg mb-6">Best products at the best prices. Shop now!</p>
                <Link href="#" class="px-6 py-3 bg-white text-blue-600 font-bold rounded hover:bg-gray-200">Shop Now</Link>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="container mx-auto py-12">
            <h2 class="text-2xl font-bold mb-6">Featured Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div v-for="product in featuredProducts" :key="product.id" class="bg-white rounded-lg shadow-md p-4">
                    <img :src="product.image" alt="product" class="rounded mb-4">
                    <h3 class="font-bold text-lg">{{ product.name }}</h3>
                    <p class="text-gray-700">{{ product.price }}</p>
                    <Link href="#" class="mt-2 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add to Cart</Link>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="container mx-auto py-12">
            <h2 class="text-2xl font-bold mb-6">Featured Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div v-for="product in featuredProducts" :key="product.id" class="bg-white rounded-lg shadow-md p-4">
                    <img :src="product.image" alt="product" class="rounded mb-4">
                    <h3 class="font-bold text-lg">{{ product.name }}</h3>
                    <p class="text-gray-700">{{ product.price }}</p>
                    <Link href="#" class="mt-2 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add to Cart</Link>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="container mx-auto py-12">
            <h2 class="text-2xl font-bold mb-6">Featured Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div v-for="product in featuredProducts" :key="product.id" class="bg-white rounded-lg shadow-md p-4">
                    <img :src="product.image" alt="product" class="rounded mb-4">
                    <h3 class="font-bold text-lg">{{ product.name }}</h3>
                    <p class="text-gray-700">{{ product.price }}</p>
                    <Link href="#" class="mt-2 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add to Cart</Link>
                </div>
            </div>
        </section>


        <!-- Featured Products -->
        <section class="container mx-auto py-12">
            <h2 class="text-2xl font-bold mb-6">Featured Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div v-for="product in featuredProducts" :key="product.id" class="bg-white rounded-lg shadow-md p-4">
                    <img :src="product.image" alt="product" class="rounded mb-4">
                    <h3 class="font-bold text-lg">{{ product.name }}</h3>
                    <p class="text-gray-700">{{ product.price }}</p>
                    <Link href="#" class="mt-2 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add to Cart</Link>
                </div>
            </div>
        </section>


        <!-- Featured Products -->
        <section class="container mx-auto py-12">
            <h2 class="text-2xl font-bold mb-6">Featured Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div v-for="product in featuredProducts" :key="product.id" class="bg-white rounded-lg shadow-md p-4">
                    <img :src="product.image" alt="product" class="rounded mb-4">
                    <h3 class="font-bold text-lg">{{ product.name }}</h3>
                    <p class="text-gray-700">{{ product.price }}</p>
                    <Link href="#" class="mt-2 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add to Cart</Link>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-200 py-6 mt-12">
            <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
                <p>&copy; 2025 MyShop. All rights reserved.</p>
                <div class="space-x-4 mt-4 md:mt-0">
                    <Link href="#" class="hover:text-white">Facebook</Link>
                    <Link href="#" class="hover:text-white">Twitter</Link>
                    <Link href="#" class="hover:text-white">Instagram</Link>
                </div>
            </div>
        </footer>
    </div>
</template>
