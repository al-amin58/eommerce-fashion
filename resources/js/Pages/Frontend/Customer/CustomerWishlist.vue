<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import {ref} from 'vue'
import ProductCard from "../Modules/ProductCard.vue";
import {useWishListStore} from "../../../Store/useWishListStore";
import {useCartStore} from "../../../Store/useCartStore";
import {onMounted} from "vue";
import {Inertia} from "@inertiajs/inertia";
import CustomerLayout from "./Layout.vue";
import Pagination from "../../../components/Pagination.vue";
import Modal from "../../../components/Modal.vue";
import ImageUploader from "../../../components/ImageUploader.vue";
import Products from "../Pages/StarTProducts.vue"
const store = useWishListStore();
const cartStore = useCartStore();
const props = defineProps({
    orders:[]|null,
    success:String|null,
})
const wishListToCart= (item) =>{
    cartStore.addToCart(item);
    store.removeFromWishList(item);
    $toast.success("Moved Wishlist To Cart...")
}



onMounted(()=>{
    store.initWishList();
})

</script>

<template>
    <CustomerLayout>
        <div class="d-flex align-items-center gap-1">
            <a href="/dashboard">
                <vue-feather class="text-black" type="arrow-left"/>
            </a>
            <h1 class="text-black fw-semibold">My Wishlist</h1>
        </div>
        <div class="mt-5">
            <div class="row match-height">
                <p class="text-black fs-4 fw-semibold" v-if="store.getWishListItems.length < 1">
                    Your wishlist is empty
                </p>
                <div v-else class="col-md-4" v-for="item in store.getWishListItems" :key="item.id">
                    <Products :product="item"/>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>



<style lang="sass" scoped>
// Image input
.image-input
    text-aling: center
    input
        display: none
    label
        display: block
        color: #FFF
        background: #000
        padding: .3rem .6rem
        font-size: 115%
        cursor: pointer
        i
            font-size: 125%
            margin-right: .3rem
        &:hover
            i
                animation: shake .35s
    img
        max-width: 175px
        display: none
    span
        display: none
        text-align: center
        cursor: pointer

// animation keyframes
@keyframes shake
    0%
        transform: rotate(0deg)
    25%
        transform: rotate(10deg)
    50%
        transform: rotate(0deg)
    75%
        transform: rotate(-10deg)
    100%
        transform: rotate(0deg)

// other styles
body
    display: flex
    justify-content: center
    align-items: center
    height: 350px
    font-family: calibri

.order-action
    a
        font-size: 15px

</style>
