<template>
    <!-- some page control here -->
    <!-- pagination control? -->
    <div>
        <n-form inline label-placement="left" class="flex flex-col md:flex-row place-content-between">
            <div>
                <n-form-item>
                    <Link href="jobs/create">
                        <n-button type="primary">
                            <n-icon :size="24" :component="AddCircle"/>
                            Create Job
                        </n-button> 
                    </Link>
                    <!-- <n-select 
                        v-model:value="number"
                        :options="[
                        { label: '5', value: 5 },
                        { label: '10', value: 10 },
                        { label: '15', value: 15 },
                        { label: '20', value: 20 },
                        { label: '25', value: 25 },
                        ]"
                    /> -->
                </n-form-item>
            </div>
            <div class="flex space-x-1 flex-col md:flex-row">
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
            </div>
        </n-form>
    </div>
    
    <!-- some table below -->
    <Table :data="data" />

    <!-- pagination here? -->
    <div class="mt-4">        
        <Pagination :data="data" v-model="number" />
    </div>
</template>

<script>

import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import debounce from 'lodash/debounce'
import { AddCircle, Search } from '@vicons/ionicons5'
import Pagination from '../../Shared/Pagination.vue'
import Table from './Table.vue'

export default {
    components: {
        Pagination,
        Table
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
            q, number, page,
            scoped,
            AddCircle, Search
        }
    },
}
</script>