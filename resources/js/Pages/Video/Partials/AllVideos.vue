<script setup>
    import ButtonLoadMore from "@Components/ButtonLoadMore.vue";
    import {ref} from "vue";
    import {Link} from "@inertiajs/vue3";
    import ErrorModal from "@Components/ErrorModal.vue";

    const props = defineProps({
        allVideos: {}
    })

    const videos = ref(props.allVideos)

    const loadingSpinner = ref(false)
    const showLoadMoreButton = ref(true)
    const showErrorModal = ref(false)
    
    const closeErrorModal = () => showErrorModal.value = false

    const fetchLoadMoreVideos = async () => {
        if (!videos.value.next_page_url) {
            return
        }

        loadingSpinner.value = true

        try {
            const {data} = await axios.get(videos.value.next_page_url)

            if (!data.allVideo.next_page_url) {
                showLoadMoreButton.value = false
            }

            if (data.status === 200) {
                loadingSpinner.value = false
            }

            videos.value = {
                ...data.allVideo,
                data: [
                    ...videos.value.data,
                    ...data.allVideo.data
                ]
            }
        } catch (e) {
            showErrorModal.value = true
            throw e
        }
    }
</script>

<template>
<ErrorModal :visibleable="showErrorModal"
            @close="closeErrorModal"/>

<div class="lg:col-span-3 lg:row-span-2 lg:row-end-2">
    <h3 v-show="videos.data?.length >= 1" class="text-md font-medium text-gray-900 border-b border-gray-100">Tümü</h3>

    <div v-if="videos.data?.length === 0" class="flex flex-col items-center mt-64">
        <svg class="w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"/>
        </svg>

        <h4 class="text-gray-800 font-semibold text-xl">Henüz videolar yüklenmemiş</h4>
    </div>

    <template v-else>
        <ul role="list" class="border-t border-gray-200 divide-y divide-gray-200">
            <li v-for="otherVideo in videos.data" class="flex py-4">
                <Link :href="route('view',{v: otherVideo.id})">
                    <img class="h-28 w-44 rounded-sm"
                         :src="otherVideo.video_thumbnail"
                         alt="">
                </Link>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ otherVideo.title }}</p>
                    <Link :href="`@${otherVideo.channel.identifier}/videos`">
                        <p class="text-sm text-gray-500 hover:text-gray-700">{{ otherVideo?.channel?.name }}</p>
                    </Link>
                    <p class="text-sm text-gray-500">{{ otherVideo.view_count }} görüntülenme</p>
                    <time class="text-xs mt-3" datetime="2020-03-16">{{ otherVideo.video_created_at }}</time>
                </div>
            </li>
        </ul>

        <!-- Load More -->
        <div v-show="videos.data?.length >= 5" class="flex justify-center mt-2">
            <ButtonLoadMore v-if="showLoadMoreButton"
                            spinner-class="h-9 w-9 -mt-9"
                            :show-spinner="loadingSpinner"
                            @load-more="fetchLoadMoreVideos"/>
        </div>
    </template>
</div>
</template>

<style scoped>

</style>
