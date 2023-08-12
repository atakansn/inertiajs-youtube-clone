<script setup>
    import TheLoadingSkeleton from "../Components/TheLoadingSkeleton.vue";
    import {usePage} from "@inertiajs/vue3";
    import {ref, defineAsyncComponent, onMounted, onUnmounted} from "vue";
    import LoadingSpinner from "../Components/LoadingSpinner.vue";
    import NoContent from "../Components/NoContent.vue";
    import ErrorModal from "@Components/ErrorModal.vue";
    import AppLayout from "@/Layouts/AppLayout.vue";

    const videos = ref(usePage().props.videos)
    const loading = ref(false)
    const loadingSpinnerRef = ref(null)
    const showErrorModal = ref(false)

    const VideoLists = defineAsyncComponent({
        loader: () => import('../Components/VideoLists.vue'),
        loadingComponent: TheLoadingSkeleton,
        delay: 300,
    })

    const noContentComponentLinkProp = {
        text: 'Kanalları keşfedin',
        href: route('channels')
    }
    
    const closeErrorModal = () => showErrorModal.value = false

    async function handleScroll() {
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;
        const scrollPosition = window.scrollY;

        if (windowHeight + scrollPosition >= documentHeight) {
            if (!videos.value.next_page_url) {
                loading.value = false
                return
            }
            
            try {
                const {data} = await axios.get(videos.value.next_page_url)

                loading.value = true

                videos.value = {
                    ...data,
                    data: [
                        ...videos.value.data,
                        ...data.data
                    ]
                }
            } catch (e) {
                showErrorModal.value = true
                throw e
            }
        }
    }

    onMounted(() => {
        window.addEventListener('scroll', handleScroll);
    })

    onUnmounted(() => {
        window.removeEventListener('scroll', handleScroll)
    })


</script>

<template>
<ErrorModal @close="closeErrorModal"
            :visibleable="showErrorModal"/>

<AppLayout head-title="Anasayfa">

    <!-- NoContent Component -->
    <NoContent v-if="videos.data.length === 0"
               title="Yüklenmiş bir video yok"
               description="İlerleyen dakikalarda tekrar deneyin."
               :link="noContentComponentLinkProp"/>


    <div class="grid max-w-screen-2xl gap-6 lg:max-w-screen-2xl lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2">
        <VideoLists v-for="(data,index) in videos.data"
                    :video="data"
                    :key="index"
                    show-photo
                    show-channel-name
        />
    </div>

    <div ref="loadingSpinnerRef">
        <LoadingSpinner v-if="loading"/>
    </div>
</AppLayout>
</template>

<style scoped>
</style>
