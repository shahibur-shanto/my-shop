<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import 'swiper/css'
import { Autoplay } from 'swiper/modules'
import AppLayout from "@/layouts/AppLayout.vue";
import { Link, usePage, router } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'
import { useCart } from '@/composables/useCart'

const page = usePage()
const user = computed(() => page.props.auth?.user)


const {  cartOpen,  addToCart,  fetchCart} = useCart(user)

onMounted(() => {
    if (user.value) {
        fetchCart()
    }
})


const handleAddToCart = async (product, quantity = 1) => {

    if (!user.value) {
        router.get('/login');
        return;
    }

await addToCart(product, quantity);
    cartOpen.value = true;
};

defineProps({
    categories: Array,
    new_arrivals: Array,
})
</script>

<template>
    <AppLayout>
        <!-- 🏠 Hero Section -->
        <section class="relative h-[500px] md:h-[600px] w-full overflow-hidden">
            <Swiper :modules="[Autoplay]" :autoplay="{ delay: 3000 }" loop slides-per-view="1" class="h-full w-full">
                <SwiperSlide
                    v-for="(slide, index) in [
            { bg: 'https://picsum.photos/seed/a/1200/600', title: 'Welcome to NoumiMart', subtitle: 'Best products at great prices' },
            { bg: 'https://picsum.photos/seed/b/1200/600', title: 'Discover Deals', subtitle: 'Amazing offers every week' }
          ]"
                    :key="index">
                    <div class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url(${slide.bg})` }"></div>
                    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white">
                        <h1 class="text-5xl font-extrabold mb-4">{{ slide.title }}</h1>
                        <p class="text-lg mb-6">{{ slide.subtitle }}</p>
                    </div>
                </SwiperSlide>
            </Swiper>
        </section>

        <!-- 🛍 Categories -->
        <section class="container mx-auto py-12">
            <h2 class="text-2xl font-bold mb-6 text-center">Shop by Category</h2>
            <div class="flex flex-wrap justify-center gap-8">
                <div
                    v-for="category in categories"
                    :key="category.id"
                    class="bg-white rounded-lg shadow-md p-1 flex flex-col items-center w-56">
                    <img :src="category.image" alt="category" class="rounded mb-2 w-full h-40 object-cover" />
                    <h3 class="font-bold text-lg text-center">{{ category.name }}</h3>
                </div>
            </div>
        </section>

        <!-- 🆕 New Arrivals -->
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

    </AppLayout>
</template>
