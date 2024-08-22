<template>
    <Layout>
        <section>

            <div class="row mx-auto">
                <div class="col-md-12 mx-auto">
                    <img :src="props.category.banner" alt="" class="w-100 details-banner-h" style="object-fit: unset;">

                    <div class="category-details mt-5">
                        <h3>
                            <a :href="`${$page.props.auth.MAIN_URL}/category/${props.category?.category?.slug}`" v-if="props.category.category">{{ props.category?.category?.title }}  </a>
                            <span v-if="props.category.category"> > </span>

                            <a :href="`${$page.props.auth.MAIN_URL}/sub-category/${props.category?.sub_category?.slug}`" v-if="props.category.sub_category">{{ props.category?.sub_category?.title }}  </a>
                            <span v-if="props.category.sub_category"> > </span>

                            <a class="text-underline" :href="`${$page.props.auth.MAIN_URL}/child-category/${props.category.slug}`">
                                {{ props.category.title }}
                            </a>
                        </h3>
                    </div>

                    <div class="row match-height gap-3 px-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-center cat-box text-center"
                             v-if="props.category.sub_categories?.length > 0 ||
                             props.category.child_categories?.length > 0" v-for="cat in props.category.sub_categories || props.category.child_categories">
                            <a :href="props.category.sub_categories?.length > 0 ? `${$page.props.auth.MAIN_URL}/sub-category/${cat?.slug}` : `${$page.props.auth.MAIN_URL}/child-category/${cat?.slug}`">
                                <img class="mb-1" :src="cat.icon" alt="" style="max-width: 100%;">
                                <p>{{ cat?.title }}</p>
                            </a>
                        </div>
                    </div>



                    <div class="row match-height mt-4">
                        <h2>{{ props.category.title }} All Poducts</h2>
                        <div class="col-lg-3 mb-4 col-md-3 product-item" v-for="product in props.category.products">
                            <Products :product="product" v-if="product"/>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </Layout>
</template>

<script setup>

    import Products from './ChaldalProducts.vue'
    import Layout from '../Shared/Layout.vue'
    const props = defineProps({
        category:null,
    })

</script>
<style scoped>

.category-details h3 a:hover{
    text-decoration: underline;
}
.cat-box{
    box-shadow: 2px 1px 12px 0px #ffdac3;
    padding: 2rem;
    border-radius: 15px;
    transition: 0.3s all ease;
}
.cat-box:hover{
    box-shadow:none;
}
</style>
