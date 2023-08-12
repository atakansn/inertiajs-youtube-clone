<script setup>
    import {computed, defineAsyncComponent, ref} from "vue";
    import {Link, usePage, Head} from "@inertiajs/vue3";
    import TheLoadingSpinner from "@Components/LoadingSpinner.vue";
    import ChannelViewTemplate from "./Partials/ChannelViewTemplate.vue";
    import NoContent from "@Components/NoContent.vue";
    import TheLoadingSkeleton from "@Components/TheLoadingSkeleton.vue";
    import ErrorModal from "@Components/ErrorModal.vue";

    const props = defineProps({
        channelVideos: {},
        channel: {},
    })

    const authUser = computed(() => usePage().props.auth?.user)
    const videos = ref(props.videos)
    const fetchLoading = ref(false)
    const showErrorModal = ref(false)
    
    const closeErrorModal = () => showErrorModal.value = false

    const VideoList = defineAsyncComponent({
        loader: () => import('@Components/VideoLists.vue'),
        loadingComponent: TheLoadingSkeleton,
        delay: 300
    })

    const fetchVideos = async () => {
        if (!videos.value.next_page_url) {
            return
        }

        fetchLoading.value = true
        
        try {
            const {data} = axios.get(videos.value.next_page_url)

            fetchLoading.value = false
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

    const noContentMessages = computed(() => {
        if(props?.channel?.user_id === authUser.value?.id) {
            return {
                title: 'Başlamak için video yükleyin',
                description: 'Yüklediğiniz videolar burada görünür.',
            }
        }

        return {
            title: 'Bu kanalda bir içerik yok',
            description: 'Diğer kanallara göz atabilirsiniz.',
            link: {
                href: route('channels'),
                text: 'Diğer kanallar'
            }
        }
    })

</script>

<template>
<Head>
    <title>Videolar</title>
</Head>

<ErrorModal :visibleable="showErrorModal"
            @close="closeErrorModal"/>

<ChannelViewTemplate :channel="channel" :channel-videos="channelVideos" :head-title="`${channel.name} - Videolar`">
    <!-- No Content -->
    <NoContent v-if="channelVideos.data.length === 0"
               :title="noContentMessages.title"
               :description="noContentMessages.description"
               :link="noContentMessages.link">
        <template v-if="channel?.user_id === authUser?.id" #link>
            <Link as="button"
                  :href="route('channel-dashboard.video.upload.index',{channel: channel.id})"
                  type="button"
                  class="mt-3 inline-flex items-center rounded-md border border-transparent bg-gray-200 px-6 py-3 text-base font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Video Yükle
            </Link>
        </template>
    </NoContent>

    <!-- Video Lists -->
    <div v-else class="grid max-w-lg gap-6 lg:max-w-none lg:grid-cols-4 overflow-x-hidden overflow-y-hidden">
        <VideoList v-for="(video,index) in channelVideos.data"
                   :video="video"
                   :key="index"
                   info-class="-ml-0 -mt-2"
        />
    </div>

    <!-- Loading Spinner -->
    <TheLoadingSpinner v-if="fetchLoading"/>

    <!-- Load More --->
    <div v-else-if="channelVideos.data.length >= 12 && channelVideos.data.length !== 0" class="flex justify-center">
        <button v-if="channelVideos.next_page_url" @click="fetchVideos" type="button"
                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Daha fazla yükle
        </button>
    </div>
</ChannelViewTemplate>
</template>

<style scoped>

</style>
