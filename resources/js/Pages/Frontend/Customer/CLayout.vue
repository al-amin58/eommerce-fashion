<script setup>
import Layout from "../../Frontend/Shared/Layout.vue";
import UserImageWithUpload from "./UserImageWithUpload.vue"
</script>

<template>
    <Layout>
        <div class="container-lg pb-5 mb-2 mb-md-4">
        <div class="row">
            <!-- Sidebar-->
            <aside class="col-lg-4 pt-4 pt-lg-0 pe-xl-5 d-lg-block d-none">
                <div class="bg-white rounded-3 pt-1 mb-5 mb-lg-0 h-100" style="border:1px solid #ebebeb">
                    <div class="d-flex flex-column align-items-center justify-content-center gap-1">
                        <UserImageWithUpload/>
                        <div>
                            <strong class="m-0">{{ $page.props.auth.user?.name }}</strong>
                            <p class="m-0">{{ $page.props.auth.user?.email }}</p>
                            <p class="m-0">{{ $page.props.auth.user?.phone }}</p>
                        </div>
                    </div>
                    <div class="d-lg-block collapse" id="account-menu">
                        <div class="bg-secondary px-4 py-3">
                            <h3 class="fs-sm mb-0 text-muted">Dashboard</h3>
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="border-bottom mb-0">
                                <a class="nav-link-style d-flex align-items-center px-4 py-1 active" href="/dashboard">
                                    <vue-feather class="me-2" type="shopping-bag"/>
                                    Orders
                                    <span class="fs-sm text-primary ms-auto">
                                        <vue-feather type="arrow-right"/>
                                    </span>
                                </a>
                            </li>

                            <li class="border-bottom mb-0">
                                <a class="nav-link-style d-flex align-items-center px-4 py-1 active" href="/customer/profile">
                                    <vue-feather class="me-2" type="user"/>
                                    Profile info
                                    <span class="fs-sm text-primary ms-auto">
                                        <vue-feather type="arrow-right"/>
                                    </span>
                                </a>
                            </li>
                            <li class="border-bottom mb-0">
                                <a class="nav-link-style d-flex align-items-center px-4 py-1 active" href="/customer/address">
                                    <vue-feather class="me-2" type="radio"/>
                                    Address
                                    <span class="fs-sm text-primary ms-auto">
                                        <vue-feather type="arrow-right"/>
                                    </span>
                                </a>
                            </li>
                            <li class="border-bottom mb-0">
                                <a class="nav-link-style d-flex align-items-center px-4 py-1 active" href="/logout">
                                    <vue-feather class="me-2" type="log-out"/>
                                    Logout
                                    <span class="fs-sm text-primary ms-auto">
                                        <vue-feather type="arrow-right"/>

                                    </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </aside>
            <!-- Content  -->
            <section class="col-lg-8">
                <slot></slot>
            </section>
        </div>
    </div>
    </Layout>
</template>
