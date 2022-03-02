<template>
    <n-form 
        ref="formEl"
        label-placement="left"
        label-width="auto"
        require-mark-placement="right-hanging"
        :rules="rules"
        :model="form"
        :disabled="readOnly"
        >
        <n-grid :cols="4" :x-gap="24">
            <!-- name -->
            <n-form-item-gi label="Name" path="name" :span="2">
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
                <n-button type="primary" @click="onSubmit">
                    <n-icon :component="Save" />
                    Save
                </n-button>
                <n-button type="warning" @click="() => { form.reset(); formEl.restoreValidation() }">
                    <n-icon :component="ArrowUndo" />
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
import { useForm, usePage } from '@inertiajs/inertia-vue3'
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

        // client side validation rules
        const rules = {
            name: {
                required: true,
                trigger: ['blur', 'input'],
                message: "name is required"
            },
            keywords: {
                required: true,
                trigger: ['blur', 'input'],
                validator: (item, value) => {
                    return value.length > 0
                },
                message: "keywords must NOT be empty"
            }
        }

        // handle onSubmit
        const onSubmit = async (e) => {
            // console.log(`click`, e, `formEl`, formEl)

            try {
                await formEl.value.validate()
                
                // compute url?
                let url = usePage().url
                // if (createMode) {}
                console.log(`url`, url.value)
            } catch (error) {
                console.log(`errors`, error)
            }
        }

        return {
            form, formEl,
            rules,
            Save, ArrowUndo, Pencil,
            onSubmit
        }
    },
}
</script>