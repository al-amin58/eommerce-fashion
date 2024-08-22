<template>
<li class="nav-item d-none d-lg-block">
    <a class="nav-link nav-link-style" @click="toggleDark">
        <vue-feather :type="`${themeSkin === 'light' ? 'moon' : 'sun'}`" />
    </a>
</li>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useStore } from 'vuex'

const store = useStore()

const themeSkin = computed(() => store.state.skin)
const toggleDark = () => {
    let skin = themeSkin.value ==='light' ? 'dark' : 'light'
    store.commit('UDATE_SKIN', skin)
}
onMounted(() => store.commit('UDATE_SKIN', themeSkin.value))
</script>