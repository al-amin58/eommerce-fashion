<script setup>
import Layout from "../../Frontend/Shared/Layout.vue";
import {useCartStore} from "../../../Store/useCartStore";
import {computed, ref} from 'vue'
import {onMounted} from 'vue'
import {Inertia} from "@inertiajs/inertia";
import axios from "axios";
import {useData} from "../../../Composables/useData";

const {priceSignature} = useData()

const props = defineProps({
    main_url: String | null,
    user: Array | null,
    checkOutData: Object | null,
    apply_coupon_url: String | null,
})

const store = useCartStore();
onMounted(() => {
    store.initCart();
})

const deliveryPrice = ref(0);
const discountPriceRef = ref(0)

const isLoading = ref(false);
const setAddress = (event) => {
    deliveryPrice.value = event.order_area
}
const couponCode = ref(null);
const couponError = ref(null);
const couponData = ref(null);
const applyCoupon = () => {
    axios.post(props.apply_coupon_url, {data: couponCode.value}).then((res) => {
        if (res.data.status === 200) {
            couponData.value = res.data.code;
            couponError.value = null;
        } else {
            couponError.value = res.data.message;
        }

    }).catch((err) => {
        couponError.value = err.response.data.errors.data[0];
    })
}

const totalPrice = computed(() => {
    let price = parseInt(store.getCartTotalPrice);
    if (couponData.value) {
        if (couponData.value.type === 'percent') {
            let discountPrice = (parseInt(store.getCartTotalPrice) * couponData.value.value) / 100;
            price = parseInt(store.getCartTotalPrice) - discountPrice;

            discountPriceRef.value = discountPrice;
        } else {
            discountPriceRef.value = parseInt(couponData.value.value);
            price = parseInt(store.getCartTotalPrice) - parseInt(couponData.value.value);
        }
    }

    let deliveryCharge = 0;

    if (deliveryPrice.value) {
        if (parseInt(store.getCartTotalPrice) >= deliveryPrice.value.charge_condition) {
            deliveryCharge = deliveryPrice.value.charge_condition_price;
        } else {
            deliveryCharge = deliveryPrice.value.delivery_charge;
        }
    }

    return price + parseInt(deliveryCharge);
})

const saveCheckoutInfo = () => {
    if (deliveryPrice.value) {
        Inertia.post(props.main_url, {
            cartItems: store.getCartItems,
            totalItems: store.getCartLength,
            cartTotalPrice: store.getCartTotalPrice,
            address: deliveryPrice.value,
            couponData: couponData.value,
            couponDiscount: discountPriceRef.value,
        }, {
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
        });
    } else {
        $sToast.fire({
            icon: 'warning',
            title: "Please Select An Delivery Address...",
        })
    }
}


</script>

<template>
    <Layout>
        <div class="container-sm mt-5">

            <!-- Address -->
            <div class="row">
                <!-- Address left -->
                <div class="col-xl-9 mb-3 mb-xl-0" v-if="checkOutData !== undefined">
                    <!-- Select address -->
                    <h2 class="card-title fw-bold">Select Your Shipping Detail's</h2>
                    <div v-if="props.user.addresses.length > 0">
                        <div class="row match-height mt-3">
                            <div class="col-md-6 shadow-none"
                                 v-for="item in props.user.addresses" v-if="props.user.addresses"
                                 :key="item.title">
                                <div class="card rounded-3 overflow-hidden page-shadow">
                                    <div class="card-body p-0">
                                        <input class="custom-option-item-check"
                                               type="radio" :name="'item-'+id"
                                               v-model="address"
                                               :value="item.id"
                                               @input="setAddress(item)"
                                               :id="'item-'+item.id">
                                        <label class="custom-option-item p-1" :for="'item-'+item.id">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h2 class="text-capitalize text-primary">{{ item?.title }}</h2>
                                            </div>
                                            <p>{{ item?.address }}</p>
                                            <p class="mb-0">{{ item?.email }}</p>
                                            <p>{{ item?.phone }}</p>
                                            <p>Area: {{ item?.order_area?.area_name }} & Delivery Charge: {{item?.order_area?.delivery_charge }}</p>
                                            <p>If you buy up to <strong class="text-primary">{{
                                                   item?.order_area?.charge_condition }}</strong> then your
                                                delivery charge is <strong class="text-primary">{{
                                                        item?.order_area?.charge_condition_price }}</strong></p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div v-else>
                                <a class="btn btn-primary" href="">Add Address</a>
                            </div>

                        </div>
                    </div>
                    <div v-else>
                        <a class="btn btn-primary d-flex align-items-center gap-1 mt-2" style="width:max-content" href="/customer/address">
                            <span>Add New Address</span>
                            <vue-feather type="arrow-right"></vue-feather>
                        </a>
                    </div>
                </div>


                <div class="col-xl-3 mb-4">
                    <div class="border rounded p-2 mb-3 bg-white page-shadow">
                        <span class="text-end">
                            {{ `${store.getCartLength} Items In Your Bag`  }}
                        </span>

                        <hr class="mt-2">

                        <dl class="row mb-0">
                            <dt class="col-6 fw-normal">Bag Total</dt>
                            <dd class="col-6 text-end">{{ store.getCartTotalPrice }}</dd>

                            <dt class="col-6 fw-normal" v-if="couponData">Discount ({{ couponData.value + " " }}{{
                                couponData.type == "percent" ? '%' : priceSignature }} )
                            </dt>
                            <dd class="col-6 text-success text-end" v-if="couponData"> {{  discountPriceRef }} </dd>

                            <!--                            <dt class="col-6 fw-normal">Vat</dt>
                                                        <dd class="col-6 text-end">৳ 5.00 </dd>q

                                                        <dt class="col-6 fw-normal">Tax</dt>
                                                        <dd class="col-6 text-end">৳ 5.00 </dd>-->

                            <dt class="col-6 fw-normal">Delivery Charge</dt>
                            <dd class="col-6 text-end">{{ store.getCartTotalPrice >= deliveryPrice.charge_condition ?
                                deliveryPrice.charge_condition_price : deliveryPrice.delivery_charge ?? 0 }}
                            </dd>


                            <hr>

                            <dt class="col-6">Total</dt>
                            <dd class="col-6 fw-semibold text-end mb-0">{{ totalPrice }}</dd>
                        </dl>
                    </div>

                    <div class="apply-coupon">
                        <input type="text" v-model="couponCode" class="form-control" placeholder="coupon code">
                        <button @click="applyCoupon">Apply Coupon</button>
                    </div>
                    <p class="text-danger">{{ couponError ?? '' }}</p>

                    <div class="d-grid  mb-2 mb-lg-0 mt-3">
                        <button @click="saveCheckoutInfo" :disabled="isLoading" class="btn btn-primary btn-next">Place
                            Order
                        </button>
                    </div>
                </div>
            </div>


            <!--

                    &lt;!&ndash; Payment &ndash;&gt;
                    <div id="checkout-payment" class="content fv-plugins-bootstrap5 fv-plugins-framework">
                        <div class="row">
                            &lt;!&ndash; Payment left &ndash;&gt;
                            <div class="col-xl-9 mb-3 mb-xl-0">
                                &lt;!&ndash; Offer alert &ndash;&gt;
                                <div class="alert alert-success" role="alert">
                                    <div class="d-flex gap-3">
                                        <div class="flex-shrink-0">
                          <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2">
                            <i class="bx bx-sm bx-purchase-tag fs-4"></i>
                          </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">Bank Offers</div>
                                            <ul class="list-unstyled mb-0">
                                                <li> - 10% Instant Discount on Bank of America Corp Bank Debit and Credit cards</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                &lt;!&ndash; Payment Tabs &ndash;&gt;
                                <div class="col-xxl-6 col-lg-8">
                                    <ul class="nav nav-pills mb-3" id="paymentTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-cc-tab" data-bs-toggle="pill" data-bs-target="#pills-cc" type="button" role="tab" aria-controls="pills-cc" aria-selected="true">Home</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-cod-tab" data-bs-toggle="pill" data-bs-target="#pills-cod" type="button" role="tab" aria-controls="pills-cod" aria-selected="false" tabindex="-1">Cash On Delivery</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-gift-card-tab" data-bs-toggle="pill" data-bs-target="#pills-gift-card" type="button" role="tab" aria-controls="pills-gift-card" aria-selected="false" tabindex="-1">Gift Card</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="paymentTabsContent">
                                        &lt;!&ndash; Credit card &ndash;&gt;
                                        <div class="tab-pane fade show active" id="pills-cc" role="tabpanel" aria-labelledby="pills-cc-tab">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label w-100" for="paymentCard">Card Number</label>
                                                    <div class="input-group input-group-merge">
                                                        <input id="paymentCard" name="paymentCard" class="form-control credit-card-mask" type="text" placeholder="1356 3215 6548 7898" aria-describedby="paymentCard2">
                                                        <span class="input-group-text cursor-pointer p-1" id="paymentCard2"><span class="card-type"></span></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label" for="paymentCardName">Name</label>
                                                    <input type="text" id="paymentCardName" class="form-control" placeholder="John Doe">
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label class="form-label" for="paymentCardExpiryDate">Exp. Date</label>
                                                    <input type="text" id="paymentCardExpiryDate" class="form-control expiry-date-mask" placeholder="MM/YY">
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label class="form-label" for="paymentCardCvv">CVV Code</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" id="paymentCardCvv" class="form-control cvv-code-mask" maxlength="3" placeholder="654">
                                                        <span class="input-group-text cursor-pointer" id="paymentCardCvv2"><i class="bx bx-help-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Card Verification Value" data-bs-original-title="Card Verification Value"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="switch">
                                                        <input type="checkbox" class="switch-input">
                                                        <span class="switch-toggle-slider">
                                  <span class="switch-on"></span>
                                  <span class="switch-off"></span>
                                </span>
                                                        <span class="switch-label">Save card for future billing?</span>
                                                    </label>
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-primary btn-next me-sm-3 me-1">Submit</button>
                                                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                                </div>
                                            </div>
                                        </div>

                                        &lt;!&ndash; COD &ndash;&gt;
                                        <div class="tab-pane fade" id="pills-cod" role="tabpanel" aria-labelledby="pills-cod-tab">
                                            <p>Cash on Delivery is a type of payment method where the recipient make payment for the order at the time of delivery rather than in advance.</p>
                                            <button type="button" class="btn btn-primary btn-next">Pay On Delivery</button>
                                        </div>

                                        &lt;!&ndash; Gift card &ndash;&gt;
                                        <div class="tab-pane fade" id="pills-gift-card" role="tabpanel" aria-labelledby="pills-gift-card-tab">
                                            <h6>Enter Gift Card Details</h6>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label for="giftCardNumber" class="form-label">Gift card number</label>
                                                    <input type="number" class="form-control" id="giftCardNumber" placeholder="Gift card number">
                                                </div>
                                                <div class="col-12">
                                                    <label for="giftCardPin" class="form-label">Gift card pin</label>
                                                    <input type="number" class="form-control" id="giftCardPin" placeholder="Gift card pin">
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-primary btn-next">Redeem Gift Card</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            &lt;!&ndash; Address right &ndash;&gt;
                            <div class="col-xl-3">
                                <div class="border rounded p-3">

                                    &lt;!&ndash; Price Details &ndash;&gt;
                                    <h6>Price Details</h6>
                                    <dl class="row">

                                        <dt class="col-6 fw-normal">Order Total</dt>
                                        <dd class="col-6 text-end">$1100.00</dd>

                                        <dt class="col-6 fw-normal">Delivery Charges</dt>
                                        <dd class="col-6 text-end"><s>$5.00</s> <span class="badge bg-label-success">Free</span></dd>

                                        <hr>

                                        <dt class="col-6">Total</dt>
                                        <dd class="col-6 fw-semibold text-end mb-0">$1100.00</dd>

                                        <dt class="col-6">Deliver to:</dt>
                                        <dd class="col-6 fw-semibold text-end mb-0"><span class="badge bg-label-primary">Home</span></dd>
                                    </dl>
                                    &lt;!&ndash; Address Details &ndash;&gt;
                                    <address>
                                        <span class="fw-semibold"> John Doe (Default),</span><br>
                                        4135 Parkway Street, <br>
                                        Los Angeles, CA, 90017. <br>
                                        Mobile : +1 906 568 2332
                                    </address>
                                    <a href="javascript:void(0)">Change address</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    &lt;!&ndash; Confirmation &ndash;&gt;
                    <div id="checkout-confirmation" class="content fv-plugins-bootstrap5 fv-plugins-framework active dstepper-block">
                                        <div class="row mb-3">
                                            <div class="col-12 col-lg-8 offset-lg-2 text-center mb-3">
                                                <h4 class="mt-2">Thank You! 😇</h4>
                                                <p>Your order <a href="javascript:void(0)">#1536548131</a> has been placed!</p>
                                                <p>We sent an email to <a href="mailto:john.doe@example.com">john.doe@example.com</a> with your order confirmation and receipt. If the email hasn't arrived within two minutes, please check your spam folder to see if the email was routed there.</p>
                                                <p><span class="fw-semibold"><i class="bx bx-time-five"></i> Time placed:</span> 25/05/2020 13:35pm</p>
                                            </div>
                                            &lt;!&ndash; Confirmation details &ndash;&gt;
                                            <div class="col-12">
                                                <ul class="list-group list-group-horizontal-md">
                                                    <li class="list-group-item flex-fill">
                                                        <h6><i class="bx bx-map"></i> Shipping</h6>
                                                        <address>
                                                            John Doe <br>
                                                            4135 Parkway Street,<br>
                                                            Los Angeles, CA 90017,<br>
                                                            USA <br>
                                                            +123456789
                                                        </address>
                                                    </li>
                                                    <li class="list-group-item flex-fill">
                                                        <h6><i class="bx bx-credit-card"></i> Billing Address</h6>
                                                        <address>
                                                            John Doe <br>
                                                            4135 Parkway Street,<br>
                                                            Los Angeles, CA 90017,<br>
                                                            USA <br>
                                                            +123456789
                                                        </address>
                                                    </li>
                                                    <li class="list-group-item flex-fill">
                                                        <h6><i class="bx bx-train"></i> Shipping Method</h6>
                                                        <span class="fw-semibold">Preferred Method:</span><br>
                                                        Standard Delivery<br>
                                                        (Normally 3-4 business days)
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row">
                                            &lt;!&ndash; Confirmation items &ndash;&gt;
                                            <div class="col-xl-9 mb-3 mb-xl-0">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <div class="d-flex gap-3">
                                                            <div class="flex-shrink-0">
                                                                <img src="../../assets/img/products/1.png" alt="google home" class="w-px-75">
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <a href="javascript:void(0)" class="text-body">
                                                                            <h6>Google - Google Home - White</h6>
                                                                        </a>
                                                                        <div class="text-muted mb-1 d-flex flex-wrap"><span class="me-1">Sold by:</span> <a href="javascript:void(0)" class="me-1">Apple</a> <span class="badge bg-label-success">In Stock</span></div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="text-md-end">
                                                                            <div class="my-2 my-lg-4"><span class="text-primary">$299/</span><s class="text-muted">$359</s></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="d-flex gap-3">
                                                            <div class="flex-shrink-0">
                                                                <img src="../../assets/img/products/2.png" alt="google home" class="w-px-75">
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <a href="javascript:void(0)" class="text-body">
                                                                            <h6>Apple iPhone 11 (64GB, Black)</h6>
                                                                        </a>
                                                                        <div class="text-muted mb-1 d-flex flex-wrap"><span class="me-1">Sold by:</span> <a href="javascript:void(0)" class="me-1">Apple</a> <span class="badge bg-label-success">In Stock</span></div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="text-md-end">
                                                                            <div class="my-2 my-lg-4"><span class="text-primary">$299/</span><s class="text-muted">$359</s></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            &lt;!&ndash; Confirmation total &ndash;&gt;
                                            <div class="col-xl-3">
                                                <div class="border rounded p-3">
                                                    &lt;!&ndash; Price Details &ndash;&gt;
                                                    <h6>Price Details</h6>
                                                    <dl class="row mb-0">

                                                        <dt class="col-6 fw-normal">Order Total</dt>
                                                        <dd class="col-6 text-end">$1100.00</dd>

                                                        <dt class="col-6 fw-normal">Delivery Charges</dt>
                                                        <dd class="col-6 text-end"><s>$5.00</s> <span class="badge bg-label-success">Free</span></dd>

                                                        <hr>

                                                        <dt class="col-6">Total</dt>
                                                        <dd class="col-6 fw-semibold text-end mb-0">$1100.00</dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            -->

        </div>
    </Layout>
</template>


<style scoped>
.custom-option-item-check,
.custom-option-item {
    width: 100%;
    height: 100%;
}

.apply-coupon {
    display: flex;
    align-items: center;
    position: relative;
    /*margin-bottom: 2rem;*/
}

.apply-coupon button {
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    border: none;
    background: var(--bs-primary);
    color: white;
    border-radius: 0 5px 5px 0px;
}
</style>
