<template>
    <div class="input-group input-group-lg bootstrap-touchspin">
        <span class="input-group-btn bootstrap-touchspin-injected">
            <button @click="store.decrementQty(props.productId)"
                    :disabled="store.cart.find(item => item.id === props.productId)?.quantity === 1"
                    class="btn btn-primary bootstrap-touchspin-down"
                    type="button">
                <vue-feather type="minus"/>
            </button>
        </span>
        <input type="number" class="touchspin form-control"
               :value="store.cart.find(item => item.id === props.productId)?.quantity"
               :max="store.cart.find(item => item.id === props.productId)?.quantity"
               :min="1"
               readonly
        >
        <span class="input-group-btn bootstrap-touchspin-injected">
            <button @click="store.incrementQty(props.productId)"
                    :disabled="store.cart.find(item => item.id === props.productId)?.quantity >= props.maxQty"
                    class="btn btn-primary bootstrap-touchspin-up"
                    type="button">
                <vue-feather type="plus"/>
            </button>
        </span>
    </div>
</template>

<script setup>


    import {useCartStore} from "../Store/useCartStore";

    const props = defineProps({
        productId:{
            type:Number,
            required:true
        },
        maxQty:{
            type:Number,
            required:true
        }
    })
    const store = useCartStore();
</script>

<style scoped>

</style>
