
<script setup>

import {useWishListStore} from "../../../Store/useWishListStore";
import {onMounted} from "vue";

const store = useWishListStore();


onMounted(()=>{
    store.initWishList();
})

</script>

<template>
    <a class="nav-link" href="#" data-bs-toggle="dropdown">
        <vue-feather type="heart"/>
        <span class="badge rounded-pill bg-danger badge-up">{{ store.getWishListLength }}</span></a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end zindex-1">
        <li class="dropdown-menu-header">
            <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 me-auto">Wish List Items</h4>
                <div class="badge rounded-pill badge-light-primary">{{ store.getWishListLength }} Items</div>
            </div>
        </li>


        <li class="scrollable-container media-list" v-for="item in store.getWishListItems" :key="item.id">
            <div class="list-item align-items-center">
                <img class="d-block rounded me-1" :src="item.thumbnail" alt="donuts" width="62">
                <div class="list-item-body flex-grow-1">
                    <vue-feather class="ficon cart-item-remove" type="x" @click="store.removeFromWishList(item)"/>
                    <div class="media-heading">
                        <h6 class="cart-item-title">
                            <a class="text-body" :href="`${$page.props.auth.MAIN_URL}/product/single-product/${item.slug}`">{{ item.title }}</a><br>
                            <small>by</small>
                            <a class="ms-1" href="#">{{ item.category.title }}</a>
                        </h6>
                    </div>
                    <h5 class="cart-item-price">৳ {{ item.sellPrice }}</h5>
                </div>
            </div>
        </li>
    </ul>
</template>


<style scoped>

</style>
