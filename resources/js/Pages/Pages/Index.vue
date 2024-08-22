<script setup>
import layout from "../../Shared/Layout.vue";
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import debounce from "lodash/debounce";
import {computed, ref, watch} from 'vue';

import {Inertia} from "@inertiajs/inertia";
// import Pagination from "../../components/Pagination";

import {useAction} from "../../Composables/useAction";
const {deleteItem, copyToClipboard} = useAction();
const props = defineProps({
    pages:[] | null,
    main_url:String | null,
    filters: Object,
});


const search = ref();
const perPage = ref();

watch([search, perPage], debounce(function ([val, val2]) {
    Inertia.get(props.main_url, { search: val, perPage: val2 }, { preserveState: true, replace: true });
}, 300));

computed(() => {
    $sToast.fire({
        icon: 'success',
        title: usePage().props.value.message
    })
});



</script>

<template>
    <layout>
        <div class="content-header row mb-1">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h2 class="float-start mb-0">page List</h2>
                <a :href="$page.props.auth.ADMIN_URL+'/pages/create'" class="btn btn-sm btn-gradient-primary d-flex align-items-center">
                    <vue-feather type="plus" size="15"/>
                    <span>Add New page</span>
                </a>
            </div>
        </div>

        <section class="app-user-list">
            <!-- list and filter start -->
            <div class="card">
                <div class="card-datatable table-responsive pt-0 px-2">
                    <div class="d-flex align-items-center justify-content-between border-bottom">
                        <div class="select-search-area d-flex align-items-center">
                            <select class="form-select" v-model="perPage">
                                <option :value="undefined">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div
                            class="d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                            <div class="select-search-area">
                                <label>Search
                                    <input v-model="search"
                                           type="search"
                                           class="form-control"
                                           placeholder="What You Find ?"
                                           aria-controls="DataTables_Table_0">
                                </label>
                            </div>
                        </div>
                    </div>

                    <table class="page-list-table table">
                        <thead class="table-light">
                        <tr class=null>
                            <th class="sorting">Id</th>
                            <th class="sorting">title</th>
                            <th class="sorting">Summery</th>
                            <th class="sorting">Created At</th>
                            <th class="sorting"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="page in pages.data" :key="page.id" @dblclick="copyToClipboard(page.slug)">
                            <td>#_{{ page.id }}</td>
                            <td>
                                <a :href="'/pages/'+page.slug" class="fs-6">{{ page.title }}</a>
                            </td>
                            <td>
                                <p v-html="page.summery?.slice(0, 200)"></p>
                            </td>
                            <td>
                                {{ page.created_at, 'lll'}}
                            </td>
                            <td>
                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                                    <a :href="page.edit_url" class="dropdown-item d-flex align-items-center text-info w-100">
                                        <vue-feather type="edit" size="15"/>
                                        <span class="ms-1">Edit</span>
                                    </a>
                                    <button class="dropdown-item d-flex align-items-center text-danger w-100" type="button"
                                            @click="deleteItem(props.main_url, page.id)">
                                        <vue-feather type="trash" size="15"/>
                                        <span class="ms-1">Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <Pagination :links="pages.links" :from="pages.from" :to="pages.to" :total="pages.total"/>
                </div>
            </div>
        </section>
    </layout>
</template>
