<script setup>
import layout from "../Shared/Layout.vue";
import Pagination from "../../../components/Pagination.vue";

const props = defineProps({
    adds: [] | null,
})

</script>

<template>
    <layout>

        <section class="app-user-list my-5">
            <div class="container grid-container" id="productView">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="d-flex gap-1 mb-2">
                                <a href="/" class="back-btn">
                                    <vue-feather type="arrow-left"/>
                                </a>
                                <h2 class="fw-semibold text-primary text-capitalize">Exclusive Offer's</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row match-height">
                    <div class="col-12 col-md-6 col-lg-3 product-card-hover" v-for="item in props.adds.data" :key="'item-'+item.id">
                        <div class="card page-shadow">
                            <div class="card-body">
                                <a :href="`/products/ads-products?add=${item?.slug}`">
                                    <img class="w-100" :src="item.image" alt="">
                                    <h2 class="mt-2 fw-bold">{{ item.title }}</h2>
                                </a>
                            </div>
                        </div>
                    </div>
                    <Pagination :links="props.adds.links" :from="props.adds.from"
                                :to="props.adds.to" :total="props.adds.total"
                                />
                </div>
            </div>
        </section>
    </layout>
</template>

<style lang="scss">
.card {
    margin-bottom: 1rem;
}

.list-view {
    .row {
        > [class*='col-'] {
            max-width: 100%;
            flex: 0 0 100%;
        }
    }

    .card {
        @media (max-width: 575.98px) {
            flex-direction: column;
        }
        flex-direction: row;

        > .card-img-top {
            width: auto;
        }

        .card-body {
            display: inline-block;
        }
    }
}

.ecommerce-card {
    box-shadow: 0 0px 14px -1px rgb(34 41 47 / 32%) !important;
    margin-top: 18px !important;
    transition: 0.3s all ease;
    flex: 1 1 auto;
    overflow: hidden;
}

.ecommerce-card img {
    transition: 0.3s all ease;
}

.ecommerce-card:hover {
    box-shadow: 0 0px 14px 2px rgb(34 41 47 / 54%) !important;
    transform: scale(1.04);
}

.ecommerce-card:hover .item-name a {
    color: var(--bs-primary);
}

.ecommerce-card:hover img {
    transform: scale(1.4);
}

.discount-span {
    right: 14px;
    position: absolute;
    top: 15px;
    padding: 1px 13px;
    border-radius: 50px;
}

</style>
