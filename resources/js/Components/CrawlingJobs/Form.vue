<template>
    <n-form 
        ref="formEl"
        label-placement="left"
        label-width="auto"
        require-mark-placement="right-hanging"
        :model="form"
        :disabled="readOnly"
        >
        <n-grid :cols="4" :x-gap="24">
            <!-- name -->
            <n-form-item-gi 
                label="Name" 
                path="name" :span="2" 
                :validationStatus="form.errors.name ? 'error' : undefined"
                :feedback="form.errors.name">
                <n-input type="text" v-model:value="form.name" />
            </n-form-item-gi>
            <!-- private -->
            <n-form-item-gi label="Private" path="private" :span="4">
                <n-switch type="text" v-model:value="form.private" />
            </n-form-item-gi>
            <!-- keywords  -->
            <n-form-item-gi label="Keywords" path="keywords" :span="4">
                <!-- <n-input type="text" v-model:value="form.name" /> -->
                <n-dynamic-tags v-model:value="form.keywords" />
            </n-form-item-gi>
        </n-grid>
        <n-space>
            <!-- submit and reset -->
            <template v-if="!readOnly">
                <n-button type="primary" @click="onSubmit" :loading="form.processing">
                    <template #icon>
                        <n-icon :component="Save" />
                    </template>
                    Save
                </n-button>
                <n-button type="warning" @click="() => { form.reset(); formEl.restoreValidation() }">
                    <template #icon>
                        <n-icon :component="ArrowUndo" />
                    </template>
                    Reset
                </n-button>
            </template>

            <template v-else>
                <Link :href="`${$page.url}/edit`">
                    <n-button>
                        <n-icon :component="Pencil" />
                        Edit
                    </n-button>
                </Link>
            </template>
        </n-space>
    </n-form>
</template>

<script>
import { Save, ArrowUndo, Pencil } from '@vicons/ionicons5'
import { useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

export default {
    props: {
        data: Object,
        readOnly: Boolean,
        createMode: Boolean
    },
    setup({ data, createMode }) {

        // use form helper 
        const form = useForm({
            name: '',
            private: true,
            keywords: [],
            // overwrite data if available
            ...data
        })

        // hold ref to form component
        const formEl = ref(null)

        // handle onSubmit
        const onSubmit = async (e) => {
            // console.log(`click`, e, `formEl`, formEl)

            try {
                await formEl.value.validate()
                
                if (createMode) {
                    const url = route('jobs.store')
                    form.post(url)                    
                } else {
                    const url = route('jobs.update', { job: form.id })
                    form.put(url, {}, { resetOnSuccess: false })
                }
            } catch (error) {
                console.log(`errors`, error)
            }
        }

        return {
            form, formEl,
            Save, ArrowUndo, Pencil,
            onSubmit
        }
    },
}
</script>