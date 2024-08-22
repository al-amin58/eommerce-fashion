<script setup>

import {onMounted} from "vue";
import {useDataStore} from "../../../Store/useDataStore";



const store = useDataStore();

onMounted(() =>[
    store.initTopCategories()
])
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-light  p-0 page-shadow pb-1">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mx-5 bg-primary rounded shadow" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-2">
                    <li class="nav-item first-lavel-cat fw-semibold p-0"  :class="{'dropdown' : category.sub_categories.length}" v-for="(category, count) in store.getTopCategories">
                        <a class="nav-link fw-semibold text-white " style="padding: 10px;" :href="`/products?category=${category.slug}`">{{ category.title }}</a>

                        <ul class="dropdown-menu sub-cat-border p-0 page-shadow mt-0"  :class="count < 8 ? '': 'left-minus'" v-if="category.sub_categories.length">
                            <li class="nav-item" :class="count < 8 ? 'dropend' : 'dropstart'" v-for="category in category.sub_categories">

                                <a class="dropdown-item text-black fw-bolder" :href="`/products?sub_category=${category.slug}`">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>
                                            {{ category.title }}
                                        </span>
                                        <vue-feather v-if="category.child_categories.length" type="chevron-right" size="18"/>
                                    </div>
                                </a>
                                <ul class="dropdown-menu p-0 page-shadow" v-if="category.child_categories.length">
                                    <li v-for="category in category.child_categories" :key="'child-'+category.id">
                                        <a class="dropdown-item text-black fw-bolder" :href="`/products?child_category=${category.slug}`">{{ category.title }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<style scoped>
.navbar-nav .nav-link{
    color: black;
}
.dropend .dropdown-toggle{
    color: black;
    margin-left: 1em;
}
.dropdown-item:hover, .sub-cat-border .dropdown-toggle:hover{
    background-color: var(--bs-primary);
    color: #fff !important;
}
.dropdown .dropdown-menu, .dropdown .dropdown-start{
    display: none;
}
.dropdown:hover > .sub-cat-border{
    border-top: 4px solid var(--bs-primary);
}
.dropdown:hover > .dropdown-menu, .dropend:hover > .dropdown-menu, .dropstart:hover .dropdown-menu{
    display: block;
    margin-top: 15px;
    margin-left: 0.125em;
    border-radius: 0;
    min-width: 250px;
}
.dropdown:hover > .left-minus{
    margin-left: 0 !important;
    left:-150% !important;
}
.dropend .dropdown-toggle{
    padding: 10px 1rem !important;
    margin-left: 0;
}
.dropstart .dropdown-toggle{
    padding: 10px 1rem !important;
    margin-left: 0;
}

.dropdown-menu, .dropdown-start {
    transform: none;
}
.navbar-nav .first-lavel-cat{
    padding: 15px 10px;
}
@media screen and (min-width:769px) {
    .dropend:hover > .dropdown-menu{
        position: absolute;
        top: -24px;
        left: 99%;
        box-shadow: none;
    }

    .dropstart:hover > .dropdown-menu{
        position: absolute;
        top: -24px;
        right: 99%;
        box-shadow: none;
    }
}
.dropdown-toggle:after{
    background-image: none !important;
}
#thumbnails .row{
    padding-right: 0 !important;
}
</style>
