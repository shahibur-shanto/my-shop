
import { ref, computed } from 'vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';

axios.defaults.withCredentials = true; // Make sure session cookies are sent

const cartItems = ref([]);
const cartOpen = ref(false);

export function useCart(user) {


    // Fetch cart from backend
    const fetchCart = async () => {
        try {
            const res = await axios.get('/api/cart');
            cartItems.value = res.data.cartItems;
        } catch (error) {
            console.error('Failed to fetch cart:', error);
        }
    };

    // Add product to cart
    const addToCart = async (product, quantity = 1) => {
        if (!user.value) {
            router.get('/login'); // Redirect to login if not logged in
            return;
        }

        try {

            await axios.post('/api/cart/add', {
                product_id: product.id,
                quantity,
                variant_id: product.variant_id || null,
            });
            await fetchCart();
            cartOpen.value = true; // Open cart after adding
        } catch (error) {
            console.error('Failed to add to cart:', error);
        }
    };

    // Remove item
    const removeFromCart = async (itemId) => {
        try {
            await axios.delete(`/api/cart/remove/${itemId}`);
            await fetchCart();
        } catch (error) {
            console.error('Failed to remove from cart:', error);
        }
    };

    // Increase quantity
    const increaseQuantity = async (item) => {
        try {
            await axios.put(`/api/cart/update/${item.id}`, {
                quantity: item.quantity + 1,
            });
            await fetchCart();
        } catch (error) {
            console.error('Failed to increase quantity:', error);
        }
    };

    // Decrease quantity
    const decreaseQuantity = async (item) => {
        try {
            if (item.quantity > 1) {
                await axios.put(`/api/cart/update/${item.id}`, {
                    quantity: item.quantity - 1,
                });
            } else {
                await removeFromCart(item.id);
            }
            await fetchCart();
        } catch (error) {
            console.error('Failed to decrease quantity:', error);
        }
    };

    // Clear entire cart
    const clearCart = async () => {
        for (const item of cartItems.value) {
            await removeFromCart(item.id);
        }
        cartItems.value = []
        cartTotal.value = 0 // Reset cart count
    };

    // Computed properties
    const totalItems = computed(() =>
        cartItems.value.reduce((sum, item) => sum + item.quantity, 0)
    );

    const cartTotal = computed(() =>
        cartItems.value
            .reduce((sum, item) => sum + parseFloat(item.price) * item.quantity, 0)
            .toFixed(2)
    );

    return {
        cartItems,
        cartOpen,
        fetchCart,
        addToCart,
        removeFromCart,
        increaseQuantity,
        decreaseQuantity,
        clearCart,
        totalItems,
        cartTotal,
    };
}
