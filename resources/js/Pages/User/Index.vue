<script setup>
import layout from "../../Shared/Layout.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import debounce from "lodash/debounce";
import {computed, onMounted, ref, watch} from 'vue';
import OffcanvasCom from "../../components/Offcanvas.vue";
import {Inertia} from "@inertiajs/inertia";
import {useSlug} from '../../Composables/useSlug.js'
import {Tooltip} from 'bootstrap'
import ImageUploader from "../../components/ImageUploader.vue";
import Swal from "sweetalert2";
import axios from "axios";
import {Offcanvas} from 'bootstrap';
import Pagination from "../../components/Pagination.vue";
import {useAction} from '../../Composables/useAction.js';
import moment from 'moment'

const action = useAction();

const slugTitle = useSlug();

const props = defineProps({
    users:[] | null,
    parent_users:[] | null,
    main_url:String | null,
    errors:Object | null,
    filters: Object,
});


const search = ref();
const perPage = ref();

watch([search, perPage], debounce(function ([val, val2]) {
    Inertia.get(props.main_url, { search: val, perPage: val2 }, { preserveState: true, replace: true });
}, 300));

</script>

<template>
    <layout>
        <div class="content-header row mb-1">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h2 class="float-start mb-0">user List</h2>
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

                    <table class="user-list-table table">
                        <thead class="table-light">
                        <tr class=null>
                            <th class="sorting">Id</th>
                            <th class="sorting">name</th>
                            <th class="sorting">email</th>
                            <th class="sorting">phone</th>
                            <th class="sorting">Created At</th>
                            <th class="sorting"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in users.data" :key="item.user.id">
                            <td>#_{{ item.user.id }}</td>
                            <td>
                                <span class="text-capitalize">{{ item.user.name }}</span>
                            </td>
                            <td>
                                <span class="text-capitalize">{{ item.user.email }}</span>
                            </td>
                            <td>
                                <span class="text-capitalize">{{ item.user.phone }}</span>
                            </td>
                            <td>{{ moment(item.user.created_at).format('ll')  }}</td>
                            <td>
                                <span class="text-danger cursor-pointer ms-1"  @click="action.deleteItem(props.main_url, item.user.id)">
                                    <vue-feather type="trash" size="15"/>
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <Pagination :links="users.links" :from="users.from" :to="users.to" :total="users.total"/>
                </div>
            </div>
        </section>
    </layout>
</template>
