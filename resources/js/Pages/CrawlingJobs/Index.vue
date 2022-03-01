<template>
    <!-- some page control here -->
    <div class="flex flex-col md:flex-row place-content-between">
        <!-- create button -->
        <div>
            <Link href="jobs/create">
                <n-button type="primary">
                    <n-icon :component="Create"/>
                    Create Job
                </n-button> 
            </Link>
        </div>
            
        <!-- search form -->
        <div>
            <n-form label-placement="left" inline class="flex flex-col md:flex-row" size="small">
                <n-form-item label="Show Mine Only" v-if="adminMode" class="mt-2 md:mt-0">
                    <n-switch v-model:value="scoped" />
                </n-form-item>
                <n-form-item>
                    <n-date-picker value-format="yyyy-MM-dd" type="date" class="w-32" placeholder="Dari Tgl..." clearable/>
                </n-form-item>
                <n-form-item>
                    <n-date-picker value-format="yyyy-MM-dd" type="date" class="w-32" placeholder="Sampai..." clearable/>
                </n-form-item>
                <n-form-item>
                    <n-input v-model:value="q" type="text" placeholder="Nama/Keyword/Author..." clearable>
                        <template #suffix>
                            <n-icon :component="Search"/>
                        </template>
                    </n-input>
                </n-form-item>
            </n-form>
        </div>
    </div>
    <!-- pagination control? -->
    <div>
        <n-form inline label-placement="left" size="small">
            <n-form-item label="Show">
                <n-select 
                    v-model:value="number"
                    :options="[
                    { label: '5', value: 5 },
                    { label: '10', value: 10 },
                    { label: '15', value: 15 },
                    { label: '20', value: 20 },
                    { label: '25', value: 25 },
                    ]"
                />
            </n-form-item>
        </n-form>
    </div>
    
    <!-- some table below -->
    <div class="overflow-x-auto drop-shadow-xl">
        <n-table size="small" bordered striped :single-line="false">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Keywords</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <template v-if="data.data.length">
                    <tr v-for="d in data.data" :key="d.id">
                        <td>{{ d.name }}</td>
                        <td>
                            <n-dynamic-tags :value="d.keywords" disabled type="primary" />
                        </td>
                        <td>
                            {{ d.user.nama }}
                        </td>
                        <td>
                            {{ d.status }}
                        </td>
                        <td class="min-w-[64px]">
                            <n-button-group round size="small">
                                <Link :href="`/jobs/${d.id}`" v-if="d.can.view">
                                    <n-button quaternary type="primary">
                                        <n-icon :component="Eye" />
                                        View
                                    </n-button>
                                </Link>

                                <Link :href="`/jobs/${d.id}/edit`" v-if="d.can.edit">
                                    <n-button quaternary type="warning">
                                        <n-icon :component="Pencil" />
                                        Edit
                                    </n-button>
                                </Link>

                                <Link as="n-button" method="delete" :href="`/jobs/${d.id}`" v-if="d.can.delete">
                                    <n-button quaternary type="error">
                                        <n-icon :component="Trash" />
                                        Delete
                                    </n-button>
                                </Link>
                            </n-button-group>

                        </td>
                    </tr>
                </template>

                <template v-else>
                    <td colspan="100">
                        <n-alert title="Empty Result" type="warning" class="w-96 mx-auto">
                            <template #icon>
                                <n-icon :component="Search" />
                            </template>
                            The query doesn't produce any results
                        </n-alert>
                    </td>
                </template>
            </tbody>
        </n-table>

        <!-- <n-divider/> -->

        <!-- <pre>{{ data }}</pre> -->
    </div>
    <!-- pagination here? -->
    <div class="mt-4">
        <!-- Pagination here -->
        <!-- <n-pagination 
            :page="data.current_page"
            :page-count="data.last_page"
            :page-slot="10"

            v-model:page.number="page"
            v-model:page-size.number="number"

            show-size-picker
            :page-sizes="[ 5, 10, 20, 50 ]"
        >
            <template #prefix>
                Showing&nbsp;<strong>{{ data.from }}</strong>&nbsp;to&nbsp;<strong>{{ data.to }}</strong>
            </template>
        </n-pagination> -->
        
        <Pagination :data="data" />
    </div>
</template>

<script>
import { Search, Create, Eye, Pencil, Trash } from '@vicons/ionicons5'
import { computed, watchEffect, ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import debounce from 'lodash/debounce'
import Pagination from '../../Shared/Pagination.vue'

export default {
    components: {
        Pagination
    },
    props: {
        data: Object,
        filter: Object,
        adminMode: Boolean
    },

    setup({ data, filter }) {
        // for our search
        const q = ref(filter.q || '')
        const number = ref(Number(data.per_page) || 10)
        const page = ref(data.current_page || 1)
        const scoped = ref(false)

        // when page changes

        const onQuery = (q, page, number) => {
            console.log("SEARCH: ", q)
            Inertia.get(data.path, {
                q: q,
                page: page,
                number: number,
                
                ...scoped.value ? {
                    scoped: true
                }:{}
            },{
                preserveState: true,
                preserveScroll: false
            })
        }
        
        watch([q, number, scoped], debounce(([newQ, newNumber, newScoped], [oldQ, oldNumber, oldScoped]) => {
            // reset page number to 1
            page.value = 1
            onQuery(q.value, page.value, number.value)            
        }, 400))

        return {
            Search, Create, Eye, Pencil, Trash,
            q, number, page,
            scoped
        }
    },
}
</script>