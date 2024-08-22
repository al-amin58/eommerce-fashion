<template>
    <div class="main-menu menu-fixed menu-accordion menu-shadow bg-primary"
         :class="[
      { 'expanded': !isVerticalMenuCollapsed || (isVerticalMenuCollapsed && isMouseHovered) },
      themeSkin === 'light'|| themeSkin === 'bordered' ? 'menu-light' : 'menu-dark'
    ]"
         @mouseenter="updateMouseHovered(true)"
         @mouseleave="updateMouseHovered(false)"
    >
        <div class="navbar-header expanded">
            <slot
                name="header"
                :toggleVerticalMenuActive="toggleVerticalMenuActive"
                :toggleCollapsed="toggleCollapsed"
                :collapseTogglerIcon="collapseTogglerIcon"
            >
                <ul class="nav navbar-nav flex-row align-items-center">
                    <li class="nav-item me-auto">
                        <Link preserve-scroll class="navbar-brand" href="#">
                            <span class="brand-logo">
                                <img :src="`/storage/${dataStore.settingItem.find(item => item.key === 'header_logo')?.val}`" style="min-width: 160px;max-width: 160px;" alt="logo">
                            </span>
                        </Link>
                    </li>
                    <li class="nav-item nav-toggle">
                        <Link preserve-scroll class="nav-link modern-nav-toggle">
                            <vue-feather type="x" @click="toggleVerticalMenuActive" class="d-block d-xl-none text-white" />
                            <vue-feather :type="collapseTogglerIconFeather" @click="toggleCollapsed" class="d-none d-xl-block collapse-toggle-icon text-white" />
                        </Link>
                    </li>
                </ul>
            </slot>
        </div>
        <div class="shadow-bottom"></div>
        <perfect-scrollbar>
            <div class="main-menu-content scroll-area">
                <ul class="navigation navigation-main bg-primary" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class=" nav-item">
                        <Link preserve-scroll class="d-flex align-items-center" href="/panel/dashboard">
                            <vue-feather type="home" class="text-white" />
                            <span class="menu-title text-white" data-i18n="Dashboards">Dashboards</span>
                        </Link>
                    </li>



                    <li class=" nav-item">
                        <Link preserve-scroll class="d-flex align-items-center" href="/panel/users">
                            <vue-feather type="users" class="text-white" />
                            <span class="menu-title text-white" data-i18n="Dashboards">Manage Users</span>
                        </Link>
                    </li>

                    <li class=" nav-item has-sub" :class="{'open' : clickMenu === 2}" @click.prevent="toggleSubMenu(2)">
                        <a preserve-scroll class="d-flex align-items-center">
                            <vue-feather type="codesandbox" class="text-white" />
                            <span class="menu-title text-white"
                                  data-i18n="Authentication">Products</span>
                        </a>
                        <ul class="menu-content">
                            <li>
                                <Link preserve-scroll class="d-flex align-items-center bg-transparent" href="/panel/products">
                                    <vue-feather type="circle" class="text-white" />
                                    <span class="menu-item text-white" data-i18n="Login">Products</span>
                                </Link>
                            </li>
                            <li>
                                <Link preserve-scroll class="d-flex align-items-center" href="/panel/category">
                                    <vue-feather type="circle" class="text-white" />
                                    <span class="menu-item text-white" data-i18n="Login">Category</span>
                                </Link>
                            </li>
                            <li>
                                <Link preserve-scroll class="d-flex align-items-center" href="/panel/sub-category">
                                    <vue-feather type="circle" class="text-white" />
                                    <span class="menu-item text-white" data-i18n="Login">Sub Category</span>
                                </Link>
                            </li>
                            <li>
                                <Link preserve-scroll class="d-flex align-items-center" href="/panel/child-category">
                                    <vue-feather type="circle" class="text-white" />
                                    <span class="menu-item text-white" data-i18n="Login">Child Category</span>
                                </Link>
                            </li>
                            <li>
                                <Link preserve-scroll class="d-flex align-items-center" href="/panel/brand">
                                    <vue-feather type="circle" class="text-white" />
                                    <span class="menu-item text-white" data-i18n="Login">Brand</span>
                                </Link>
                            </li>
                        </ul>
                    </li>

                    <li class=" nav-item">
                        <Link preserve-scroll class="d-flex align-items-center" href="/panel/orders">
                            <vue-feather type="shopping-cart" class="text-white" />
                            <span class="menu-title text-white" data-i18n="Dashboards">Orders</span>
                        </Link>
                    </li>

                    <li class=" nav-item">
                        <Link preserve-scroll class="d-flex align-items-center" href="/panel/order-area">
                            <vue-feather type="cast" class="text-white" />
                            <span class="menu-title text-white" data-i18n="Dashboards">Order Area</span>
                        </Link>
                    </li>

                    <li class=" nav-item">
                        <Link preserve-scroll class="d-flex align-items-center" href="/panel/pages">
                            <vue-feather type="book-open" class="text-white" />
                            <span class="menu-title text-white" data-i18n="Dashboards">Pages</span>
                        </Link>
                    </li>


                    <li class=" nav-item">
                        <Link preserve-scroll class="d-flex align-items-center" href="/panel/coupon">
                            <vue-feather type="cloud-drizzle" class="text-white" />
                            <span class="menu-title text-white" data-i18n="Dashboards">Coupon</span>
                        </Link>
                    </li>

                    <li class=" nav-item">
                        <Link preserve-scroll class="d-flex align-items-center" href="/panel/slider">
                            <vue-feather type="cloud-drizzle" class="text-white" />
                            <span class="menu-title text-white" data-i18n="Dashboards">Slider</span>
                        </Link>
                    </li>


                    <!-- <li class=" nav-item has-sub" :class="{'open' : clickMenu === 3}" @click.prevent="toggleSubMenu(3)">
                        <a preserve-scroll class="d-flex align-items-center">
                            <vue-feather type="wifi" class="text-white" />
                            <span class="menu-title text-white" data-i18n="Dashboards">Advised</span>
                        </a>
                        <ul class="menu-content">
                            <li class=" nav-item">
                                <Link preserve-scroll class="d-flex align-items-center" href="/panel/advised">
                                    <vue-feather type="circle" class="text-white" />
                                    <span class="menu-title text-white" data-i18n="Dashboards">Create Advised</span>
                                </Link>
                            </li>
                            <li class=" nav-item">
                                <Link preserve-scroll class="d-flex align-items-center" href="/panel/all-advised">
                                    <vue-feather type="circle" class="text-white" />
                                    <span class="menu-title text-white" data-i18n="Dashboards">All Advised</span>
                                </Link>
                            </li>
                        </ul>
                    </li> -->
                    <li class=" nav-item">
                        <Link preserve-scroll class="d-flex align-items-center" href="/panel/settings">
                            <vue-feather type="settings" class="text-white" />
                            <span class="menu-title text-white" data-i18n="Dashboards">Setting</span>
                        </Link>
                    </li>

                </ul>
            </div>
        </perfect-scrollbar>
    </div>
</template>

<script setup>
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import { ref, computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import {useDataStore} from "../Store/useDataStore";

const props = defineProps({
    isVerticalMenuActive: {
        type: Boolean,
        required: true,
    },
    toggleVerticalMenuActive: {
        type: Function,
        required: true,
    },
})
const isMouseHovered = ref(false)
const store = useStore()
const dataStore = useDataStore();

onMounted(() =>{
    dataStore.setSetting('header_logo');
    dataStore.setSetting('name');
    dataStore.setSetting('address');
    dataStore.setSetting('phone');
    dataStore.setSetting('email');
    dataStore.setSetting('footer_logo');
})

const themeSkin = computed(() => store.state.skin)
const isVerticalMenuCollapsed = computed(() => store.state.isVerticalMenuCollapsed)

const collapseTogglerIconFeather = computed(() => (collapseTogglerIcon.value === 'unpinned' ? 'circle' : 'disc'))

onMounted(() => store.commit('UDATE_SKIN', themeSkin.value))

const collapseTogglerIcon = computed(() => {
    if (props.isVerticalMenuActive) {
        return isVerticalMenuCollapsed.value ? 'unpinned' : 'pinned'
    }
    return 'close'
})

const toggleCollapsed = () => {
    store.commit('UPDATE_MENU_COLLAPSED', !isVerticalMenuCollapsed.value)
}

const openClass = ref('')
const clickMenu = ref(0)
const toggleSubMenu = (val) => {
    openClass.value = openClass.value ? '' : 'open'
    clickMenu.value = clickMenu.value === val ? 0 : val
}

const updateMouseHovered = val => {
    isMouseHovered.value = val
}
</script>

<style src="vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css"/>

<style scoped>
.main-menu.menu-light .navigation > li.open:not(.menu-item-closing) > a {
    background-color: transparent !important;
}
</style>
