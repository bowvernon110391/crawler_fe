<template>
    <div class="overflow-x-auto drop-shadow-xl">
        <n-table size="small" bordered striped :single-line="false">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Keywords</th>
                    <th>Author</th>
                    <th>Created at</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <template v-if="data.data.length">
                    <tr v-for="d in data.data" :key="d.id">
                        <td>
                            {{ d.name }}
                        </td>
                        <td>
                            <n-dynamic-tags :value="d.keywords" disabled type="primary" />
                        </td>
                        <td>
                            {{ d.user.nama }}
                        </td>
                        <td>
                            {{ d.created_at }}
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
    </div>
</template>

<script>
import { Search, Pencil, Eye, Trash } from '@vicons/ionicons5'

export default {
    props: {
        data: Object
    },
    setup() {      
        return {
            Pencil, Eye, Trash, Search
        }
    },
}
</script>