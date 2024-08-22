<script setup>
    const props = defineProps({
        title:{
            required:true,
            type:String
        },
        icon:{
            type:String,
            default:"info"
        },
        size:{
            type:String,
            default:"10",
        }
    })
</script>
<template>
    <span class="text-info ms-25 cursor-pointer" v-c-tooltip="props.title">
        <vue-feather :type="props.icon" :size="props.size"/>
    </span>
</template>
