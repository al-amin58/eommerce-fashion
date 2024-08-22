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
import moment from "moment";
import Switch from "../../components/Switch.vue";


const action = useAction();

const slugTitle = useSlug();

const props = defineProps({
    advised:[] | null,
    main_url:String,
    filters: Object,
});

const search = ref();
const perPage = ref();

watch([search, perPage], debounce(function ([val, val2]) {
    Inertia.get(props.main_url, { search: val, perPage: val2 }, { preserveState: true, replace: true });
}, 300));

const status = ref();


</script>

<template>
    <layout>
        <div class="content-header row mb-1">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h2 class="float-start mb-0">Category List</h2>
                <a :href="$page.props.auth.ADMIN_URL+'/advised'" class="btn btn-sm btn-gradient-primary d-flex align-items-center">
                    <vue-feather type="plus" size="15"/>
                    <span>Add New Advised</span>
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

                    <table class="category-list-table table">
                        <thead class="table-light">
                        <tr class=null>
                            <th class="sorting">Id</th>
                            <th class="sorting">Thumb</th>
                            <th class="sorting">Title</th>
                            <th class="sorting">Discount</th>
                            <th class="sorting">Created At</th>
                            <td colspan="sorting">Status</td>
                            <th class="sorting"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="ads in advised.data" :key="ads.id">
                            <td>#_{{ ads.id }}</td>

                            <td>
                                <img v-if="ads.image" :src="ads.image" height="200" width="300" alt="">
                            </td>
                            <td class="position-relative">
                                {{ ads.title }}
                                <span class="badge bg-gradient-primary" v-c-tooltip=" JSON.parse(ads.products)?.length +' products under this ads'">
                                    {{ JSON.parse(ads.products)?.length }}
                                </span>
                            </td>
                            <td>{{ ads.discount_price ?? 0 }} {{ ads.discount_type ===  'flat' ? '৳' : '%'}}</td>
                            <td>{{ moment(ads.created_at).format('lll') }}</td>
                            <td>
                                <span v-if="ads.status === 1" class="text-success">
                                    <vue-feather type="check-circle"/>
                                </span>
                                <span v-else class="text-danger">
                                    <vue-feather type="x-circle"/>
                                </span>
                            </td>
                            <td>
                                <a :href="`${props.main_url}/${ads.id}`" target="_blank" class="text-primary cursor-pointer">
                                    <vue-feather type="edit" size="15"/>
                                </a>
                                <span class="text-danger cursor-pointer ms-1"  @click="action.deleteItem(props.main_url, ads.id)">
                                    <vue-feather type="trash" size="15"/>
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <Pagination :links="advised.links" :from="advised.from" :to="advised.to" :total="advised.total"/>
                </div>
            </div>
        </section>

    </layout>
</template>
