import {ref, computed} from 'vue';

const cartItems = ref([]);


export function useCart(){
    const addToCart = (product)=>{
        const existingItem = cartItems.value.find(item => item.id===product.id);
        if(existingItem){
            existingItem.quantity +=1;
        }else {
            cartItems.value.push({...product,quantity:1});
        }
    };

    const removeFromCart = (productId)=>{
        cartItems.value = cartItems.value.filter(item=>item.id!==productId);
    };

    const totalItems = computed(()=>{
        return cartItems.value.reduce((sum,item)=>sum + item.quantity,0);
    });
    const cartTotal = computed(()=>{
        return cartItems.value.reduce((sum,item)=>sum + parseFloat(item.price.replace('$',''))*item.quantity,0).toFixed(2);
    });

    const increaseQuantity = (productId) => {
        const item = cartItems.value.find(item => item.id === productId);
        if (item) {
            item.quantity += 1;
        }
    };

    const decreaseQuantity = (productId) => {
        const item = cartItems.value.find(item => item.id === productId);
        if (item) {
            if (item.quantity > 1) {
                item.quantity -= 1;
            } else {
                // Optional: Remove the item from the cart if quantity is 1 and user decreases it
                removeFromCart(productId);
            }
        }
    };


    const clearCart = ()=>{
        cartItems.value = [];
    }
    return {
        cartItems,
        addToCart,
        removeFromCart,
        totalItems,
        cartTotal,
        clearCart,
        increaseQuantity,
        decreaseQuantity,
    };
}
