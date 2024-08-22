
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

    // const discountPrice = computed(()=>{
    //     if (props.discountData?.discount_price && props.discountData?.discount_type){
    //         return data.discountPrice(props.product.price, props.discountData.discount_price, props.discountData.discount_type);
    //     }else{
    //         return false;
    //     }
    // })

    const cartSize = ref(null);
    const selectSize = (event) => cartSize.value = event.target.value;
    const addToCart = () => store.addToCart({...props.product, quantity:1})

    const isInCart = computed(() =>{
        return store.cart.find(item => item.id === props.product.id)?.quantity
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
    <div class="card offer border-0">
        <div class="card-body" @click="showProductDetails">
            <img class="card-img-top" :src="props.product.thumbnail" alt="">
            <div class="card-product-details card-text d-flex flex-column align-items-center text-center">
                <p class="p-0 m-0">{{ props.product?.title?.slice(0, 30) }}</p>
                <p class="p-0 m-0">{{ props.product.unit }}</p>
                <p class="p-0 m-0">{{ props.product?.price }}</p>
            </div>
        </div>

        <div class="card-footer bg-primary">
            <button v-if="isInCart === undefined || isInCart<=0 " class="border-0 bg-transparent text-white" @click="addToCart">Add To Cart</button>
            <div v-else class="d-flex align-items-center justify-content-between cart-buttons">
                <span class="action" @click="store.incrementQty(props.product.id)">+</span>
                {{ isInCart }}
                <span class="action" @click="store.decrementQty(props.product.id)">-</span>
            </div>
        </div>

        <a>
            <div v-if="isInCart" class="offer-overlay" >
                <p class="d-flex text-center flex-column fs-4" @click="store.incrementQty(props.product.id)"
                   :disabled="isInCart === props.product.qty" >
                    <span>{{ isInCart }}</span>
                    Items in you bag
                </p>
                <a
                    @click="showProductDetails"
                    class="offer-card-bottom-button">Product Details</a>
            </div>

            <div v-else class="offer-overlay">
                <p @click="addToCart">Add To Bag</p>
                <a @click="showProductDetails" class="offer-card-bottom-button">Product Details</a>
            </div>
        </a>
    </div>


    <Modal :id="props.product.slug" title="" v-vb-is:modal size="lg">
        <div class="row mx-2 mb-3">
            <div class="col-12 col-md-5">
                <div class="row flex-column">
                    <img :src="props.product.thumbnail" alt="">
                </div>
            </div>
            <div class="col-12 col-md-7">
                <p class="text-capitalize text-black fs-4 p-0 modal-product-title text-center" v-text="product.title"></p>

                <p class="text-capitalize text-black-50 fs-4 p-0 modal-product-title text-center">{{ product.unit }}</p>

                <div class="ecommerce-details-price d-flex flex-wrap mt-1 align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <h2>{{product.discount ? product.discount : product.price }}</h2>
                        <s class="fs-5" v-if="product.discount">{{ product.price }}</s>
                    </div>
                    <div>
                        <div class="p-1 bg-primary text-white discount-price-show" v-if="product.discount">{{ product.price - product.discount }} Off</div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row pt-1">
                    <button v-if="isInCart === undefined" @click="addToCart(product)"  class="btn btn-primary btn-cart me-0 me-sm-1 mb-1 mb-sm-0 d-flex align-items-center">
                        <vue-feather type="shopping-cart" class="me-50"/>
                        <span class="add-to-cart text-white">{{"Add to cart"}}</span>
                    </button>
                    <button v-else @click="store.incrementQty(product.id)"
                            :disabled="isInCart === product.qty"
                            class="btn btn-primary btn-cart me-0 me-sm-1 mb-1 mb-sm-0 d-flex align-items-center">
                        <vue-feather type="shopping-cart" class="me-50"/>
                        <span class="add-to-cart">{{ isInCart+" Item In Cart" }}</span>
                    </button>
                </div>
                <p class="card-text mt-3 product-spesificaiton" v-html="product.specification"></p>
            </div>
        </div>
    </Modal>


</template>


<style scoped>
.offer{
  position: relative;
  cursor: pointer;
}
.offer-overlay {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 85.7%;
  background: rgba(0,0,0,0.8);
  border-radius: 5px;
  opacity: 0;
  cursor: pointer;
  /*transition: 0.4s all ease;*/
}
.offer-overlay p{
  color: #FFFFFF;
  /*padding: 78% 26% 61% 26%;*/
  cursor: pointer;
}
.offer:hover .offer-overlay{
  opacity: 1;
  cursor: pointer;
}

.offer-card-bottom-button {
  position: absolute;
  bottom: -1px;
  background: white;
  padding: 2px 0px;
  display: block;
  width: 100%;
  font-size: 13px;
  border: 1px solid #cdc6c6;
  color: black;
  border-top: none;
  cursor: pointer;
}
.offer-card-bottom-button:hover{
  color: black !important;
  cursor: pointer;
}

.offer:hover .offer-overlay a{
  text-decoration: none;
  text-align: center;
  padding: 5px;
  background: #ededed;
  border-radius: 0 0 5px 5px;
}
.modal-product-title{
    line-height: 35px;
    color: black !important;
    font-size: 25px !important;
    font-weight: 500;
}
.discount-price-show{
    position: relative;
}
.discount-price-show::before{
    content: "";
    position: absolute;
    border-right: 21px solid var(--bs-primary);
    left: -14px;
    border-top: 25px solid transparent;
    border-bottom: 24px solid transparent;
    top: 0;
    bottom: 0;
}
.discount-price-show::after{
    content: "";
    width: 7px;
    height: 7px;
    background: white;
    position: absolute;
    left: 0;
    border-radius: 50%;
    top: 40%;
}
.product-spesificaiton{
    max-height: 250px;
    overflow-x: hidden;
    overflow-y: scroll;
}
</style>
