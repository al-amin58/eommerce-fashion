<template>
    <Head>
        <meta type="description" content="Information about my app" head-key="description">
    </Head>
    <Layout>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-bolder fs-5">Total Seals</p>
                        <div class="d-flex align-items-center justify-content-between pe-3">
                            <div>
                                <h2 class="text-primary">{{ props.info.totalSeals }}</h2>
                            </div>
                            <span class="text-primary">
                                <vue-feather type="trending-up" size="30"/>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-bolder fs-5">Total Orders</p>
                        <div class="d-flex align-items-center justify-content-between pe-3">
                            <div>
                                <h2 class="text-primary">{{ props.info.totalOrder }}</h2>
                            </div>
                            <span class="text-primary">
                                <vue-feather type="shopping-cart" size="30"/>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-bolder fs-5">Total Customer</p>
                        <div class="d-flex align-items-center justify-content-between pe-3">
                            <div>
                                <h2 class="text-primary">{{ props.info.totalCustomer }}</h2>
                            </div>
                            <span class="text-primary">
                                <vue-feather type="users" size="30"/>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-bolder fs-5">Total Products</p>
                        <div class="d-flex align-items-center justify-content-between pe-3">
                            <div>
                                <h2 class="text-primary">{{ props.info.totalProducts }}</h2>
                            </div>
                            <span class="text-primary">
                                <vue-feather type="codesandbox" size="30"/>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row match-height">
            <div class="col-md-6">
                <div class="card card-revenue-budget">
                    <div class="card-body">
                        <h2 class="card-title">Last One Yar Order Report</h2>
                        <ApexLineChart :data="props.info.data"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-revenue-budget">
                    <div class="card-body">
                        <h2 class="card-title">Last One Year Registered Users</h2>


                        <ApexLineChart2 :data="props.info.lastYearUsers"/>
                    </div>
                </div>
            </div>
        </div>

    </Layout>
</template>

<script setup>
import Layout from "../Shared/Layout.vue";
import {onMounted} from "vue";
import VueApexCharts from "vue-apexcharts";
import ApexLineChart from "../components/ApexLineChart.vue";
import ApexLineChart2 from "../components/ApexLineChart2.vue";


const props = defineProps({
    info:[]|null,
})

</script>
