<script setup>
import Layout from "../Shared/Layout.vue";
import {onMounted} from "vue";
import {useCartStore} from "../../../Store/useCartStore";
import {useDataStore} from "../../../Store/useDataStore";

const props = defineProps({
    order:Object,
})

const store = useCartStore();
const dataStore = useDataStore();

onMounted(() =>{
    store.clearCart();
    store.initCart();
    dataStore.setSetting('header_logo');
    dataStore.setSetting('footer_logo');
    dataStore.setSetting('name');
    dataStore.setSetting('address');
    dataStore.setSetting('phone');
    dataStore.setSetting('email');
})
</script>

<template>
    <Layout>
        <section class="app-user-list">
            <div class="container">
                <div class="row mt-5">
                    <div class="col-md-7 mx-auto">
                        <div class="d-flex gap-1 mb-2">
                            <a href="/dashboard" class="back-btn">
                                <vue-feather type="arrow-left"/>
                            </a>
                            <h2 class="fw-semibold text-primary">Order Invoice</h2>
                        </div>
                        <div class="card page-shadow invoice-preview-card">
                            <div class="card-body invoice-padding pb-0">
                                <!-- Header starts -->
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                    <div>
                                        <div class="logo-wrapper">
                                            <img :src="`${$page.props.auth.MAIN_URL}/storage/${dataStore.settingItem.find(item => item.key === 'header_logo')?.val}`" style="max-width: 65px" alt="">
                                            <!--                                        <h3 class="text-primary invoice-logo" v-html="$page.props.auth.APP_NAME"></h3>-->
                                        </div>

                                        <h2 class="brand-text">{{ dataStore.settingItem.find(item => item.key === 'name')?.val }}</h2>
                                        <p class="card-text">{{ dataStore.settingItem.find(item => item.key === 'address')?.val }}</p>
                                        <p class="card-text mb-0 pb-0">Phone: {{ dataStore?.settingItem?.find(item => item.key === 'phone')?.val }}</p>
                                        <p class="card-text">Email: {{ dataStore.settingItem.find(item => item.key === 'email')?.val }}</p>

                                    </div>
                                    <div class="mt-md-0 mt-2">
                                        <h4 class="invoice-title">
                                            Invoice
                                            <span class="invoice-number">#{{ order.id }}</span>
                                        </h4>
                                        <div class="invoice-date-wrapper">
                                            <p class="invoice-date-title">Order Date: {{ order.created_at }}</p>
                                        </div>
                                        <div class="invoice-date-wrapper">
                                            <p class="invoice-date-title text-capitalize">Order Status: <span class="badge bg-light-primary ms-1">{{ order.order_status }}</span></p>
                                        </div>
                                        <div class="invoice-date-wrapper">
                                            <p class="invoice-date-title text-capitalize">Payment Status: <span class="badge bg-light-primary ms-1">{{ order.payment_status }}</span></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>

                            <hr class="invoice-spacing" />
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing">
                                    <div class="col-xl-8">
                                        <h6 class="mb-2">Invoice To:</h6>
                                        <h6 class="card-text mb-25" v-if="order.customer">{{order.customer?.name}}</h6>
                                        <p class="mb-25" v-if="order.address?.address">{{ order.address?.address }}</p>
                                        <p class="mb-25" v-if="order.address?.phone">{{ order.address?.phone }}</p>
                                        <p class="mb-25" v-if="order.address?.email">{{ order.address?.email }}</p>
                                    </div>
                                    <!--

                                                                            <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                                                                <h6 class="mb-2">Payment Details:</h6>
                                                                                <table>
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td class="pe-1">Total Due:</td>
                                                                                        <td><span class="fw-bold">{{ info.invoice.due }} Tk</span></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="pe-1">Bank name:</td>
                                                                                        <td>American Bank</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="pe-1">Country:</td>
                                                                                        <td>United States</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="pe-1">IBAN:</td>
                                                                                        <td>ETD95476213874685</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="pe-1">SWIFT code:</td>
                                                                                        <td>BR91905</td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                    -->
                                </div>
                            </div>


                            <!-- Address and Contact ends -->

                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="py-1" width="40%">Product Name</th>
                                        <th class="py-1">Price</th>
                                        <th class="py-1">size & Qty</th>
                                        <th class="py-1">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in  order.order_details">
                                        <td class="py-1">
                                            <p class="text-primary">
                                                {{ item.product?.title.slice(0, 35)}}...
                                            </p>
                                        </td>
                                        <td class="py-1">
                                            <span class="fw-bold"> {{ item.product?.discount ? item.product?.discount : item.product?.price }}</span>
                                        </td>
                                        <td class="py-1">
                                            <span class="fw-bold">{{ item?.buy_size }}</span> * <span>{{ item?.quantity }}</span>
                                        </td>
                                        <td class="py-1">
                                            <span class="fw-bold">{{ (item.product?.discount ? item.product?.discount : item.product?.price) * item?.quantity }} </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <hr>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-8 order-md-1 order-2 mt-md-0 mt-3">

                                    </div>
                                    <div class="col-md-4 d-flex justify-content-end order-md-2 order-1">
                                        <div class="invoice-total-wrapper w-100">
                                            <div class="invoice-total-item d-flex justify-content-between">
                                                <p class="invoice-total-title">Subtotal:</p>
                                                <p class="invoice-total-amount">{{order?.cart_total_price }}</p>
                                            </div>
                                            <div class="invoice-total-item d-flex justify-content-between" v-if="order?.coupon_discount">
                                                <p class="invoice-total-title">Coupon Discount:</p>
                                                <p class="invoice-total-amount"> - {{ order?.coupon_discount }}</p>
                                            </div>
                                            <div class="invoice-total-item d-flex justify-content-between">
                                                <p class="invoice-total-title">Delivery Charge:</p>
                                                <p class="invoice-total-amount"> + {{ order?.delivery_charge ?? 0 }}</p>
                                            </div>


                                            <hr class="my-50" />
                                            <div class="invoice-total-item d-flex justify-content-between">
                                                <p class="invoice-total-title text-black fw-bolder">Total:</p>
                                                <p class="invoice-total-amount text-black fw-bolder">{{ order?.grand_total  }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->

                            <hr class="invoice-spacing" />

                            <!-- Invoice Note starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold me-1">Thank you sir</span>
                                    </div>
                                    <div>
                                        <a :href="$page.props.auth.MAIN_URL+'/print-invoice/'+order.id" target="_blank" class="btn btn-gradient-primary d-flex align-items-center text-white">
                                            <vue-feather type="printer" size="10"/>
                                            <span class="ms-1">Print</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Note ends -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>


