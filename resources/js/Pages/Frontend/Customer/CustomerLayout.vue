<script setup>
import Layout from "../Shared/Layout.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {ref} from 'vue'
import ProductCard from "../Modules/ProductCard.vue";
import {useWishListStore} from "../../../Store/useWishListStore";
import {useCartStore} from "../../../Store/useCartStore";
import {Inertia} from "@inertiajs/inertia";

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




const formData = useForm({
    name:null,
    email:null,
    phone:null,
})
const authData = useForm({
    current:null,
    new:null,
    confirmed:null,
})
const isLoading = ref(false)
const updateCustomerProfile = () => {
    formData.post('/update-user-profile', {
        preserveState: true,
        replace: true,
        onStart: res => {
            isLoading.value = true;
        },
        onSuccess: page => {
            isLoading.value = false;
            formData.reset();
            $sToast.fire({
                icon: 'success',
                title: page.props.info.message,
            })
        },
        onError: errors => {
            document.getElementById('actionModal').$vb.modal.hide()
            isLoading.value = false;
            $toast.error("Validation Errors...")
        }
    })
}
const passIsLoad = ref(false);
const updateCustomerPassword = () =>{
    authData.post('/update-user-credentials', {
        preserveState: true, replace: true,
        onStart: res => passIsLoad.value = true,
        onSuccess: page => {
            passIsLoad.value = false;
            formData.reset();
        },
        onError: errors => $toast.error(errors)
    })
}
const profileImage = ref(null);
const uploadImageData = ref(null);
const uploadImage = (event) =>{
    profileImage.value=URL.createObjectURL(event.target.files[0])
    uploadImageData.value = event.target.files[0];
}
const updateProfileImage = () =>{
    Inertia.post('/update-profile-image', {image:uploadImageData.value},{
        preserveState: true,
        replace: true,
        onSuccess: page => {
            uploadImageData.value = {};
            $sToast.fire({
                icon: 'success',
                title: 'Signed in successfully'
            })
        },
        onError: errors => {
            $toast.error("Server Error 500")
        }
    })
}


</script>

<template>
    <Layout>
        <div class="container-sm my-5 overflow-y-scroll">
            <div class="row">
                <div class="col-md-3">
                    <div class="card ">
                        <div class="card-body">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                                        aria-selected="true">Home</button>
                                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-profile" type="button" role="tab"
                                        aria-controls="v-pills-profile" aria-selected="false">Orders</button>
                                <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-messages" type="button" role="tab"
                                        aria-controls="v-pills-messages" aria-selected="false">Watch List</button>
                                <a :href="$page.props.auth.MAIN_URL+'/logout'" class="nav-link">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 ms-1">
                    <div class="tab-content" id="v-pills-tabContent">
                        <slot/>
                    </div>
                </div>
            </div>
        </div>


    </Layout>
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
</style>
