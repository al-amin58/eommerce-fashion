<script setup>
    defineProps({
        item:{
            type:Object,
            required:true,
        }
    })
</script>

<template>
    <div class="card ecommerce-card">
        <div class="item-img">
            <a href="#">
                <img :src="item.thumbnail" alt="img-placeholder" />
            </a>
        </div>
        <div class="card-body">
            <div class="item-name">
                <h6 class="mb-0">
                    <a href="app-ecommerce-details.html" class="text-body">{{ item.title }}</a>
                </h6>
                <span class="item-company">By <a href="#" class="company-name">Apple</a></span>
                <div class="item-rating">
                    <ul class="unstyled-list list-inline">
                        <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                        <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                        <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                        <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                        <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                    </ul>
                </div>
            </div>
            <span class="text-success mb-1">In Stock</span>
            <div class="item-quantity">
                <span class="quantity-title">Qty:</span>
                <div class="quantity-counter-wrapper">
                    <div class="input-group">
                        <input type="text" class="quantity-counter" :value="item.quantity" />
                    </div>
                </div>
            </div>
            <span class="delivery-date text-muted">Delivery by, Wed Apr 24</span>
            <span class="text-success">7% off 1 offers Available</span>
        </div>
        <div class="item-options text-center">
            <div class="item-wrapper">
                <div class="item-cost">
                    <h4 class="item-price">৳ {{ item.price }}</h4>
                    <p class="card-text shipping">
                        <span class="badge rounded-pill badge-light-success">Free Shipping</span>
                    </p>
                </div>
            </div>
            <button type="button" class="btn btn-light mt-1 remove-wishlist">
                <i data-feather="x" class="align-middle me-25"></i>
                <span>Remove</span>
            </button>
            <button type="button" class="btn btn-primary btn-cart move-cart">
                <i data-feather="heart" class="align-middle me-25"></i>
                <span class="text-truncate">Add to Wishlist</span>
            </button>
        </div>
    </div>
</template>



<style scoped>

</style>
