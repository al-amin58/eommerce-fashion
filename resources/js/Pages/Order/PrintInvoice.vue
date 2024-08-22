<script setup>

import {computed, onMounted} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import Layout from "../../Shared/Layout.vue";
import Swal from "sweetalert2";

const props = defineProps({
    order:Object|null,
    url:[]|null,
})

onMounted(() =>{
    window.print();
})

</script>

<template>
    <section class="app-user-list overflow-hidden">
            <div class="row">
                <div class="col-md-9 mx-auto p-3">

                    <div class="d-flex gap-1 mb-2">
                        <a href="/dashboard" class="back-btn">
                            <vue-feather type="arrow-left"/>
                        </a>
                        <h2 class="fw-semibold text-primary">Order Invoice</h2>
                    </div>


                    <div class="card invoice-preview-card shadow-none">
                        <div class="card-body invoice-padding pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <div style="text-align:left; max-width: 35%">
                                    <div>
                                        <div class="logo-wrapper">
                                            <img src="../../../images/logo.png" alt="" height="60">
                                        </div>
                                        <h3 class="card-text">AMBLE TRADING</h3>

                                        <h2 class="mt-1">Invoice To: </h2>
                                        <p class="card-text mb-0 pb-0">Name: <strong>{{ order?.customer?.name }}</strong></p>
                                        <p class="card-text mb-0 pb-0">Phone: {{ order?.customer?.phone }}</p>
                                        <p class="card-text mb-0 pb-0">Email: {{ order?.customer?.email }}</p>
                                        <p class="card-text mb-0 pb-0">Address: {{ order?.address?.address }}</p>

                                    </div>
                                </div>
                                <div style="text-align: right">
                                    <div class="mt-md-0 mt-2">
                                        <h4 class="invoice-title">
                                            Invoice
                                            <span class="invoice-number">#{{ order.id }}</span>
                                        </h4>
                                        <div class="invoice-date-wrapper">
                                            <p class="invoice-date-title">Order Date: {{ order.order_date }}</p>
                                        </div>
                                        <div class="invoice-date-wrapper">
                                            <p class="invoice-date-title text-capitalize">Order Status: <span class="badge bg-light-primary ms-1">{{ order.order_status }}</span></p>
                                        </div>
                                        <div class="invoice-date-wrapper">
                                            <p class="invoice-date-title text-capitalize">Payment Status: <span class="badge bg-light-primary ms-1">{{ order.payment_status }}</span></p>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="invoice-spacing" />

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
                                        <a href="#">
                                            {{ item.product.title }}
                                        </a>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold"> {{  item.product.price }}</span>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold">{{ item.buy_size }}</span> * <span>{{ item.quantity }}</span>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold">{{item.product.price * item.quantity }}</span>
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
                                            <p class="invoice-total-amount">{{ order?.cart_total_price }}</p>
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
                                    <span class="fw-bold me-1">Thank you sir:</span>
                                    <span>Welcome</span>
                                </div>
                            </div>
                        </div>
                        <!-- Invoice Note ends -->
                    </div>
                </div>
            </div>
        </section>
</template>

<style lang="sass">

</style>
