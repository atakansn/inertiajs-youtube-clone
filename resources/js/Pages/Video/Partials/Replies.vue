<script setup>
    import {ref} from "vue";
    import VoteComponent from "@Components/VoteComponent.vue";
    import LoadingSpinner from "@Components/LoadingSpinner.vue";
    import CircularAvatarWithPlaceHolderIcon from "@Components/CircularAvatarWithPlaceHolderIcon.vue";
    import AuthenticationModal from "@Components/AuthenticationModal.vue";
    import ButtonLoadMore from "@Components/ButtonLoadMore.vue";
    import ReplyStore from "@/Pages/Video/Partials/ReplyStore.vue";
    import DropdownAction from "@Components/DropdownAction.vue";
    import {router} from "@inertiajs/vue3";
    import CommentEdit from "@/Pages/Video/Partials/CommentEdit.vue";
    import ErrorModal from "@Components/ErrorModal.vue";

    const props = defineProps({
        comment: {},
        video: {},
        authUserChannel: {},
    })

    const replyAnswer = ref('')
    const newReplyText = ref('')
    const openReply = ref(null)
    const replies = ref([])

    const openReplies = ref(false)
    const loadingReplies = ref(false)
    const loadingLoadMore = ref(false)
    const showAuthModal = ref(false)
    const openActions = ref(false)
    const editReply = ref(false)
    const showErrorModal = ref(false)

    const closeErrorModal = () => showErrorModal.value = false

    const toggleActions = () => openActions.value = !openActions.value

    const closeEditComment = () => editReply.value = false

    const commentEdit = () => {
        openActions.value = false
        editReply.value = !editReply.value
    }

    const storeReplyAnswer = async () => {
        try {
            const {data} = await axios.post(
                route('comments.store', {video: props.video.id}),
                {
                    text: replyAnswer.value,
                    comment_id: props.comment.id
                }
            )

            replyAnswer.value = ''
            openReply.value = null
            replies.value = {
                ...replies.value,
                data: [
                    data,
                    ...replies.value.data
                ]
            }
        } catch (e) {
            showErrorModal.value = true
            throw e
        }
    }

    const loadReplies = async () => {
        loadingReplies.value = true

        try {
            const {data} = await axios.get('replies.show', {comment: props.comment.id})

            loadingReplies.value = false
            replies.value = data
        } catch (e) {
            showErrorModal.value = true
            throw e
        }
    }

    const toggleShowReplies = async () => {
        openReplies.value = !openReplies.value

        if (replies.value.length === 0) {
            return loadReplies()
        }
    }

    const repliesLoadMore = async () => {
        loadingLoadMore.value = true
        if (replies.value) {
            // axios.get(replies.value.next_page_url)
            //     .then(response => {
            //         loadingLoadMore.value = false
            //         replies.value = {
            //             ...replies.value,
            //             data: [
            //                 ...response.data.data,
            //                 ...replies.value.data
            //             ]
            //         }
            //     })
            
            try {
                const {data} = axios.get(replies.value.next_page_url)

                loadingLoadMore.value = false
                replies.value = {
                    ...replies.value,
                    data: [
                        ...data.data,
                        ...replies.value.data
                    ]
                }
                
            } catch (e) {
                showErrorModal.value = true
                throw e
            }
        }
    }

    const openAuthModal = () => {
        if (!props.authUserChannel) {
            return showAuthModal.value = true
        }

        showAuthModal.value = false
    }

    const closeAuthModal = () => {
        showAuthModal.value = false
    }

    const patchReply = (replyId) => {
        router.patch(route('reply.update', {commentId: replyId}), {
            content: newReplyText.value
        }, {
            onSuccess: () => editReply.value = false,
            preserveScroll: true,
            preserveState: false
        })
    }

</script>

<template>
<ErrorModal :visibleable="showErrorModal"
            @close="closeErrorModal"/>

<AuthenticationModal @close="closeAuthModal"
                     :visibleable="showAuthModal"/>

<LoadingSpinner v-if="loadingReplies"
                class="inline-flex justify-center mt-4 ml-12"
                spinner-class="h-8 w-8"/>

<!-- Reply Button  -->
<button v-else
        @click="toggleShowReplies"
        v-show="comment?.replies?.length > 0"
        type="button"
        class="mt-3 inline-flex items-center text-md font-medium text-black hover:text-neutral-500">
    <svg v-if="!openReplies" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
    </svg>
    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
         stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
    </svg>

    <span class="ml-3">{{ props.comment?.replies?.length }} Yanıt</span>
</button>

<div v-if="openReplies"
     v-for="(reply, index) in replies.data"
     :key="index"
     class="flex items-start space-x-2.5 -mb-3">
    <div class="flex-none py-4">
        <img :src="reply?.user?.channel.channel_photo_url"
             :alt="reply?.user?.channel?.identifier ?? ''"
             class="h-8 w-8 rounded-full bg-gray-100">
    </div>
    <div class="flex-1 py-4">
        <div class="flex items-center">
            <h3 class="font-medium text-gray-900">@{{ reply?.user?.channel?.identifier }}</h3>
            <p class="ml-1.5 font-medium">
                <time datetime="2021-07-12">{{ reply?.comment_created_at }}</time>
            </p>

            <DropdownAction
                    v-if="video?.channel?.user_id === authUserChannel?.user_id || reply?.user_id === authUserChannel?.user_id"
                    :video="video"
                    :comment="reply"
                    :auth-user-channel="authUserChannel"
                    :openActions="openActions"
                    @editAction="commentEdit"
                    @toggle="toggleActions"/>
        </div>

        <div class="prose prose-sm mt-1 max-w-none text-gray-500">
            <!-- Content -->
            <CommentEdit v-if="editReply"
                         v-model="newReplyText"
                         @close-edit-comment="closeEditComment"
                         @update-comment="patchReply(reply.id)"/>

            <p v-else>{{ reply.content }}</p>

            <!-- Vote and Reply -->
            <div class="flex mt-3">
                <VoteComponent :auth-user-id="authUserChannel?.user_id"
                               :key="index"
                               :default-votes="reply.votes"
                               :entity-id="reply.id"/>

                <button @click="openReply = reply.id"
                        type="button"
                        class="text-md ms-4 font-semibold text-black hover:text-neutral-500">
                    Yanıtla
                </button>
            </div>
        </div>

        <!-- Reply -->
        <ReplyStore v-if="openReply === reply.id"
                    v-model="replyAnswer"
                    @store-reply-answer="storeReplyAnswer"
                    @open-auth-modal="openAuthModal"
                    :auth-user-channel-photo="authUserChannel?.channel_photo_url"
                    :reply-id="openReply"/>
    </div>
</div>

<!-- Load More -->
<div v-if="openReplies"
     v-show="!!replies.next_page_url"
     class="flex mt-5">
    <ButtonLoadMore spinner-class="h-8 w-8 -mt-12 ml-28"
                    @load-more="repliesLoadMore"
                    :show-spinner="loadingLoadMore"/>
</div>
</template>

<style scoped>

</style>
