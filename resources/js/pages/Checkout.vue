<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useCart } from '../composables/useCart'
import { router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const user = page.props?.auth?.user || null

const { cartItems, fetchCart, cartTotal, clearCart } = useCart()
const isLoading = ref(false)

// Billing form
const form = ref({
    billing_first_name: '',
    billing_last_name: '',
    billing_email: '',
    billing_phone: '',
    billing_address: '',
    billing_city: '',
    billing_state: '',
    billing_country: '',
    billing_postal_code: '',
    payment_method: 'cod'
})

onMounted(() => {
    fetchCart()

    // Prefill user data if logged in
    if (user) {
        form.value.billing_first_name = user.name?.split(' ')[0] || ''
        form.value.billing_last_name = user.name?.split(' ')[1] || ''
        form.value.billing_email = user.email || ''
    }
})

// Checkout logic
const placeOrder = async () => {
    if (!user) {
        router.get('/login')
        return
    }

    if (cartItems.value.length === 0) {
        alert('Your cart is empty!')
        return
    }

    isLoading.value = true

    try {
        const res = await axios.post('/api/checkout', {
            ...form.value,
        })

        alert(`✅ ${res.data.message}\nOrder No: ${res.data.order_number}`)
        await clearCart()
        router.visit('/') // Redirect to order list page (optional)
    } catch (err) {
        alert('❌ Checkout failed: ' + (err.response?.data?.message || err.message))
    } finally {
        isLoading.value = false
    }
}
</script>

<template>
    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-2xl font-bold mb-4">Checkout</h2>

        <div v-if="cartItems.length === 0" class="text-gray-500">
            Your cart is empty.
        </div>

        <form v-else @submit.prevent="placeOrder" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <input v-model="form.billing_first_name" placeholder="First Name" required class="border p-2 rounded" />
                <input v-model="form.billing_last_name" placeholder="Last Name" required class="border p-2 rounded" />
            </div>
            <input v-model="form.billing_email" placeholder="Email" type="email" required class="border p-2 rounded w-full" />
            <input v-model="form.billing_phone" placeholder="Phone" required class="border p-2 rounded w-full" />
            <input v-model="form.billing_address" placeholder="Address" required class="border p-2 rounded w-full" />
            <div class="grid grid-cols-2 gap-4">
                <input v-model="form.billing_city" placeholder="City" required class="border p-2 rounded" />
                <input v-model="form.billing_state" placeholder="State" required class="border p-2 rounded" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <input v-model="form.billing_country" placeholder="Country" required class="border p-2 rounded" />
                <input v-model="form.billing_postal_code" placeholder="Postal Code" required class="border p-2 rounded" />
            </div>

            <div>
                <label class="block mb-2 font-medium">Payment Method:</label>
                <select v-model="form.payment_method" class="border p-2 rounded w-full">
                    <option value="cod">Cash on Delivery</option>
                    <option value="bkash">Bkash</option>
                </select>
            </div>

            <div class="border-t pt-4 mt-4">
                <div v-for="item in cartItems" :key="item.id" class="flex justify-between mb-2 text-gray-700">
                    <span>{{ item.name }} × {{ item.quantity }}</span>
                    <span>${{ (parseFloat(item.price) * item.quantity).toFixed(2) }}</span>
                </div>

                <div class="flex justify-between font-bold text-lg mt-4">
                    <span>Total:</span>
                    <span>${{ cartTotal }}</span>
                </div>
            </div>

            <button type="submit" :disabled="isLoading"
                    class="w-full py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">
                {{ isLoading ? 'Processing...' : 'Place Order' }}
            </button>
        </form>
    </div>
</template>
