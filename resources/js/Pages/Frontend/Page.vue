<script setup>
import Layout from "../Frontend/Shared/Layout.vue";
import {usePage, Head} from "@inertiajs/inertia-vue3";
import {computed} from 'vue'
    defineProps({
        info:[]|null,
    })


</script>


<template>
    <Head>
        <meta property="og:title" :content="info.seo.title">
        <meta property="og:description" :content="info.seo.description">
        <meta property="og:image" :content="info.seo.icon">
        <meta property="og:url" :content="$page.props.auth.MAIN_URL">
        <meta property="og:type" content="webiste">

        <meta property="twitter:title" :content="info.seo.title">
        <meta property="twitter:description" :content="info.seo.description">
        <meta property="twitter:image" :content="info.seo.icon">
        <meta property="twitter:url" :content="$page.props.auth.MAIN_URL">
        <meta property="twitter:type" content="webiste">
    </Head>
    <Layout >

        <div class="container my-5">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="display-4 fw-bolder text-black text-capitalize">{{ info?.title }}</h2>
                            <p class="mt-3" v-html="info?.summery"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </Layout>
</template>

<style scoped>

</style>
