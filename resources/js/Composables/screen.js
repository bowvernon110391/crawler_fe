import { ref, onMounted, onUnmounted } from 'vue'

export const useScreen = () => {

    const width = ref(window.innerWidth)
    const height = ref(window.innerHeight)

    // track by listener
    function update(e) {
        console.log('window resize: ', e)
        width.value = window.innerWidth
        height.value = window.innerHeight
    }

    onMounted(() => window.addEventListener('resize', update))
    onUnmounted(() => window.removeEventListener('resize', update))

    return {
        width, height
    }
}