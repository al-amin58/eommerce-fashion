<script setup>
    import Layout from "../../Frontend/Shared/Layout.vue";
    import {Inertia} from "@inertiajs/inertia";
    import {onMounted, ref} from "vue";
    import {useCartStore} from "../../../Store/useCartStore";
    import {useForm} from "@inertiajs/inertia-vue3";
    const props = defineProps({
        make_payment:null,
        info:[]|null,
        checkoutData:null,
    })
    const store = useCartStore();

    const makePayment = (type)=>{
        Inertia.post(props.make_payment)
    }

    const formData = useForm({
        tramsPolicy:null,
        paymentMethod:null,
    })

    const isLoading = ref(false)
    const submitPayment = ()=>{
        if (formData.tramsPolicy === null){
            $toast.warning("Please check our trams and policies.")
        }else if(formData.paymentMethod === null){
            $toast.warning("Please select your payment method.")
        }else{
            Inertia.post(props.make_payment,{
                formData:formData,
                cartItems:store.getCartItems,
                totalItems:store.getCartLength,
                cartTotalPrice:store.getCartTotalPrice
            },{
                preserveState: true,
                replace: true,
                onStart: res => {
                    isLoading.value = true;
                },

                onSuccess: page => {
                    isLoading.value = false;
                    // isPaymentPage.value = true;

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

    }

    onMounted(()=>{
        // store.clearCart();
        // store.initCart();
        $sToast.fire({
            icon: 'success',
            title: 'Shipping Info Saved...',
        })
    })


</script>

<template>
    <Layout>
        <div class="container-sm my-5">
            <!-- Payment -->
            <div id="checkout-payment" class="fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="row">
                    <div class="col-xl-6 mb-3 mb-xl-0 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Select your payment method</h4>
                            </div>
                            <div class="card-body">
                                <div class="row custom-options-checkable g-1 match-height">
                                    <div class="col-md">
                                        <input class="custom-option-item-check" v-model="formData.paymentMethod" type="radio"
                                               name="customOptionsCheckableRadiosWithIcon"
                                               id="customOptionsCheckableRadiosWithIcon2"
                                               value="cod">
                                        <label class="custom-option-item text-center text-center p-1" for="customOptionsCheckableRadiosWithIcon2">
                                            <img src="../../../../images/cod.png" width="75" class="p-1"/>
                                            <span class="custom-option-item-title h4 d-block">Cash On Delivery</span>
                                            <small>I am happy with cash on delivery</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" v-model="formData.tramsPolicy"  type="checkbox" id="login">
                                <label class="form-check-label" for="login">I agree to the
                                    <a href="">Terms and Conditions</a> ,
                                    <a href="">Return Policy</a>&
                                    <a href="">Privacy Policy</a>
                                </label>
                            </div>
                        </div>


                        <div class="btn-group mt-5">
                            <button class="btn btn-primary me-2" @click="submitPayment">Pay Now</button>
                            <button class="btn btn-outline-dark" @click="cancleOrder">Cancel</button>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </Layout>
</template>



<style scoped>

</style>
