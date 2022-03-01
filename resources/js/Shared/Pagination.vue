<template>
    <div class="flex flex-wrap place-content-between place-items-center">
            <!-- indicator -->
            <div>
                Showing from <strong>{{ data.from }}</strong> to <strong>{{ data.to }}</strong>
            </div>
            <n-divider vertical />
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
        data: Object
    },
    setup() {
    },
}
</script>