<script setup>
import { Link,usePage,router} from '@inertiajs/vue3';
import {computed} from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import { Navigation, Autoplay } from 'swiper/modules';




const page = usePage()
const user = computed(() => page.props.auth.user)

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
        <nav class="bg-green-100 shadow-md">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <Link href="/" class="text-2xl font-bold tracking-tight py-2 px-4"><span
                    class="bg-clip-text tracking-wider text-transparent bg-gradient-to-r from-orange-500 via-pink-500 to-sky-500"
                    aria-label="NoumiMart"
                >NoumiMart</span></Link>
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
                            :href="route('profile.edit')"
                            as="button"
                            class="px-4 py-2 mr-1 bg-red-600 text-white rounded hover:bg-red-700 cursor-pointer"
                        >
                            Profile
                        </Link>

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
        <section class="relative h-[600px] w-full overflow-hidden">
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






<!--        <section class="relative h-[600px] flex items-center justify-center text-center overflow-hidden">-->
<!--            &lt;!&ndash; Background Carousel &ndash;&gt;-->
<!--            <Swiper-->
<!--                :modules="[Autoplay]"-->
<!--                :autoplay="{ delay: 4000 }"-->
<!--                loop-->
<!--                slides-per-view="1"-->
<!--                class="absolute inset-0 h-full w-full"-->
<!--            >-->
<!--                <SwiperSlide v-for="(img, i) in bgSlides" :key="i">-->
<!--                    <div-->
<!--                        :style="{ backgroundImage: `url(${img})` }"-->
<!--                        class="h-full w-full bg-center bg-cover transition duration-1000"-->
<!--                    ></div>-->
<!--                </SwiperSlide>-->
<!--            </Swiper>-->

<!--            &lt;!&ndash; Overlay for darker effect &ndash;&gt;-->
<!--            <div class="absolute inset-0 bg-black bg-opacity-40"></div>-->

<!--            &lt;!&ndash; Static Text & Button &ndash;&gt;-->
<!--            <div class="relative z-10 text-white px-6">-->
<!--                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">-->
<!--                    Welcome to-->
<!--                    <span-->
<!--                        class="tracking-wider bg-clip-text text-transparent bg-gradient-to-r from-orange-500 to-sky-50"-->
<!--                        aria-label="NoumiMart"-->
<!--                    >-->
<!--          NoumiMart-->
<!--        </span>-->
<!--                </h1>-->
<!--                <p class="text-lg mb-6">Best products at the best prices. Shop now!</p>-->
<!--                <Link href="#" class="px-6 py-3 bg-white text-blue-600 font-bold rounded hover:bg-gray-200">-->
<!--                    Shop Now-->
<!--                </Link>-->
<!--            </div>-->
<!--        </section>-->
<!--        -->







<!--        <section class="bg-blue-600 text-white py-20">-->
<!--            <div class="container mx-auto text-center">-->
<!--                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">-->
<!--                    Welcome to-->
<!--                    <span-->
<!--                        class="tracking-wider bg-clip-text text-transparent bg-gradient-to-r from-orange-500 to-sky-50"-->
<!--                        aria-label="NoumiMart"-->
<!--                    >-->
<!--    NoumiMart-->
<!--  </span>-->
<!--                </h1>-->
<!--                <p class="text-lg mb-6">Best products at the best prices. Shop now!</p>-->
<!--                <Link href="#" class="px-6 py-3 bg-white text-blue-600 font-bold rounded hover:bg-gray-200">Shop Now</Link>-->
<!--            </div>-->
<!--        </section>-->

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
