
<script setup>
import {computed, onMounted, ref, watch} from "vue";
import Modal from "../../../components/Modal.vue";
import Gallery from "../Modules/Gallery.vue";
import {useWishListStore} from "../../../Store/useWishListStore.js";
import {useCartStore} from "../../../Store/useCartStore";
import {useData} from "../../../Composables/useData";
import debounce from "lodash/debounce";
import {Inertia} from "@inertiajs/inertia";

const store = useCartStore();
const watchlistStore = useWishListStore();
const data = useData();
const showProductDetails =()=>document.getElementById(props.product.slug).$vb.modal.show()


    onMounted(() =>{
        store.initCart();
        watchlistStore.initWishList();
    })
    const props = defineProps({
        product:Object|null,
        color:Object|null,
        discountData:[]|null,
    })

    const currentSlide = ref(null)
    const sizeRadio = ref(false)
    const breakpoints = {
        700: {
            itemsToShow: 3,
            snapAlign: 'end',
        },
        1024: {
            itemsToShow: 5,
            snapAlign: 'start'
        }
    }

    const images = computed(() =>{
        let images = [];
        for (let i = 0; i< JSON.parse(props.product.images).length; i++){
            images.push("/storage/"+JSON.parse(props.product.images)[i])
        }
        images.push(props.product.thumbnail)
        return images;
    })

    const cartSize = ref(null);
    const selectSize = (event) => cartSize.value = event.target.value;


    const initCart = ref(1);
    const increment = () => initCart.value = initCart.value + 1;
    const decrement = () =>{
        if(initCart.value > 1){
            initCart.value = initCart.value - 1;
        }
    }


    const addToCart = (product) =>{
        // alert(product)
        let sellPrice = product?.discount > 0  ? product?.discount : product?.price;
        store.addToCart({...product, quantity:initCart.value, sellPrice:sellPrice})
        $toast.success("Added to cart successful.")


    }
    const isInCart = computed(() =>{
        return store.cart.find(item => item.id === props.product?.id)?.quantity
    })

    const addToWishList = (product) =>{
        if (discountPrice.value){
            if(cartSize.value !== null){
                watchlistStore.addToWishList({...product, quantity:1, size:cartSize, sellPrice:discountPrice.value})
            }else{
                $toast.warning("Please chose first your needed size...")
            }
        }else{
            if(cartSize.value !== null){
                watchlistStore.addToWishList({...product, quantity:1, size:cartSize, sellPrice:product.price })
            }else{
                $toast.warning("Please chose first your needed size...")
            }
        }
    }


</script>


<template>
    <div class="card offer border-0 single-product-card m-0 rounded-0">
        <a :href="`/product/single-product/${props.product.slug}`">
            <img class="card-img-top w-100 star-pro-img" :src="props.product.thumbnail" alt="">
        </a>
        <div class="card-body" @click="showProductDetails">
            <div class="card-product-details card-text d-flex flex-column text-left">
                <h5 class="text-black text-capitalize product-title">
                    <a class="d-md-none d-block text-black" :href="`/product/single-product/${props.product.slug}`">
                        {{ props.product?.title.length > 20 ? props.product?.title?.slice(0, 20) : props.product?.title }}...
                    </a>

                    <a class="d-none d-lg-block text-black" :href="`/product/single-product/${props.product.slug}`">
                        {{ props.product?.title.length > 50 ? props.product?.title?.slice(0, 50) : props.product?.title }}...
                    </a>
                </h5>
            </div>
        </div>
        <div class="card-footer px-lg-2 border-0">
            <div class="d-flex justify-content-between gap-2">
                <div class="d-flex align-items-center">
                    <h4 class="fw-bold text-danger product-price">{{ product.discount > 0 ? product.discount : product.price }} ৳</h4>
                    <s class="fs-5 product-price text-black" v-if="product.discount > 0">{{ product.price }} ৳</s>
                </div>
                <button @click="addToCart(product)"  class="sm-cart-btn btn-primary d-flex align-items-center border-0 rounded shadow-none" style="padding: 5px;margin-bottom: 6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 32 32"><circle cx="10" cy="28" r="2" fill="#fff"/><circle cx="24" cy="28" r="2" fill="#fff"/><path fill="#fff" d="M4.98 2.804A1 1 0 0 0 4 2H0v2h3.18l3.84 19.196A1 1 0 0 0 8 24h18v-2H8.82l-.8-4H26a1 1 0 0 0 .976-.783L29.244 7h-2.047l-1.999 9H7.62Z"/><path fill="#fff" d="M18 6V2h-2v4h-4v2h4v4h2V8h4V6z"/></svg>
                </button>
            </div>
        </div>
    </div>

</template>
<style scoped>
.offer {
    box-shadow: 0 1px 1px rgba(0,0,0,.1) !important;
}
.offer .card-body{
    border-top: 5px solid #f4faff;
}
.card-product-details h5 a:hover{
    color:red;
    text-decoration:underline;
}
</style>
