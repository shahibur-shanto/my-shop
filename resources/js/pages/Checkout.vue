<script setup>
import { onMounted } from 'vue';
import { useCart } from '../composables/useCart';
import { router } from '@inertiajs/vue3';

const { cartItems, fetchCart, cartTotal, clearCart } = useCart();

onMounted(() => {
    fetchCart(); // Load cart from database
});

const placeOrder = () => {
    if (cartItems.value.length === 0) {
        alert('Your cart is empty!');
        return;
    }

    router.post('/checkout', { cart: cartItems.value }, {
        onSuccess: () => {
            clearCart();
            alert('Order placed successfully!');
        },
        onError: () => alert('Something went wrong!'),
    });
};
</script>

<template>
    <div class="container mx-auto py-12">
        <h2 class="text-2xl font-bold mb-4">Checkout</h2>

        <div v-if="cartItems.length === 0" class="text-gray-500">
            Your cart is empty.
        </div>

        <div v-else>
            <div v-for="item in cartItems" :key="item.id" class="flex justify-between mb-2">
                <span>{{ item.product.name }} x {{ item.quantity }}</span>
                <span>${{ (parseFloat(item.product.price) * item.quantity).toFixed(2) }}</span>
            </div>

            <div class="flex justify-between font-bold mt-4">
                <span>Total:</span>
                <span>${{ cartTotal }}</span>
            </div>

            <button @click="placeOrder" class="mt-6 px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700">
                Place Order
            </button>
        </div>
    </div>
</template>


















<!--<script setup>-->
<!--import { ref, computed } from 'vue';-->
<!--import { usePage, Link, router } from '@inertiajs/vue3';-->

<!--const page = usePage();-->
<!--// const cartItems = ref(page.props.cartItems || []);-->

<!--const cartItems = ref(JSON.parse(localStorage.getItem('cart')) || []);-->

<!--const cartTotal = computed(() => {-->
<!--    return cartItems.value-->
<!--        .reduce((sum, item) => sum + parseFloat(item.price.replace('$', '')) * item.quantity, 0)-->
<!--        .toFixed(2);-->
<!--});-->

<!--const placeOrder = () => {-->
<!--    // Send cartItems to server for order processing-->
<!--    // Example using Inertia POST:-->
<!--    // router.post('/checkout', { cart: cartItems.value });-->

<!--    localStorage.removeItem('cart'); // Clear cart after checkout-->
<!--    alert('Order placed successfully!');-->

<!--}-->

<!--// const cartTotal = computed(() => {-->
<!--//     return cartItems.value.reduce((sum, item) => {-->
<!--//         const price = parseFloat(item.price.replace('$','')) || 0;-->
<!--//         return sum + price * item.quantity;-->
<!--//     }, 0).toFixed(2);-->
<!--// });-->
<!--//-->
<!--// const placeOrder = () => {-->
<!--//     router.post(route('checkout.store'));-->
<!--// };-->
<!--</script>-->

<!--<template>-->
<!--    <div class="container mx-auto py-12">-->
<!--        <h1 class="text-3xl font-bold mb-6">Checkout</h1>-->

<!--        <div v-if="cartItems.length === 0" class="text-gray-500">-->
<!--            Your cart is empty.-->
<!--        </div>-->

<!--        <div v-else class="space-y-6">-->
<!--            <div v-for="item in cartItems" :key="item.id" class="flex justify-between items-center border-b pb-2">-->
<!--                <div class="flex items-center space-x-4">-->
<!--                    <img :src="item.image" class="w-16 h-16 object-cover rounded">-->
<!--                    <div>-->
<!--                        <h4 class="font-medium">{{ item.name }}</h4>-->
<!--                        <p class="text-gray-600">{{ item.quantity }} × {{ item.price }}</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <p class="font-semibold">${{ (parseFloat(item.price.replace('$','')) * item.quantity).toFixed(2) }}</p>-->
<!--            </div>-->

<!--            <div class="flex justify-between text-lg font-bold mt-4">-->
<!--                <span>Total:</span>-->
<!--                <span>${{ cartTotal }}</span>-->
<!--            </div>-->

<!--            <button @click="placeOrder" class="w-full mt-4 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">-->
<!--                Place Order-->
<!--            </button>-->

<!--            <Link href="/" class="block mt-2 text-center text-blue-600 hover:underline">-->
<!--                Continue Shopping-->
<!--            </Link>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->
