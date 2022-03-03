<template>
    <Link href="/" as="div">
        <div class="border-blue-50 bg-[rgb(18,22,24)] h-16 flex place-content-center items-center cursor-pointer space-x-4">
            <img
                src="@/app_icon.png"
                height="40"
            />
            <div>
                <div class="font-medium text-xl">Crawler</div>
                <div class="text-sm">v1.0</div>
            </div>
        </div>
    </Link>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
})
</script>

<style scoped>
.app-badge {
    color: var(--n-text-color);
    /* background-color: #fff; */
    border-bottom: 1px solid rgba(255, 255, 255, 0.09);

    background: rgb(18, 22, 24);

    padding: 1rem;
    font-size: 1.2rem;
    font-weight: 300;

    display: flex;
    align-items: center;

    cursor: pointer;
}

</style>