<script setup>
    import {useCartStore} from "../../../Store/useCartStore";
    import {onMounted} from "vue";
    const store = useCartStore();

    onMounted(()=>{
        store.initCart();
    })

    const removeItem = (id) =>{
        console.log(id)
    }


</script>
<template>
    <a class="nav-link" href="#" data-bs-toggle="dropdown">
        <vue-feather type="shopping-cart"/>
        <span class="badge rounded-pill bg-primary badge-up cart-item-count">
            {{ store.getCartLength }}
        </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
        <li class="dropdown-menu-header">
            <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 me-auto">My Cart</h4>
                <div class="badge rounded-pill badge-light-primary">{{ store.getCartLength }} Items</div>
            </div>
        </li>
        <li class="scrollable-container media-list" v-for="item in store.getCartItems" :key="item.id">
            <div class="list-item align-items-center">
                <img class="d-block rounded me-1" :src="item.thumbnail" alt="donuts" width="62">
                <div class="list-item-body flex-grow-1">
                    <vue-feather class="ficon cart-item-remove" type="x" @click="store.removeFromCart(item)"/>
                    <div class="media-heading">
                        <h6 class="cart-item-title">
                            <a class="text-body"  :href="`${$page.props.auth.MAIN_URL}/product/single-product/${item.slug}`">{{ item.title }}</a>
                        </h6>
                        <small class="cart-item-by">
                            <vue-feather type="x" size="10"/>
                            <span class="fs-6">{{ item.quantity }}</span>
                        </small>
                    </div>
                    <h5 class="cart-item-price">৳ {{ item.sellPrice * item.quantity }}</h5>
                </div>
            </div>
        </li>

        <li class="dropdown-menu-footer">
            <div class="d-flex justify-content-between mb-1">
                <h6 class="fw-bolder mb-0">Total:</h6>
                <h6 class="text-primary fw-bolder mb-0">৳ {{ store.getCartTotalPrice }}</h6>
            </div>
            <a class="btn btn-primary w-100" :href="$page.props.auth.MAIN_URL+'/cart-details'">Checkout</a>
        </li>
    </ul>
</template>



<style scoped>

</style>
