<script setup>
import layout from "../Shared/Layout.vue";
import Pagination from "../../../components/Pagination.vue";
import Products from '../Pages/StarTProducts.vue'
import {ref, watch} from 'vue'
import {Inertia} from "@inertiajs/inertia";
import debounce from "lodash/debounce";
import PriceRangeSlider from "../../../components/PriceRangeSlider.vue";

const props = defineProps({
    products: [] | null,
    category: null,
    categories:[]|null,
    brands:[]|null,
    filters: Object,
    checkCondition:"null"|null,
    main_url: String | null,
})


const currentUrl = window.location;


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

const minPriceFilter = (event)=>{
    Inertia.get(props.main_url, {priceRange:event},{preserveState: true, replace: true});
}

const conditionFilter = (event)=>{
    Inertia.get(props.main_url, {condition:event},{preserveState: true, replace: true});
}







let search = ref(props.filters?.search);
let orderBy = ref(props.filters?.perPage);

watch([search, orderBy], debounce(function ([val, val2]) {
    Inertia.get(props.main_url, {search: val, orderBy: val2}, {preserveState: true, replace: true});
}, 300));


</script>

<template>
    <layout :search="props.filters">
        <Head title="Filters products"/>
        <section class="app-user-list my-5 sm-mt">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 d-none d-md-block">
                                <div class="card mt-1">
                                    <div class="card-body page-shadow">
                                        <p class="fw-bolder m-0 card-title mb-2">Price Range</p>
                                        <PriceRangeSlider @changePriceRange="minPriceFilter" :minValue="1000"/>
                                    </div>
                                </div>
                                <div class="card mt-1 filter-body relative">
                                    <div class="card-body page-shadow">
                                        <p class="fw-bolder m-0 card-title mb-2 bg-white ">Filter By Categories</p>
                                        <div>
                                            <div v-for="(parent_category, i) in props.categories" class="accordion border-b rounded-0" :id="`accordionExample${i}`" :key="`category_item-${i}`">
                                                <div class="accordion-item">
                                                    <div class="accordion-header" :id="`heading${i}`">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <a class="text-black" :href="`/products?category=${parent_category.slug}`">{{ parent_category.title }}</a>
                                                            <button v-if="parent_category?.sub_categories?.length > 0" class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                    :data-bs-target="`#collapse-${i}`" aria-expanded="true"
                                                                    :aria-controls="`collapse-${i}`"></button>
                                                        </div>
                                                    </div>
                                                    <div :id="`collapse-${i}`" class="accordion-collapse collapse" :aria-labelledby="`heading${i}`" :data-bs-parent="`#accordionExample${i}`">
                                                        <div class="accordion-body">
                                                            <div v-for="(sub_cateogtry, j) in parent_category?.sub_categories" class="accordion" :id="`acordionSubCategory${j}`" :key="`sub_category_item-${j}`">
                                                                <div class="accordion-item">
                                                                    <div class="accordion-header" :id="`subCategoryItem${j}`">
                                                                        <div class="d-flex align-items-center justify-content-between">
                                                                            <a class="text-black" :href="`/products?sub_category=${sub_cateogtry.slug}`">{{ sub_cateogtry.title }}</a>
                                                                            <button v-if="sub_cateogtry?.child_categories?.length > 0" class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                                    :data-bs-target="`#subCategoryChildItem${j}`" aria-expanded="true" aria-controls="collapseOne"></button>
                                                                        </div>
                                                                    </div>
                                                                    <div :id="`subCategoryChildItem${j}`" class="accordion-collapse collapse" :aria-labelledby="`subCategoryItem${j}`"
                                                                         :data-bs-parent="`#acordionSubCategory${j}`">
                                                                        <div class="accordion-body">
                                                                            <div class="accordion" v-for="(childCategory, k) in sub_cateogtry?.child_categories" :key="`childItem${k}`">
                                                                                <div class="accordion-item">
                                                                                    <a :href="`/products?child_category=${childCategory.slug}`">{{ childCategory.title }}</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-1 filter-body relative">
                                    <div class="card-body page-shadow">
                                        <p class="fw-bolder m-0 card-title mb-2 bg-white">Filter By Brands</p>
                                        <div>
                                            <div class="accordion" v-for="(item, k) in props.brands" :key="`childItem${k}`">
                                                <div class="accordion-item">
                                                    <a class="text-black" :href="`${props.main_url}&brand=${item.slug}`">{{  item.name ?? item }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="card rounded-5 shadow-none">
                                    <div class="py-1 rounded-5 card-body page-shadow d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="fw-bolder text-black m-0">{{ category?.title }}</h4>
                                        </div>
                                        <div class="col-md-2 d-none d-md-block">
                                            <select v-model="orderBy"
                                                    class="form-control border-0 shadow-none bg-primary text-white">
                                                <option :value="undefined">Sorting</option>
                                                <option value="price_low_high">Price Low To High</option>
                                                <option value="price_high_low">Price High To Low</option>
                                                <option value="newest_first">Newest First</option>
                                                <option value="oldest_first">Oldest First</option>
                                            </select>
                                        </div>
                                        <button class="bg-primary text-white border-none rounded d-block d-md-none"
                                                data-bs-toggle="modal"
                                                data-bs-target="#showFilters"
                                        >
                                            <vue-feather type="filter" size="10"/>
                                        </button>
                                    </div>
                                </div>

                                <div class="row match-height home-featured-product" v-if="products.data.length > 0">
                                    <div class="col-lg-4 mb-1 col-md-3 col-sm-6 product-item p-lg-5px"
                                        :class="i % 2 === 0? 'pr-m-5': 'pl-m-5'"
                                        v-for="item in products.data"
                                        :key="'item-'+item.id">
                                    <Products :product="item.product"/>
                                    </div>
                                    <Pagination :links="products.links" :from="products.from" :to="products.to"
                                                :total="products.total" notShowNumber/>
                                </div>
                                <div class="text-black fs-4 fw-semibold"  v-else>
                                    No Product Found
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>


        <div class="modal modal-slide-in fade sm-cart-modal" id="showFilters" aria-hidden="true" v-vb-is:modal>
            <div class="modal-dialog sm-cart-width">
                <div class="modal-content p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title d-flex justify-content-between">
                            Filters
                        </h5>
                    </div>
                    <div class="modal-body d-flex flex-column justify-content-between flex-grow-1">
                        <div class="card">
                            <div class="card-body page-shadow">
                                <p class="fw-bolder m-0 card-title">Condition</p>
                                <div class="btn-group mt-2" role="group" aria-label="Basic example">
                                    <button @click="conditionFilter('null')" href="javascript:void(0)" type="button" class="btn border-primary"
                                            style="border-left-color: var(--bs-primary) !important" :class="
                                               props.checkCondition === 'null' ||
                                               props.checkCondition === null ||
                                               props.checkCondition === '' ||
                                               props.checkCondition === undefined ? 'btn-primary' : ''">See All</button>
                                    <button @click="conditionFilter('used')" href="javascript:void(0)" type="button"
                                            class="btn border-primary" :class="{'btn-primary' : props.checkCondition === 'used'}">Used</button>
                                    <button @click="conditionFilter('new')" href="javascript:void(0)" type="button" class="btn border-primary"
                                            style="border-right-color: var(--bs-primary) !important" :class="{'btn-primary' : props.checkCondition === 'new'}">New</button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body page-shadow">
                                <select v-model="orderBy"
                                        class="form-control border-0 shadow-none bg-primary text-white">
                                    <option :value="undefined">Sorting</option>
                                    <option value="price_low_high">Price Low To High</option>
                                    <option value="price_high_low">Price High To Low</option>
                                    <option value="newest_first">Newest First</option>
                                    <option value="oldest_first">Oldest First</option>
                                </select>
                            </div>
                        </div>
                        <div class="card mt-1">
                            <div class="card-body page-shadow">
                                <p class="fw-bolder m-0 card-title mb-2">Price Range</p>
                                <PriceRangeSlider @changePriceRange="minPriceFilter" :minValue="1000"/>
                            </div>
                        </div>
                        <div class="card mt-1 filter-body relative">
                            <div class="card-body page-shadow">
                                <p class="fw-bolder m-0 card-title mb-2 sticky-top bg-white">Filter By Categories</p>
                                <div>
                                    <div v-for="(parent_category, i) in props.categories" class="accordion border-b rounded-0" :id="`accordionExample${i}`" :key="`category_item-${i}`">
                                        <div class="accordion-item">
                                            <div class="accordion-header" :id="`heading${i}`">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <a :href="`/products?category=${parent_category.slug}`">{{ parent_category.title }}</a>
                                                    <button v-if="parent_category?.sub_categories?.length > 0" class="accordion-button" type="button" data-bs-toggle="collapse"
                                                            :data-bs-target="`#collapse-${i}`" aria-expanded="true"
                                                            :aria-controls="`collapse-${i}`"></button>
                                                </div>
                                            </div>
                                            <div :id="`collapse-${i}`" class="accordion-collapse collapse" :aria-labelledby="`heading${i}`" :data-bs-parent="`#accordionExample${i}`">
                                                <div class="accordion-body">
                                                    <div v-for="(sub_cateogtry, j) in parent_category?.sub_categories" class="accordion" :id="`acordionSubCategory${j}`" :key="`sub_category_item-${j}`">
                                                        <div class="accordion-item">
                                                            <div class="accordion-header" :id="`subCategoryItem${j}`">
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <a :href="`/products?sub_category=${sub_cateogtry.slug}`">{{ sub_cateogtry.title }}</a>
                                                                    <button v-if="sub_cateogtry?.child_categories?.length > 0" class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                            :data-bs-target="`#subCategoryChildItem${j}`" aria-expanded="true" aria-controls="collapseOne"></button>
                                                                </div>
                                                            </div>
                                                            <div :id="`subCategoryChildItem${j}`" class="accordion-collapse collapse" :aria-labelledby="`subCategoryItem${j}`"
                                                                 :data-bs-parent="`#acordionSubCategory${j}`">
                                                                <div class="accordion-body">
                                                                    <div class="accordion" v-for="(childCategory, k) in sub_cateogtry?.child_categories" :key="`childItem${k}`">
                                                                        <div class="accordion-item">
                                                                            <a :href="`/products?child_category=${childCategory.slug}`">{{ childCategory.title }}</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-1 filter-body relative">
                            <div class="card-body page-shadow">
                                <p class="fw-bolder m-0 card-title mb-2 sticky-top bg-white">Filter By Brands</p>
                                <div>
                                    <div class="accordion" v-for="(item, k) in props.brands" :key="`childItem${k}`">
                                        <div class="accordion-item">
                                            <a :href="`${props.main_url}&brand=${item.slug}`">{{  item.name ?? item }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </layout>
</template>

<style lang="scss" scoped>
.card {
    margin-bottom: 1rem;
}
.filter-body{
    max-height: 30rem;
    overflow-y: scroll;
}
.accordion-button{
    width:auto !important;
}
.accordion {
    padding:10px 6px;
    border-bottom:1px solid #f2f4f8;
}
.accordion:last-child{
    border-bottom:none;
}
//.accordion-item{
//    padding:10px 6px;
//    border-bottom:1px solid gray;
//}
.accordion-item .accordion-button{
    padding: 0 !important;
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

.card-shadow {
    box-shadow: 0 0px 14px -1px rgb(34 41 47 / 32%) !important;
}

</style>
