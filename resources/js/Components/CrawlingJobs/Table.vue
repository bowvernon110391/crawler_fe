<template>
    <div class="overflow-x-auto drop-shadow-xl">
        <n-table size="small" bordered striped :single-line="false">
            <thead class="table-head">
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
                            <n-dynamic-tags :value="d.keywords" disabled />
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
                                        <template #icon>
                                            <n-icon :component="Eye" />
                                        </template>
                                        View
                                    </n-button>
                                </Link>

                                <Link :href="`/jobs/${d.id}/edit`" v-if="d.can.edit">
                                    <n-button quaternary type="warning">
                                        <template #icon>
                                            <n-icon :component="Pencil" />
                                        </template>
                                        Edit
                                    </n-button>
                                </Link>

                                <!-- <Link as="n-button" method="delete" :href="`/jobs/${d.id}`" v-if="d.can.delete"> -->
                                <n-button quaternary type="error" @click="onClick(d)">
                                    <template #icon>
                                        <n-icon :component="Trash" />
                                    </template>
                                    Delete
                                </n-button>
                                <!-- </Link> -->
                            </n-button-group>

                        </td>
                    </tr>
                </template>

                <empty-table v-else />
                
            </tbody>
        </n-table>
    </div>
</template>

<script>
import { Pencil, Eye, Trash } from '@vicons/ionicons5'
import { useDialog } from 'naive-ui'
import EmptyTable from '../EmptyTable.vue'

export default {
    components: {
        EmptyTable
    },
    props: {
        data: Object
    },
    emits: [
        'delete'
    ],
    setup(props, { emit }) {

        const dialog = useDialog()

        const onClick = (job) => {
            // return confirm(`Delete job '${job.name}'?`) && emit('delete', job)
            dialog.warning({
                title: 'Confirm',
                content: `Hapus job [${job.name}]?`,
                positiveText: 'Delete',
                negativeText: 'Cancel',
                onPositiveClick: () => emit('delete', job)
            })
        }

        return {
            Pencil, Eye, Trash,
            onClick
        }
    },
}
</script>