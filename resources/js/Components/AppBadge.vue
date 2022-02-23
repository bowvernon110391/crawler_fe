<template>
    <div class="app-badge">
        <img
            src="/img/app_icon.png"
            width="32"
            style="margin-right: 0.5rem;"
        />
        Crawler v1.0
    </div>
</template>

<style scoped>
.app-badge {

    color: var(--n-text-color);
    /* background-color: #fff; */
    border-bottom: 1px solid var(--n-border-color, rgba(255, 255, 255, 0.09));

    padding: 1rem;
    font-size: 1.2rem;
    font-weight: 300;

    display: flex;
    align-items: center;
}
</style>