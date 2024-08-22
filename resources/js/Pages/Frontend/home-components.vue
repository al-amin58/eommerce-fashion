<template>

    <div class="row match-height mb-2" v-if="props.pageData.add1.status === true">
        <div class="col-lg col-sm-6" v-for="addItem in props.pageData.add1.items">
            <a :href="`${$page.props.auth.MAIN_URL}/products/ads-products?add=${addItem.slug}`">
                <img :src="addItem.image" class="card-img-top" alt="">
            </a>
        </div>
    </div>

    <div class="section-header row match-height mb-2 my-md-5 my-sm-1 p-md-2 p-sm-0 bg-light-info" v-if="props.pageData.add2.status === true">
        <h2 class="text-center display-4 fw-bolder text-primary text-uppercase my-2 header-before position-relative">
            {{ props.pageData.add2.title }}
        </h2>
        <div class="col-lg col-sm-12" v-for="addItem in props.pageData.add2.items">
            <a :href="`${$page.props.auth.MAIN_URL}/products/ads-products?add=${addItem.slug}`">
                <img :src="addItem.image" class="card-img-top" alt="">
            </a>
        </div>
    </div>

    <div class="row match-heigh mb-1" v-if="props.pageData.add4.status === true">
        <div class="col" v-for="addItem in props.pageData.add4.items">
            <a :href="`${$page.props.auth.MAIN_URL}/products/ads-products?add=${addItem.slug}`">
                <img :src="addItem.image" class="card-img-top" alt="">
            </a>
        </div>
    </div>




    <div class="row match-height  mb-2 my-md-5 my-sm-1 p-md-2 p-sm-0 bg-light-warning" v-if="props.pageData.topProducts.status === true">
        <h2 class="text-center display-4 fw-bolder text-primary text-uppercase my-2 header-before position-relative">
            {{ props.pageData.topProducts.title }}
        </h2>
        <product-carousel v-if=" props.pageData.topProducts.items.length > 0" :products="props.pageData.topProducts.items"/>
    </div>


    <div class="row match-height mb-2 my-5 p-2 bg-light-info" v-if="props.pageData.add2.status === true">
        <h2 class="text-center display-4 fw-bolder text-primary text-uppercase my-2 header-before position-relative">
            {{ props.pageData.add2.title }}
        </h2>
        <div class="col" v-for="addItem in props.pageData.add2.items">
            <a :href="`${$page.props.auth.MAIN_URL}/products/ads-products?add=${addItem.slug}`">
                <img :src="addItem.image" class="card-img-top" alt="">
            </a>
        </div>
    </div>




    <div class="row match-height my-5"
         v-for="(category, index) in  props.homeCategory" :key="category.id"
         v-if="props.pageData.topCategories.status === true">
        <h2 class="text-capitalize" v-if="category.products.length > 0" v-text="category.title"></h2>
        <product-carousel v-if="category.products.length > 0" :products="category.products"/>
    </div>

    <div class="row match-height mb-2 my-5 p-2 bg-light-secondary" v-if="props.pageData.add3.status === true">
        <h2 class="text-center display-4 fw-bolder text-primary text-uppercase my-2 header-before position-relative">
            {{ props.pageData.add3.title }}
        </h2>
        <div class="row match-height add-section-sm-gap">
            <div class="col-6 col-lg-3 col-md-3" v-for="addItem in props.pageData.add3.items">
                <a class="h-100" :href="`${$page.props.auth.MAIN_URL}/products/ads-products?add=${addItem.slug}`">
                    <img :src="addItem.image" class="card-img-top h-100" alt="">
                </a>
            </div>
        </div>
    </div>




    <div class="row match-height my-5"
         v-for="(category, index) in  props.pageData.homeCategories.items" :key="category.id"
         v-if="props.pageData.homeCategories.status === true" >
        <h2 class="text-center display-4 fw-bolder text-primary text-uppercase my-2 header-before position-relative" v-if="category.products.length > 0" >
            {{ category.title }}
        </h2>
        <product-carousel v-if="category.products.length > 0" :products="category.products"/>
    </div>


    <div class="row match-height mb-2">
        <h2 class="text-center display-4 fw-bolder text-primary text-uppercase my-2 header-before position-relative">
            Top Brands
        </h2>
        <div class="row gap-lg-0 banner-gyap">
            <div class="col-md-3 col-sm-3 col-6 col-lg-2" v-for="brand in props.featuredBrands">
                <a class="h-100" :href="`${$page.props.auth.MAIN_URL}/products?brand=${brand.slug}`">
                    <div class="card brand-card h-100" v-c-tooltip="brand.name">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <img :src="brand.icon" class="card-img-top" alt="">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>
