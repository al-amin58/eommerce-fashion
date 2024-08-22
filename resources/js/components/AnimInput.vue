<script setup>
defineProps({
    modelValue:String,
    type:{
        type:String,
        default:"text"
    },
    label:{
        type:String,
        default:null,
        required:true
    }
})
const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <div class="form-floating">
        <input :type="type" class="form-control" :placeholder="label"  @input="$event => emit('update:modelValue', $event.target.value)" :value="modelValue"/>
        <label>{{ label }}</label>
    </div>
</template>


<style lang="css" scoped>
.form-control{
    border-bottom: 2px solid var(--bs-border-color);
    border-top:none !important;
    border-left:none !important;
    border-right:none !important;
}
.form-control:focus:valid, .form-control:focus.is-valid{
    box-shadow: none !important;
    border:1px solid var(--bs-border-color) !important;
}
</style>
