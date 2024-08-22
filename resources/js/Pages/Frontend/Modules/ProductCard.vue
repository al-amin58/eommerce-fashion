<template>
    <div class="card ecommerce-card position-relative shadow-sm">
        <div class="item-img overflow-hidden">
            <img class="img-fluid card-img-top p-2" style="max-height: 250px" :src="item.thumbnail" alt="img-placeholder">
        </div>
        <div class="text-start p-1 zindex-1 match-height">
            <h2>
                <a class="text-primary" :href="`/product/single-product/${item.slug}`">{{ item.title.slice(0, 28) }}</a>
            </h2>
            <h6 class="item-price">{{ item.price}} ৳</h6>
            <p class="card-text  item-description" v-html="`${item.description.slice(0, 50)}...`"></p>
        </div>
    </div>
</template>

<script setup>
    defineProps({
        item:{
            type:Object,
            required:true
        }
    })
</script>

<style scoped>

</style>
