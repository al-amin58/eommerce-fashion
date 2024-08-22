<script setup>
import layout from "../Shared/Layout.vue";
import Pagination from "../../../components/Pagination.vue";
import TreeView from "../../../components/TreeView.vue";
import {computed, ref, watch} from 'vue'
import {Inertia} from "@inertiajs/inertia";
import debounce from "lodash/debounce";
import {useData} from "../../../Composables/useData";
import Modal from '../../../components/Modal.vue'
import StarTProducts from "../Pages/StarTProducts.vue";

const data = useData();

const props = defineProps({
    addInfo: [] | null,
})

const listView = ref(false)
const showList = (e) => {
    listView.value = true;
    var $gridCont = document.getElementById('productView');
    $gridCont.classList.add('list-view');
}
const gridList = (e) => {
    listView.value = false;
    var $gridCont = document.getElementById('productView');
    $gridCont.classList.remove('list-view');
}
const product = ref({})
const singleProductView = (product) => {
    product.value = product;
    document.getElementById('productDetails').$vb.modal.show()

    // Inertia.post(`/product/single-product/${slug}`, {
    //     discountType:props.addInfo.discount_type,
    //     discountAmount:props.addInfo.discount_price,
    // },{
    //     onError:err=>{
    //         $toast.error('Have An Error. Please Try Again')
    //     }
    // })
}


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
                                <h2 class="fw-semibold text-primary text-capitalize">{{ props.addInfo?.title  }}</h2>
                            </div>


<!--                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                <button class="btn btn-outline-primary" @click="gridList">
                                    <vue-feather type="grid" size="10"/>
                                </button>
                                <button class="btn btn-outline-primary" @click="showList">
                                    <vue-feather type="list" size="10"/>
                                </button>
                            </div>-->
                        </div>
                        <!--                    <div class="card">
                                                <div class="card-body p-0 position-relative d-flex align-items-center">
                                                    <div class="col-md-9 position-relative">
                                                        <input type="text" class="form-control p-1 border-0" v-model="search" placeholder="what your looking for ...">
                                                        <span class="position-absolute" style="right: 20px;top: 16px;color: #c7c7cf;">
                                                            <vue-feather type="search" size="18"/>
                                                        </span>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <select v-model="orderBy" class="form-control border-0 shadow-none">
                                                            <option :value="undefined">Sorting</option>
                                                            <option value="price_low_high">Price Low To High</option>
                                                            <option value="price_high_low">Price High To Low</option>
                                                            <option value="newest_first">Newest First</option>
                                                            <option value="oldest_first">Oldest First</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>-->
                    </div>
                </div>
                <div class="row match-height">
                    <div class="col-12 col-md-6 col-lg-3 product-card-hover" v-for="item in props.addInfo.products.data" :key="'item-'+item.id">
                        <StarTProducts :product="item"/>
                    </div>
                    <Pagination :links="props.addInfo.products.links" :from="props.addInfo.products.from"
                                :to="props.addInfo.products.to" :total="props.addInfo.products.total"
                                notShowNumber/>
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
