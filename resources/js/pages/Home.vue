<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import { Autoplay } from 'swiper/modules';
import { useCart } from '@/composables/useCart';

const page = usePage();
const user = computed(() => page.props.auth?.user);
onMounted(() => {
    if (user.value) {
        fetchCart(); // fetch cart automatically if logged in
    }
});
defineProps({
    categories: Array,
    new_arrivals: Array,
});

const menuOpen = ref(false);

const logout = () => {
    router.post(route('logout'));
    clearCart();
};

const slides = [
    {
        bg: 'https://fastly.picsum.photos/id/866/200/300.jpg?hmac=rcadCENKh4rD6MAp6V_ma-AyWv641M4iiOpe1RyFHeI',
        title: 'Welcome to',
        brand: 'NoumiMart',
        subtitle: 'Best products at the best prices. Shop now!',
        cta: 'Shop Now',
        link: '#',
    },
    {
        bg: 'https://images.unsplash.com/photo-1707856191983-5f11c95b842b?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        title: 'Discover',
        brand: 'NoumiMart',
        subtitle: 'Amazing deals every week!',
        cta: 'Browse Deals',
        link: '#',
    },
    {
        bg: 'https://plus.unsplash.com/premium_photo-1690303193898-f9c721d0770b?q=80&w=866&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        title: 'Check Out',
        brand: 'NoumiMart',
        subtitle: 'Latest arrivals in our store.',
        cta: 'Explore Now',
        link: '#',
    },
];

const featuredProducts = [
    { id: 1, name: 'Product One', price: '$25', image: 'https://via.placeholder.com/150' },
    { id: 2, name: 'Product Two', price: '$30', image: 'https://via.placeholder.com/150' },
    { id: 3, name: 'Product Three', price: '$15', image: 'https://via.placeholder.com/150' },
    { id: 4, name: 'Product Four', price: '$50', image: 'https://via.placeholder.com/150' },
];

const { cartItems, cartOpen, clearCart, addToCart, increaseQuantity, decreaseQuantity, removeFromCart, fetchCart, totalItems, cartTotal } = useCart(user);

const handleAddToCart = async (product, quantity = 1) => {

    if (!user.value) {
        router.get('/login');
        return;
    }

    await addToCart(product, quantity);
    cartOpen.value = true;
};

</script>

<template>
    <!-- Page wrapper with blur effect -->
    <div :class="{ 'filter blur-sm pointer-events-none': cartOpen }" class="transition-all duration-300 min-h-screen bg-gray-50">
        <!-- Navbar -->
        <nav class="bg-green-100 shadow-md relative">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <Link :href="route('home')" class="text-2xl font-bold tracking-tight">
          <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-500 via-pink-500 to-sky-500" aria-label="NoumiMart">
            NoumiMart
          </span>
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-4">
                    <Link :href="route('home')" class="text-gray-700 hover:text-gray-900">Home</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Shop</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">About</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Contact</Link>
                </div>

                <!-- Auth Buttons Desktop -->
                <div class="hidden md:flex items-center space-x-2">
                    <div class="relative">
                        <button @click="cartOpen = !cartOpen" class="pr-4 text-gray-700 hover:text-gray-900 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </button>
                        <span v-if="totalItems > 0" class="absolute -top-2 -right-1.5 bg-red-600 text-white rounded-full text-xs w-6 h-6 flex items-center justify-center">
              {{ totalItems }}
            </span>
                    </div>
                    <template v-if="user">
                        <span class="mr-2 text-gray-700 font-semibold">Hi, {{ user.name }}</span>
                        <Link :href="route('profile.edit')" as="button" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Profile</Link>
                        <button
                            @click="logout"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                        >
                            Log out
                        </button>
<!--                        <Link :href="route('logout')" method="post" as="button" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Log out</Link>-->
                    </template>
                    <template v-else>
                        <Link :href="route('login')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Login</Link>
                        <Link :href="route('register')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Sign up</Link>
                    </template>
                </div>

                <!-- Hamburger button -->
                <button @click="menuOpen = !menuOpen" class="md:hidden focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" :class="menuOpen ? 'hidden' : 'block'" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" :class="menuOpen ? 'block' : 'hidden'" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div v-show="menuOpen" class="md:hidden bg-green-100 absolute top-full left-0 w-full shadow-md z-10 transition-all duration-300">
                <div class="flex flex-col px-6 py-4 space-y-2">
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Home</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Shop</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">About</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Contact</Link>
                    <button @click="cartOpen = !cartOpen" class="w-full text-left flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Cart ({{ totalItems }})</span>
                    </button>
                </div>
            </div>
        </nav>


                <!-- Hero Section -->
                <section class="relative h-[500px] md:h-[600px] w-full overflow-hidden">
                    <Swiper
                        :modules="[Autoplay]"
                        :autoplay="{ delay: 3000, disableOnInteraction: false }"
                        loop
                        slides-per-view="1"
                        class="h-full w-full"
                    >
                        <SwiperSlide v-for="(slide, index) in slides" :key="index" class="relative h-full w-full">
                            <!-- Background image -->
                            <div
                                class="absolute inset-0 bg-cover bg-center w-full h-full"
                                :style="{ backgroundImage: `url('${slide.bg}')` }"
                            ></div>

                            <!-- Overlay -->
                            <div class="absolute inset-0"></div>

                            <!-- Text centered -->
                            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-6">
                                <h1 class="text-4xl md:text-5xl text-white font-extrabold mb-4 leading-tight">
                                    {{ slide.title }}
                                    <span class="tracking-wider bg-clip-text text-transparent bg-gradient-to-r from-orange-500 to-sky-50">
                      {{ slide.brand }}
                    </span>
                                </h1>
                                <p class="text-lg mb-6">{{ slide.subtitle }}</p>
                                <a
                                    :href="slide.link"
                                    class="px-6 py-3 bg-white text-blue-600 font-bold rounded hover:bg-gray-200"
                                >
                                    {{ slide.cta }}
                                </a>
                            </div>
                        </SwiperSlide>
                    </Swiper>
                </section>


                <section class="container mx-auto py-12">
                    <h2 class="text-2xl font-bold mb-6 text-center">Shop by Category</h2>

                    <div class="flex flex-wrap justify-center gap-8">
                        <div v-for="category in categories" :key="category.id"
                             class="bg-white rounded-lg shadow-md p-1 flex flex-col items-center w-56">
                            <img :src="category.image" alt="category"
                                 class="rounded mb-2 w-full h-40 object-cover">
                            <h3 class="font-bold text-lg text-center">{{ category.name }}</h3>
                        </div>
                    </div>
                </section>

                <!-- Featured Products -->
                <section class="container mx-auto py-12">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-start">New Arrival</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <div v-for="new_arrival in new_arrivals" :key="new_arrival.id" class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
                            <img :src="new_arrival.image" alt="product" class="rounded mb-4 w-full h-40 object-cover">
                            <div class="w-full">
                                <h3 class="font-bold text-lg text-center whitespace-nowrap overflow-hidden text-ellipsis">{{ new_arrival.name }}</h3>
                            </div>
                            <p class="text-gray-700">{{ new_arrival.price }}</p>
        <!--                    <Link href="#" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 w-full text-center">Add to Cart</Link>-->
                            <button @click="handleAddToCart(new_arrival)" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 w-full text-center cursor-pointer">Add to Cart</button>
                        </div>
                    </div>
                </section>






                <!-- Featured Products -->
                <section class="container mx-auto py-12">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-center">Featured Products</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <div v-for="product in featuredProducts" :key="product.id" class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
                            <img :src="product.image" alt="product" class="rounded mb-4 w-full h-40 object-cover">
                            <h3 class="font-bold text-lg text-center">{{ product.name }}</h3>
                            <p class="text-gray-700">{{ product.price }}</p>
                            <Link href="#" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 w-full text-center">Add to Cart</Link>
                        </div>
                    </div>
                </section>

                <!-- Footer -->
                <footer class="bg-gray-800 text-gray-200 py-6 mt-12">
                    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center text-center md:text-left">
                        <p>&copy; 2025 NoumiMart. All rights reserved.</p>
                        <div class="flex space-x-4 mt-4 md:mt-0 justify-center md:justify-start">
                            <Link href="#" class="hover:text-white">Facebook</Link>
                            <Link href="#" class="hover:text-white">Twitter</Link>
                            <Link href="#" class="hover:text-white">Instagram</Link>
                        </div>
                    </div>
                </footer>
            </div>



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
</template>

<style>
/* Slide in from right animation */
.slide-fade-enter-active {
    transition: transform 0.3s ease;
}
.slide-fade-leave-active {
    transition: transform 0.3s ease;
}
.slide-fade-enter-from {
    transform: translateX(100%);
}
.slide-fade-enter-to {
    transform: translateX(0%);
}
.slide-fade-leave-from {
    transform: translateX(0%);
}
.slide-fade-leave-to {
    transform: translateX(100%);
}
</style>
