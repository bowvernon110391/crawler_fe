<template>
    <div>

        <Head title="#" />
        <n-h1>Crawler v1.0</n-h1>
        <n-p>
            Aplikasi ini digunakan untuk scraping data dari marketplace. Parameter yang digunakan
            saat ini baru <em>keyword</em> saja
        </n-p>
        <n-p>
            Tutorial bisa dilihat di bawah ini
        </n-p>
        <div class="text-center">
            <iframe
                width="560"
                height="315"
                src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
            ></iframe>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: String,
    contents: Array,
});
</script>