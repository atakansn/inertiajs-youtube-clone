<script setup>
    import {computed, onMounted, ref} from "vue";
    import {usePage} from "@inertiajs/vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import Comments from "./Partials/Comments.vue"
    import VideoMetaData from "./Partials/VideoMetaData.vue";
    import CommentStore from "./Partials/CommentStore.vue";
    import AllVideos from "./Partials/AllVideos.vue";
    import ChannelAvatarWithText from "./Partials/ChannelAvatarWithText.vue";
    import {useInitialVideoPlayer} from "@Composables/useInitialVideoPlayer.js"
    import SubscriptionButton from "@Components/SubscriptionButton.vue";
    import VoteComponent from "@Components/VoteComponent.vue";
    import LoadingSpinner from "@Components/LoadingSpinner.vue";
    import ErrorModal from "@Components/ErrorModal.vue";

    const props = defineProps({
        video: {},
        comments: {},
        allVideo: {},
    })

    const {
        channel: authUserChannel,
        user: authUser,
    } = computed(() => usePage().props.auth).value
    
    const commentsRef = ref(props.comments)
    const videoPlayer = ref(null)
    const loadMoreRef = ref(null)
    const newCommentInput = ref('')
    const showErrorModal = ref(false)

    const closeErrorModal = () => showErrorModal.value = false
    
    const storeNewComment = () => {
        if (!newCommentInput.value) return

        axios.post(route('comments.store', {video: props.video.id}), {text: newCommentInput.value})
            .then(({data}) => {
                newCommentInput.value = ''
                commentsRef.value.data.unshift(data)
            })
    }

    const intersectionCommentLoadMore = async (entries, observer) => {
        if (entries[0].isIntersecting && commentsRef.value.next_page_url) {
            try {
                const {data} = await axios.get(commentsRef.value.next_page_url)

                commentsRef.value = {
                    ...data.comments,
                    data: [
                        ...commentsRef.value.data,
                        ...data.comments.data
                    ]
                }

                if (!data.comments.next_page_url) {
                    observer.unobserve(loadMoreRef.value)
                }

            } catch (e) {
                showErrorModal.value = true
                observer.unobserve(loadMoreRef.value)
                throw e
            }
        }
    }

    const intersectionObserver = new IntersectionObserver(intersectionCommentLoadMore)

    onMounted(() => {
        window.player = useInitialVideoPlayer({
            playerElement: videoPlayer.value,
            videoProp: props.video,
            authUserChannelId: authUserChannel?.id
        })

        intersectionObserver.observe(loadMoreRef.value)
    })

</script>

<template>
<ErrorModal @close="closeErrorModal"
            :visibleable="showErrorModal"/>

<AppLayout :head-title="props.video.title">
    <div
        class="mx-auto py-5 px-2 sm:py-2 sm:px-6 lg:max-w-screen-2xl lg:px-2 lg:grid lg:grid-cols-7 lg:grid-rows-1 lg:gap-x-8 lg:gap-y-7 xl:gap-x-7">

        <!-- Player -->
        <div class="lg:col-span-5 lg:row-end-1">
            <div class="w-full h-[35rem] object-center object-cover aspect-w-1 overflow-hidden">
                <video ref="videoPlayer" controls playsinline></video>
            </div>
        </div>

        <!-- All videos -->
        <AllVideos :all-videos="allVideo"/>

        <!-- Content -->
        <div class="lg:col-span-5 lg:mt-0 lg:max-w-none">
            <!-- Video Content -->
            <div>
                <!-- Video Title -->
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                    {{ video?.title }}
                </h1>

                <div class="flex justify-between items-center mt-5">
                    <!-- Channel Avatar --->
                    <div class="flex items-start space-x-12 space-y-1.5">
                        <ChannelAvatarWithText :video="video"/>
                    </div>

                    <!-- Video Like Dislike, Subscription Button --->
                    <div class="flex">
                        <!-- Subscription Button --->
                        <SubscriptionButton :channel="video?.channel"
                                            custom-class="me-5 mt-0.5"
                        />

                        <!-- Video Like Dislike -->
                        <VoteComponent :entity-id="video.id"
                                       :key="video.id"
                                       :auth-user-id="authUser?.id"
                                       :default-votes="video.votes"
                        />
                    </div>
                </div>
            </div>

            <!-- Description, Views, Created At --->
            <VideoMetaData :video="video"/>

            <!-- Store New Comment --->
            <CommentStore @store-new-comment="storeNewComment"
                          v-model="newCommentInput"
                          :video="video"
                          :auth-user-channel="authUserChannel"
            />

            <!-- Comments --->
            <Comments v-for="(comment,index) in commentsRef.data"
                      :key="index"
                      :comment="comment"
                      :video="video"
                      :auth-user-channel="authUserChannel"
            />

            <div ref="loadMoreRef">
                <LoadingSpinner v-if="commentsRef?.next_page_url"
                                spinner-class="h-8 h-8"/>
            </div>
        </div>
    </div>
</AppLayout>
</template>

<style scoped>

</style>
