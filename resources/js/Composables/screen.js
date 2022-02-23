import { ref, onMounted, onUnmounted } from 'vue'

export const useScreen = (mobileBreakpoint) => {
    mobileBreakpoint = mobileBreakpoint || 480

    const width = ref(window.innerWidth)
    const height = ref(window.innerHeight)
    const isMobile = ref(width.value <= mobileBreakpoint)

    // track by listener
    function update(e) {
        console.log('window resize: ', e)
        width.value = window.innerWidth
        height.value = window.innerHeight
        isMobile.value = width.value <= mobileBreakpoint
    }

    onMounted(() => window.addEventListener('resize', update))
    onUnmounted(() => window.removeEventListener('resize', update))

    return {
        width, height, isMobile
    }
}