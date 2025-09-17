<script setup>
import { Link,usePage,router} from '@inertiajs/vue3';
import {computed, ref} from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import { Navigation, Autoplay } from 'swiper/modules';

const page = usePage()
const user = computed(() => page.props.auth.user)

defineProps({
    categories: Array
});

// Hamburger toggle
const menuOpen = ref(false);

const logout = () => {
    router.post(route('logout'));
};


const bgSlides = [
    'https://fastly.picsum.photos/id/866/200/300.jpg?hmac=rcadCENKh4rD6MAp6V_ma-AyWv641M4iiOpe1RyFHeI',
    'https://images.unsplash.com/photo-1707856191983-5f11c95b842b?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    'https://via.placeholder.com/1600x600/3B82F6/FFFFFF?text=Slide+3',
];

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
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Navbar -->
        <nav class="bg-green-100 shadow-md relative">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <!-- Brand -->
                <Link href="/" class="text-2xl font-bold tracking-tight">
          <span
              class="bg-clip-text text-transparent bg-gradient-to-r from-orange-500 via-pink-500 to-sky-500"
              aria-label="NoumiMart"
          >NoumiMart</span>
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-4">
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Home</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Shop</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">About</Link>
                    <Link href="#" class="text-gray-700 hover:text-gray-900">Contact</Link>
                </div>

                <!-- Auth Buttons Desktop -->
                <div class="hidden md:flex items-center space-x-2">
                    <template v-if="user">
                        <span class="mr-2 text-gray-700 font-semibold">Hi, {{ user.name }}</span>
                        <Link :href="route('profile.edit')" as="button"
                              class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Profile</Link>
                        <Link :href="route('logout')" method="post" as="button"
                              class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Log out</Link>
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

                    <template v-if="user">
                        <Link :href="route('profile.edit')" as="button"
                              class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 w-full text-center">Profile</Link>
                        <Link :href="route('logout')" method="post" as="button"
                              class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 w-full text-center">Log out</Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-center">Login</Link>
                        <Link :href="route('register')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-center">Sign up</Link>
                    </template>
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
</template>
