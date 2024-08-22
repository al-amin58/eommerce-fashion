import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart',{
    state: () => ({
        items: []
    }),
    actions: {
        addToCart(item) {
            const existingItem = this.items.find(i => i.id === item.id);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                this.items.push({ ...item, quantity: 1 });
            }
            localStorage.setItem('cart', JSON.stringify(this.items));
        },
        removeFromCart(item) {
            const index = this.items.indexOf(item);
            if (index > -1) {
                this.items.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(this.items));
            }
        },
        incrementQuantity(item) {
            const existingItem = this.items.find(i => i.id === item.id);
            if (existingItem) {
                existingItem.quantity += 1;
                localStorage.setItem('cart', JSON.stringify(this.items));
            }
        },
        decrementQuantity(item) {
            const existingItem = this.items.find(i => i.id === item.id);
            if (existingItem) {
                if (existingItem.quantity > 1) {
                    existingItem.quantity -= 1;
                    localStorage.setItem('cart', JSON.stringify(this.items));
                } else {
                    this.removeFromCart(item);
                }
            }
        },
        clearCart() {
            this.cart = [];
            localStorage.removeItem('cart');
        },
        initCart() {
            const storedCart = localStorage.getItem('cart');
            if (storedCart) {
                this.items = JSON.parse(storedCart);
            }
        }
    },
    getters: {
        cartItems: state => state.items,
        totalPrice: state => state.items.reduce((total, item) => total + item.price * item.quantity, 0)
    },
});
