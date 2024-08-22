<script setup>
    import Layout from "../../Frontend/Shared/Layout.vue";
    import {useCartStore} from "../../../Store/useCartStore";
    import {onMounted} from 'vue'
    import CartItemCard from '../Modules/CartItemCard.vue'
    import QuantityButton from '../../../components/QuantityButton.vue'
    import {useWishListStore} from "../../../Store/useWishListStore";
    const watchlistStore = useWishListStore();
    const store = useCartStore();
    onMounted(()=>{
        store.initCart();
    })


    const wishListToCart= (item) =>{
        watchlistStore.addToWishList(item);
        store.removeFromCart(item);
        $toast.success("Moved Cart To Wishlist...")
    }

</script>

<template>
    <Layout>
        <div class="container-sm my-5">
            <div class="row">
                <!-- Cart left -->
                <div class="col-xl-8 mb-3 mb-xl-0">
                    <div class="card details-cart-item" v-if="store.getCartItems.length > 0" v-for="item in store.getCartItems" :key="item.id" >
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex col-8">
                                <img class="me-1" :src="item.thumbnail" alt="" width="100">
                                <div class="d-flex flex-column">
                                    <h3 class="text-capitalize text-primary">{{ item.title }}</h3>
                                    <div>
                                        <span>{{ item.sellPrice }} <vue-feather type="x" size="12"/> {{ item.quantity }} = {{ item.sellPrice * item.quantity }} ৳</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-end">
                                <vue-feather type="x" size="15" class="cursor-pointer" @click="store.removeFromCart(item)"/>
                                <QuantityButton :productId="item.id" :maxQty="item.qty" class="mt-1"/>
                                <button class="btn btn-sm btn-primary mt-2" @click="wishListToCart(item)">Move to Wish list</button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center h-100" v-else>
                        Your Cart Is Empty.
                    </div>
                </div>
                <!-- Cart right -->
                <div class="col-xl-4">
                    <div class="border rounded p-3 mb-3">

                        <!-- Offer -->
<!--
                        <h6>Offer</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-8 col-xxl-8 col-xl-12">
                                <input type="text" class="form-control" placeholder="Enter Promo Code" aria-label="Enter Promo Code">
                            </div>
                            <div class="col-4 col-xxl-4 col-xl-12">
                                <div class="d-grid">
                                    <button type="button" class="btn btn-label-primary">Apply</button>
                                </div>
                            </div>
                        </div>
-->


<!--                        <hr class="mx-n3">-->

                        <!-- Price Details -->
                        <h6>Price Details</h6>
                        <dl class="row mb-0">
                            <dt class="col-6 fw-normal">Bag Total</dt>
                            <dd class="col-6 text-end">{{ store.getCartTotalPrice }} ৳</dd>
<!--
                            <dt class="col-6 fw-normal">Coupon Discount</dt>
                            <dd class="col-6 text-success text-end"> -$98.00</dd>

                            <dt class="col-6 fw-normal">Order Total</dt>
                            <dd class="col-6 text-end">$1100.00</dd>-->


<!--                            <dt class="col-6 fw-normal">Vat</dt>
                            <dd class="col-6 text-end">৳ 5.00 </dd>

                            <dt class="col-6 fw-normal">Tax</dt>
                            <dd class="col-6 text-end">৳ 5.00 </dd>-->

                            <hr>

                            <dt class="col-6">Total</dt>
                            <dd class="col-6 fw-semibold text-end mb-0">{{ store.getCartTotalPrice }} ৳</dd>
                        </dl>
                    </div>
                    <div class="d-grid mb-3">
                        <a href="/checkout" v-if="store.getCartLength > 0" class="btn btn-primary btn-next">Place Order here</a>
                        <button v-else disabled="true" class="btn btn-primary btn-next" v-c-tooltip="'Add Product On Your Cart Before Plase Order'">Place Order here</button>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>



<style scoped>

</style>
