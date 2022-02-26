<template>
    <div>
        <Head title="About Crawler" />
        <n-h1>About</n-h1>
        <div>
            This is about page, let's go back
            <Link href="/" class="btn btn-blue">Home</Link>
        </div>
        <pre>{{ JSON.stringify($page, null, 2) }}</pre>
    </div>
</template>

<style scoped>
.margin-auto {
    margin: 0 1.2rem;
}
</style>
