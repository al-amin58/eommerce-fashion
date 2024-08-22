<template>
    <Layout>
        <div class="container" style="min-height: 100vh;">
            <div class="row">
                <div class="col-md-8 mx-auto my-5">
                    <div class="d-flex align-items-center gap-1">
                        <div class="bg-white user-image">
                            <vue-feather type="user" size="55"/>
                        </div>
                        <div>
                            <p class="m-0 fs-4 fw-semibold">Hello,</p>
                            <h2 class="fs-2 fw-bolder text-black text-capitalize">{{ $page.props.auth.user?.name }}</h2>
                        </div>
                    </div>
                    <hr>
                    <slot/>
                </div>
            </div>
        </div>
    </Layout>
</template>
<script setup>
    import Layout from "../Shared/Layout.vue";
</script>
<style scoped>
    .user-image{
        padding: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 30px -7px #e5e5e5;
    }
</style>
