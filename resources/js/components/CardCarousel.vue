<template>
    <Carousel  :breakpoints="breakpoints"  :items-to-show="2.5" :wrap-around="true">
        <Slide :style="{ backgroundImage: `url(${item.banner})` }" v-for="item in props.categories" :key="item.id">
            <a class="carousel__item" :href="`/products?category=${item.slug}`" >
                <div class="card w-100 h-100 m-0 p-0">
                    <div class="row m-0 h-100 match-height">
                        <div class="col-md-4 image">
                            <img :src="item.icon" class="img-fluid rounded-start" />
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-white text-capitalize">{{ item.title }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </Slide>

        <template #addons>
            <Navigation v-if="props.navigation"/>
            <Pagination v-if="props.pagination"/>
        </template>
    </Carousel>
</template>

<script setup>

    import { defineComponent } from 'vue'
    import { Carousel, Navigation, Slide, Pagination } from 'vue3-carousel'
    import 'vue3-carousel/dist/carousel.css'


    const props = defineProps({
        categories:{
            type:Array,
            required:true,
        },
        navigation:{
            type:Boolean,
            default:false
        },
        pagination:{
            type:Boolean,
            default:false
        }
    })
    const settings = {itemsToShow: 1, snapAlign: 'center'}
    const breakpoints = {
        700: {
            itemsToShow: 3.5,
                snapAlign: 'center',
        },
        1024: {
            itemsToShow: 6,
            snapAlign: 'start'
        }
    }
</script>

<style scoped>
    .carousel__viewport ol{
        margin-top:15px !important;
        margin-bottom:15px !important;
    }
    .carousel__slide{
        margin: 0 10px;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 0 11px 1px #7878784f !important;
    }
    .carousel__item .card .row{
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .carousel__item .card .image{
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }
    .carousel__item .card{
        background: transparent;
    }
    .carousel__item {
        height: 100px;
        width: 100%;
        font-size: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(9deg, #00000047, #00000033);
        backdrop-filter: blur(20px);
        place-items: center;
        box-shadow: 0px 0px 16px 0px rgb(167 167 167 / 80%);
        color: white;
    }
    .carousel__item img{
        max-height: 100px;
    }
</style>
