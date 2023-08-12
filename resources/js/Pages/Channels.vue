<script setup>
    import {Link} from "@inertiajs/vue3";
    import SubscriptionButton from "@Components/SubscriptionButton.vue";
    import {onMounted, ref} from "vue";
    import TheLoadingSpinner from "@Components/LoadingSpinner.vue";
    import NoContent from "@Components/NoContent.vue";
    import ErrorModal from "@Components/ErrorModal.vue";
    import AppLayout from "@/Layouts/AppLayout.vue";

    const props = defineProps({
        channels: {}
    })

    const loadingRef = ref(null)
    const showErrorModal = ref(false)
    const channelLists = ref(props.channels)
    
    const closeErrorModal = () => showErrorModal.value = false

    const loadingMore = (entries, observer) => {
        entries.forEach(async entry => {
            if (!entry.isIntersecting) return

            try {
                if (!channelLists.value.next_page_url) return

                const {data} = await axios.get(channelLists.value.next_page_url)

                channelLists.value = {
                    ...data,
                    data: [
                        ...channelLists.value.data,
                        ...data.data
                    ]
                }

                if (!data.next_page_url) {
                    observer.unobserve(entry.target)
                }

            } catch (e) {
                showErrorModal.value = true
                observer.unobserve(entry.target)
                throw e
            }
        })
    }

    const intersectionObserver = new IntersectionObserver(loadingMore)

    onMounted(() => {
        intersectionObserver.observe(loadingRef.value)
    })
</script>

<template>
<ErrorModal @close="closeErrorModal"
            :visibleable="showErrorModal"/>

<AppLayout head-title="Kanallar">

    <!-- NoContent Component -->
    <NoContent v-if="channelLists.data.length === 0"
               title="Buralar henüz taze"
               description="Kanalını oluştur, videolarını paylaş."
               :link="{text: 'Kayıt ol ve başla', href: '/register'}"/>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div v-for="(channel, index) in channelLists.data" :key="index"
             class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
            <div class="flex-shrink-0">
                <img class="h-20 w-20 rounded-full"
                     :src="channel.channel_photo_url"
                     alt="">
            </div>
            <div class="min-w-0 flex-1">
                <Link :href="`/@${channel.identifier}/videos`" class="focus:outline-none">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-gray-900">{{ channel.name }}</p>
                    <p class="truncate text-sm text-gray-500">{{ channel.subscriptions_count }} Abone</p>
                    <p class="truncate text-sm text-gray-500">{{ channel.videos_count }} Video</p>
                </Link>
            </div>

            <div class="absolute right-5">
                <SubscriptionButton :channel="channel"
                                    :key="index"
                >
                    <template #subscribeEl="subscribeProp">
                        <button @click="subscribeProp.toggleSubscription"
                                type="button"
                                class="inline-flex items-center rounded-full border border-transparent p-2 text-white shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">

                            <svg v-if="subscribeProp.subscribed"
                                 class="w-6 h-6 text-gray-700 hover:fill-white hover:stroke-gray-700 hover:stroke-1"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                      clip-rule="evenodd"/>
                            </svg>

                            <svg v-else class="w-6 h-6 text-gray-700 hover:fill-gray-700"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                            </svg>

                        </button>
                    </template>
                </SubscriptionButton>
            </div>
        </div>
    </div>
    <div ref="loadingRef">
        <TheLoadingSpinner v-if="channelLists.next_page_url"/>
    </div>
</AppLayout>
</template>

<style scoped>

</style>
