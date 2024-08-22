<template>
    <Layout>
        <div class="card sm-mt">
            <div class="card-body overflow-x-scroll">
                <h2>All Orders</h2>

                <table class="table table-striped table-borderless table-responsive">
                    <thead>
                    <th class="p-1">OrderId</th>
                    <th class="p-1">Total Price</th>
                    <th class="p-1">Payment Method</th>
                    <th class="p-1">Payment Status</th>
                    <th class="p-1">Order Status</th>
                    </thead>

                    <tbody>
                    <tr v-for="item in props.orders.orders" :key="item.id">
                        <td>#laravel_{{ item.id }}</td>
                        <td>{{ item.cart_total_price }}</td>
                        <td>{{ item.payment_method }}</td>
                        <td>
                        <span class="badge bg-light-primary">
                            {{ item.payment_status }}
                        </span>
                        </td>
                        <td>
                        <span class="badge bg-light-primary">
                            {{ item.order_status }}
                        </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Layout>

</template>
<script setup>
import Layout from "../Shared/Layout.vue";
const props = defineProps({
    orders:Object,
})


</script>
