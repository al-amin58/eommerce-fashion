<script setup>
    const props = defineProps({
        categories:{
            type:Array,
            required:true,
        }
    })

</script>

<template>
  <section>
    <div class="p-5 featured-category">
      <h3 class="text-center">Product Categories</h3>
      <div class="row justify-content-center">
        <a :href="`${$page.props.auth.MAIN_URL}/products?category=${item.slug}`"
           class="col-md-3 featured-category-item border m-1 p-1 rounded"
           v-for="item in props.categories">

          <div class="d-flex align-items-center justify-content-between">
            <p class="p-0 m-0">{{ item.title }}</p>
            <img width="80" :src="item.icon" alt="">
          </div>
        </a>
      </div>
    </div>
  </section>
</template>
