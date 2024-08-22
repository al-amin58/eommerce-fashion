<script setup>
import layout from "../../Shared/Layout.vue";
import {ref, watch, computed} from 'vue'
import Pagination from "../../components/Pagination.vue";
import debounce from "lodash/debounce";
import {Inertia} from "@inertiajs/inertia";
import {useAction} from "../../Composables/useAction";
import {usePage} from "@inertiajs/inertia-vue3";
const {deleteItem, copyToClipboard} = useAction();

const props = defineProps({
    products:[]|null,
    filters: Object,
    main_url:String,
    message:String,
})

const listView = ref(false)
const showList = (e) => listView.value = true
const gridList = (e) => listView.value = false


const search = ref();
const perPage = ref();

computed(() => {
    $sToast.fire({
        icon: 'success',
        title: usePage().props.value.message
    })
});



watch([search, perPage], debounce(function ([val, val2]) {
    Inertia.get(props.main_url, { search: val, perPage: val2 }, { preserveState: true, replace: true });
}, 300));



</script>

<template>
    <layout>

        <div class="content-header row mb-1">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h2 class="float-start mb-0">Product List</h2>
                <a class="btn btn-sm btn-gradient-primary d-flex align-items-center"
                   href="/panel/product/create"
                   target="_blank"
                   type="button">
                    <vue-feather type="plus" size="15"/>
                    <span>Add New Product</span>
                </a>
            </div>
        </div>
        <section class="app-user-list">
            <div class="row">

                <div class="col-md-12">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span>{{ products.total }} results found</span>

                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <button class="btn btn-outline-primary" @click="gridList">
                                <vue-feather type="grid" size="10"/>
                            </button>
                            <button  class="btn btn-outline-primary" @click="showList">
                                <vue-feather type="list" size="10"/>
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body p-0 position-relative d-flex align-items-center">
                            <input type="text" class="form-control p-1 border-0" v-model="search" placeholder="what your looking for ...">
                            <span class="position-absolute" style="right: 20px;top: 16px;color: #c7c7cf;">
                                <vue-feather type="search" size="18"/>
                            </span>
                        </div>
                    </div>
<!--                    <div class="container grid-container" id="productView">-->
                    <div class="container grid-container" :class="listView ? 'list-view' : ''">
                        <div class="row match-height">
                            <div class="col-12 col-md-6 col-lg-3 product-card-hover" v-for="item in products.data" :key="'item-'+item?.id">
                                <div class="card ecommerce-card position-relative" @dblclick="copyToClipboard(item?.slug)">
                                    <div class="item-img text-center">
                                        <a href="#">
                                            <img class="img-fluid card-img-top p-2 object-fit-contain" style="max-height: 250px" :src="item?.thumbnail" alt="img-placeholder">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="btn-group dropstart position-absolute" style="border: none; background: inherit;top: 9px !important;right: 4px !important;">
                                            <button class="border-0 bg-white" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <vue-feather type="more-vertical" />
                                            </button>

                                            <div class="dropdown-menu p-0 dropstart" aria-labelledby="dropdownMenuButton">
                                                <a :href="`${props.main_url}/${item?.slug}`" class="dropdown-item d-flex align-items-center text-info w-100" type="button">
                                                    <vue-feather type="edit" size="15"/>
                                                    <span class="ms-1">Edit</span>
                                                </a>
                                                <button class="dropdown-item d-flex align-items-center text-danger w-100"
                                                        type="button" @click="deleteItem(props.main_url, item?.id)">
                                                    <vue-feather type="trash" size="15"/>
                                                    <span class="ms-1">Delete</span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="item-wrapper d-flex align-items-center justify-content-between"  :class="listView ? 'me-5' : ''">

                                            <div>
                                                <h6 class="item-price">{{ item?.price }}</h6>
                                            </div>
                                        </div>

                                        <h6 class="item-name">
                                            <h4 class="text-body text-capitalize text-primary pb-1 d-block">{{ item?.title?.slice(0, 25)+"..." }}</h4>
                                            <span class="card-text item-company d-block" v-if="listView">
                                                By
                                                <span class="company-name text-primary">{{ item?.category.title }}</span>
                                            </span>
                                        </h6>
                                        <p class="card-text item-description" v-html="`${item?.description?.slice(0, 50) ?? '...'}...`"></p>
                                    </div>
                                </div>
                            </div>
                            <Pagination :links="products.links" :from="products.from" :to="products.to" :total="products.total" notShowNumber/>
                        </div>
                    </div>
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
            max-width: 50%;
            flex: 0 0 50%;
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

.ecommerce-application .grid-view .ecommerce-card .item-img {
    padding-top: 0.5rem;
    min-height: 15.85rem;
    display: flex;
    align-items: center;
}

.product-card-hover{
    transition: 0.1s all ease;
}
.product-card-hover:hover {
    scale: 1.02;
}
.product-card-hover:hover .card{
    box-shadow: 0 4px 15px 0 rgb(57 57 70 / 53%);
}

</style>
