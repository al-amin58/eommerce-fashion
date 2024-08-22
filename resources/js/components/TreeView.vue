<template>
    <ul class="list-group py-0">
        <li class="list-group-item scrollable-container media-list border-0 border-bottom cursor-pointer"
            v-for="node in nodes" :key="node.title">
            <div class="list-item d-flex align-items-center">
                <div class="me-1">
                    <img :src="node.icon" alt="avatar" width="32" height="32">
                </div>
                <div class="list-item-body flex-grow-1">
                    <a :href="`/products?category=${node.slug}`"
                       class="fw-bolder text-capitalize">{{ node.title }}</a>
                </div>
                <span v-if="node.childrens?.length > 0">
                    <span v-if="node.childrens?.length > 0">
                        <vue-feather type="chevron-right" size="12" v-if="!node.open"  @click="toggleNode(node)"/>
                        <vue-feather type="chevron-down" size="12" v-else  @click="toggleNode(node)"/>
                    </span>
                </span>
            </div>
       <!--     <a class="d-flex" :href="`${$page.props.auth.MAIN_URL}/products?category_slug=${node.slug}`">

            </a>-->
            <Tree :nodes="node.sub" v-if="node.childrens?.length > 0 && node.open" />
        </li>
    </ul>

<!--    <ul>
        <li v-for="node in nodes" :key="node.label">
              <span @click="toggleNode(node)">
                {{ node.title }}
                <span v-if="node.childrens?.length > 0">{{ node.open ? '-' : '+' }}</span>
              </span>
            <Tree :nodes="node.childrens" v-if="node.childrens?.length > 0 && node.open" />
        </li>
    </ul>-->
</template>

<script>
    import { defineComponent } from 'vue';

    export default defineComponent({
        name: 'Tree',
        props: {
            nodes: {
                type: Array,
                required: true,
            },
        },
        methods: {
            toggleNode(node) {
                node.open = !node.open;
            },
        },
    });
</script>

<style>
    .list-group li:last-child{
        border-bottom:none !important;
        padding-bottom: 0 !important;
    }
</style>
