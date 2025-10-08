<script setup>
import { Link, usePage, router } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'
import { useCart } from '@/composables/useCart'

const page = usePage()
const user = computed(() => page.props.auth?.user)
const menuOpen = ref(false)

const { cartItems, cartOpen, clearCart, addToCart, increaseQuantity, decreaseQuantity, removeFromCart, fetchCart, totalItems, cartTotal } = useCart(user)

onMounted(() => {
    if (user.value) {
        fetchCart()
    }
})

const logout = () => {
    router.post(route('logout'))
    clearCart()
}
</script>

<template>
    <div class="min-h-screen flex flex-col bg-gray-50">
        <!-- 🌿 Navbar -->
        <nav class="bg-green-100 shadow-md relative">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <Link :href="route('home')" class="text-2xl font-bold">
          <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-500 via-pink-500 to-sky-500">
            NoumiMart
          </span>
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-4">
                    <Link :href="route('home')" class="text-gray-700 hover:text-gray-900">Home</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Shop</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">About</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Contact</Link>
                   <template v-if='user'>
                       <Link :href="route('orders.index')" class="text-gray-700 hover:text-gray-900">My Order</Link>
                   </template>

                </div>

                <!-- Auth Buttons + Cart -->
                <div class="hidden md:flex items-center space-x-3">
                    <div class="relative">
                        <button @click="cartOpen = !cartOpen" class="pr-4 text-gray-700 hover:text-gray-900 text-2xl">
                            🛒
                        </button>
                        <span
                            v-if="totalItems > 0"
                            class="absolute -top-2 -right-1.5 bg-red-600 text-white rounded-full text-xs w-6 h-6 flex items-center justify-center">
              {{ totalItems }}
            </span>
                    </div>

                    <template v-if="user">
                        <span class="mr-2 text-gray-700 font-semibold">Hi, {{ user.name }}</span>
                        <Link :href="route('profile.edit')" as="button" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Profile</Link>
                        <button @click="logout" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Log out</button>
                    </template>

                    <template v-else>
                        <Link :href="route('login')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Login</Link>
                        <Link :href="route('register')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Sign up</Link>
                    </template>
                </div>

                <!-- Mobile Hamburger -->
                <button @click="menuOpen = !menuOpen" class="md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div v-show="menuOpen" class="md:hidden bg-green-100 absolute top-full left-0 w-full shadow-md z-10">
                <div class="flex flex-col px-6 py-4 space-y-2">
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Home</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Shop</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">About</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Contact</Link>
                    <button @click="cartOpen = !cartOpen" class="text-gray-700 hover:text-gray-900">
                        Cart ({{ totalItems }})
                    </button>
                </div>
            </div>
        </nav>

        <!-- 📄 Page Content -->
        <main class="flex-grow">
            <slot />
        </main>

        <!-- 🌙 Footer -->
        <footer class="bg-[#031a17] text-gray-300 pt-10 pb-4 mt-auto">
            <div class="container mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-3">Noumi Mart</h3>
                    <p class="text-sm mb-4">
                        Your one-stop shop for paints, crafts, stationery, and kids’ art.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gray-800 hover:bg-green-600 p-2 rounded-full">
                            <i class="fab fa-facebook-f">Facebook</i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-green-600 p-2 rounded-full">
                            <i class="fab fa-whatsapp">Whatsapp </i>
                        </a>
                    </div>
                </div>

                <!-- About Links -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-3">About Noumi Mart</h4>
                    <ul class="space-y-2 text-sm">
                        <li><Link href="#" class="hover:text-white">About Us</Link></li>
                        <li><Link href="#" class="hover:text-white">Contact Us</Link></li>
                        <li><Link href="#" class="hover:text-white">Terms & Conditions</Link></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-3">Categories</h4>
                    <ul class="space-y-2 text-sm">
                        <li><Link href="#" class="hover:text-white">School Stationery</Link></li>
                        <li><Link href="#" class="hover:text-white">Calculator</Link></li>
                        <li><Link href="#" class="hover:text-white">Kids Zone & Toys</Link></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-3">Store Information</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 12.414a4 4 0 015.657-5.657l3.243 3.243a4 4 0 01-5.657 5.657z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 12a9 9 0 0118 0c0 5.523-4.477 10-10 10S6 17.523 6 12z"/>
                            </svg>
                            <span>Mirpur-13<br> Dhaka 1216</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5h2l3.6 7.59L5.25 18a1 1 0 001.75 1h10a1 1 0 001-1l1.35-5.41L21 5H3z"/>
                            </svg>
                            <span>Call us: 01717464016</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Divider -->
            <div class="border-t border-gray-700 mt-8 mb-4"></div>

            <!-- Bottom Bar -->
            <div class="container mx-auto px-6 flex justify-center items-center text-sm text-gray-400">
                <p class="text-center">
                    2025 Copyright By <span class="text-white">NoumiMart</span>. All Rights Reserved.
                </p>
            </div>
        </footer>


        <!-- Cart Slide-over -->
            <transition name="slide-fade">
                <div v-if="cartOpen" class="fixed inset-0 z-50 flex justify-end">
                    <!-- Clickable blur layer -->
                    <div @click="cartOpen = false" class="absolute inset-0 cursor-pointer"></div>

                    <!-- Cart panel -->
                    <div class="relative w-full md:w-96 h-full bg-white shadow-2xl flex flex-col transition-transform duration-300">
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Your Cart</h3>
                            <button @click="cartOpen = false" class="text-gray-500 hover:text-gray-700 focus:outline-none">✕</button>
                        </div>

                        <div class="flex-grow overflow-y-auto p-4 space-y-4">
                            <div v-if="cartItems.length === 0" class="text-center text-gray-500 mt-12">
                                Your cart is empty.
                            </div>
                            <div v-for="item in cartItems" :key="item.id" class="flex items-center space-x-4 border-b pb-4">
                                <img :src="`http://127.0.0.1:8000/storage/${item.image}`" :alt="item.name"
                                     class="w-16 h-16 object-cover rounded" />
                                <div class="flex-grow">
                                    <h4 class="font-medium">{{ item.name }}</h4>
                                    <p class="text-gray-800 font-semibold">${{ (parseFloat(item.price.replace('$', '')) * item.quantity).toFixed(2) }}</p>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <button @click="decreaseQuantity(item)" class="bg-gray-200 text-gray-700 rounded-full w-6 h-6 flex items-center justify-center hover:bg-gray-300 transition-colors">-</button>
                                    <span class="text-sm font-medium">{{ item.quantity }}</span>
                                    <button @click="increaseQuantity(item)" class="bg-gray-200 text-gray-700 rounded-full w-6 h-6 flex items-center justify-center hover:bg-gray-300 transition-colors">+</button>
                                </div>

                                <button @click="removeFromCart(item.id)" class="text-red-500 hover:text-red-700">🗑</button>
                            </div>
                        </div>

                        <div v-if="cartItems.length > 0" class="p-4 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-bold">Total:</span>
                                <span class="text-lg font-bold text-blue-600">${{ cartTotal }}</span>
                            </div>
                            <button @click="router.get(route('checkout.index'))" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                Proceed to Checkout
                            </button>
                        </div>
                    </div>
                </div>
            </transition>
    </div>
</template>

<style>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: transform 0.3s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(100%);
}
</style>
