<template>
    <CustomerLayout>
        <div class="row user-dashboard">
            <div class="col-md-3 col-6">
                <a href="/customer/orders">
                    <div class="card page-shadow">
                        <div class="flex-column card-body d-flex align-items-center justify-content-center">
                            <div class="bg-primary text-white single-card">
                                <vue-feather type="shopping-bag" size="20"/>
                            </div>
                            <p class="fs-4 fw-bold mt-1">Orders</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="/customer/profile">
                    <div class="card page-shadow">
                        <div class="flex-column card-body d-flex align-items-center justify-content-center">
                            <div class="bg-primary text-white single-card">
                                <vue-feather type="user" size="20"/>
                            </div>
                            <p class="fs-4 fw-bold mt-1">Profile</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="/customer/change-password">
                    <div class="card page-shadow">
                        <div class="flex-column card-body d-flex align-items-center justify-content-center">
                            <div class="bg-primary text-white single-card">
                                <vue-feather type="lock" size="20"/>
                            </div>
                            <p class="fs-4 fw-bold mt-1">Password</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="/customer/address">
                    <div class="card page-shadow">
                        <div class="flex-column card-body d-flex align-items-center justify-content-center">
                            <div class="bg-primary text-white single-card">
                                <vue-feather type="map-pin" size="20"/>
                            </div>
                            <p class="fs-4 fw-bold mt-1">Address</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="/customer/wishlist">
                    <div class="card page-shadow">
                        <div class="flex-column card-body d-flex align-items-center justify-content-center">
                            <div class="bg-primary text-white single-card">
                                <vue-feather type="heart" size="20"/>
                            </div>
                            <p class="fs-4 fw-bold mt-1">Wishlist</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="/logout">
                    <div class="card page-shadow">
                        <div class="flex-column card-body d-flex align-items-center justify-content-center">
                            <div class="bg-primary text-white single-card">
                                <vue-feather type="log-out" size="20"/>
                            </div>
                            <p class="fs-4 fw-bold mt-1">Logout</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import CustomerLayout from "./Layout.vue";

</script>

<style scoped>
.single-card{
    border-radius: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem !important;
}
.user-dashboard .card .card-body{
    border:1px solid white;
}
.user-dashboard .card .card-body:hover{
    border: 1px solid var(--bs-primary);
}
</style>
