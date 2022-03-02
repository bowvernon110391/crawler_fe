<template>
    <div class="flex flex-wrap place-content-between place-items-center">
            <!-- indicator -->
            <div class="flex place-content-between place-items-center space-x-2">
                
                <div>
                    Records <strong>{{ data.from }} - {{ data.to }}</strong> of <strong>{{ data.total }}</strong>
                </div>
                <div class="w-28">
                    <n-select size="small" :options="[
                    { label: '5 / Page', value: 5 },
                    { label: '10 / Page', value: 10 },
                    { label: '15 / Page', value: 15 },
                    { label: '20 / Page', value: 20 },
                    { label: '25 / Page', value: 25 },
                    ]" placeholder="" :value="modelValue" @update:value="e => $emit('update:modelValue', e)"/>
                </div>
            </div>

            <!-- per page? -->

            <!-- controls -->
            <div class="flex flex-wrap space-x-1 place-items-center"> 
                <template v-for="d in data.links" :key="d.label">
                    <template v-if="!d.active">
                        <Link :href="d.url">
                            <n-button ghost :disabled="!d.url" text>
                                <div class="p-1.5">                   
                                    <span v-html="d.label" />                        
                                </div>
                            </n-button>
                        </Link>
                    </template>
                    <template v-else>
                        <span class="p-1.5 font-extrabold bg-gray-200 rounded">
                            {{ d.label }}
                        </span>
                    </template>
                </template>
            </div>
        </div>
</template>

<script>
export default {
    props: {
        data: Object,
        modelValue: [Number, String]
    },
    setup() {
    },
}
</script>