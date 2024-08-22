<script setup>
    import 'vue3-carousel/dist/carousel.css'
    import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
    import {computed, onMounted, ref} from 'vue'
    import Layout from "./Shared/Layout.vue";
    import Products from "./Pages/StarTProducts.vue";
    import {useDataStore} from "../../Store/useDataStore";
    import {useCartStore} from "../../Store/useCartStore";

    const store = useDataStore();
    const cartStore = useCartStore();

    const props = defineProps({
        homeProducts:[]|null,
        featuredCategories:[]|null,
        sliders:[]|null,
        advised:[]|null,
        homeContent:String|null,
        pageData:[]|null,
    })

    const sliders = ref({pagination:false, navigation:false,})


    const slides = computed(() =>{
        if (props.banners[0]?.info){
            return JSON.parse(props.banners[0]?.info);
        }
    })
    onMounted(()=>{
        store.initFeaturedCategories()
        cartStore.initCart()
    })
    import b1 from "../../../images/psc/b1.jpg"
    import b2 from "../../../images/psc/b2.jpg"
    import b3 from "../../../images/psc/b3.jpg"
    import b4 from "../../../images/psc/PolyScience-Logo.png"
    import b5 from "../../../images/psc/President-Message.jpg"
    import b6 from "../../../images/psc/RADWAG.jpg"
    import b7 from "../../../images/psc/Rocker-Logo.png"
    import b8 from "../../../images/psc/TOP6.jpg"
    import b9 from "../../../images/psc/YL-Instrument.png"
    const images = [b3,b4,b5,b1,b2,b5,b1,b2,b3,b4,b5,b6,b7,b8,b9]


</script>

<template>
    <Head title="Home" />
    <Layout>
        <div class="bg-white page-shadow">
            <div class="container">
                <section>
                    <div class="row">
                        <div class="col-12 p-sm-0">
                            <div class="row match-height slider-section ms-auto">
                                <Carousel :autoplay="5000" :wrap-around="true" v-if="true">
                                    <Slide v-for="slide in props.sliders" :key="slide">
                                        <div class="carousel__item">
                                            <img :src="`/storage/${slide.image}`" alt="">
                                        </div>
                                    </Slide>
                                    <template #addons>
                                        <Navigation/>
                                        <Pagination/>
                                    </template>
                                </Carousel>
                                <Carousel :wrap-around="true" v-else>
                                    <Slide v-for="slide in props.sliders" :key="slide">
                                        <div class="carousel__item">
                                            <img :src="`/storage/${slide.image}`" alt="">
                                        </div>
                                    </Slide>
                                    <template #addons>
                                        <Navigation/>
                                        <Pagination/>
                                    </template>
                                </Carousel>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="container">
            <section id="featured-categories" >
                <div class="text-center my-5">
                    <h2 class="text-black fw-bolder">Featured Category</h2>
                    <p class="text-black">Get Your Desired Product from Featured Category!</p>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-6 mb-1" v-for="item in props.featuredCategories" style="padding-inline: 5px;">
                        <a :href="`/products?sub_category=${item.slug}`">
                            <div class="card page-shadow m-0  h-100 rounded-0">
                                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                                    <img :src="`${item.icon}`" alt="" style="width: 100px;height: 100px;" class="mb-1">
                                    <a class="fw-bolder text-black" :href="`/products?sub_category=${item.slug}`">{{ item.title }}</a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </section>




            <section id="dashboard-ecommerce" class="sm-mt-15-rem-min">
                <div class="text-center my-5 text-black">
                    <h2 class="text-black fw-bolder">Featured Products</h2>
                    <p class="text-black">Check & Get Your Desired Product!</p>
                </div>
                <div class="row match-height home-featured-product">
                    <div class="col-lg-3 col-md-3 product-item p-lg-5px"
                         :class="i % 2 === 0? 'pr-m-5': 'pl-m-5'"
                         v-for="(product, i) in props.homeProducts">
                        <Products :product="product"/>
                    </div>
                </div>
            </section>
            <section id="category-with-details" class="sm-mt-15-rem-min mt-3 mb-5" >
                <div class="home-seo-content" style="text-align: justify" v-html="props.homeContent"></div>
            </section>
        </div>
    </Layout>
</template>


<style>
.carousel__pagination-button::after {
    width: 2rem !important;
    height: 10px !important;
}
.carousel .carousel__prev{
    background: #01020457;
    position: absolute;
    left: 21px;
    color: black;
    border-radius: 50%;
    width: 4rem;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 4rem;
}
.carousel .carousel__next{
    background: #01020457;
    position: absolute;
    right: 21px;
    color: black;
    border-radius: 50%;
    width: 4rem;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 4rem;
}
</style>

<style scoped>

.carousel__item, .carousel__item img{
    width: 100% !important;
    height: 100% !important;
}
.header-before::before,
.header-before::after{
    display: inline-block;
    content: "";
    border-top: .1rem solid var(--bs-primary);
    width: 10rem;
    margin: 0 1rem;
    transform: translateY(-1rem);


}


.ads-bg{
    background:#f2f4f8;
}



#featured-categories .display-grid{
    display: grid;
    grid-template-columns: auto auto auto auto auto auto auto auto;
    grid-template-rows: auto auto;
    gap: 1rem 1rem;
}

#featured-categories .display-grid .single-item .card{
    margin-bottom: 2rem;
    /*box-shadow: 0 5px 5px -4px #0c1e2c;*/
    transition: all 0.3s ease-in-out, background 0s, color 0s, border-color 0s;
    border-radius: 20px;
}
#featured-categories .display-grid .single-item .card-body{
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    gap: 1rem;
    text-align: center;
}

.home-ads{
    overflow-y: scroll;
    max-height: 381px;
}
</style>
