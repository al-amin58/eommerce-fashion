<template>
    <Carousel :breakpoints="breakpoints">
        <Slide v-for="item in props.products" :key="item.id">
            <StarTProducts :product="item"/>
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
    import ProductCard from "./ProductCard.vue";
    import StarTProducts from "../Pages/StarTProducts.vue";


    const props = defineProps({
        products:{
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
        300: {
            itemsToShow: 1.3,
            snapAlign: 'center',
        },
        700: {
            itemsToShow: 3,
            snapAlign: 'end',
        },
        1024: {
            itemsToShow: 4,
            snapAlign: 'end',
            mouseDrag: true,
            pagination:false,
            autoplay:1000
        }
    }
</script>

<style scoped>
.carousel__slide{
    margin: 0 20px;
    display: flex;
    flex-flow: column;
}

.ecommerce-card{
    box-shadow: 0 0px 14px -1px rgb(34 41 47 / 32%) !important;
    margin-top: 18px !important;
    transition: 0.3s all ease;
    flex: 1 1 auto;
}

.ecommerce-card img{
    transition: 0.3s all ease;
}
.ecommerce-card:hover{
    box-shadow: 0 0px 14px 2px rgb(34 41 47 / 54%) !important;
    transform: scale(1.04);
}

.ecommerce-card:hover .item-name a{
    color: var(--bs-primary);
}
.ecommerce-card:hover img{
    transform: scale(1.4);
}

</style>
