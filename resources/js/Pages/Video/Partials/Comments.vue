<script setup>
    import {computed, ref} from "vue";
    import {router, Link} from "@inertiajs/vue3";
    import Replies from "./Replies.vue";
    import VoteComponent from "@Components/VoteComponent.vue";
    import DropdownAction from "@Components/DropdownAction.vue";
    import AuthenticationModal from "@Components/AuthenticationModal.vue";
    import CommentEdit from "./CommentEdit.vue";
    import CommentStoreReply from "./CommentStoreReply.vue";
    import ErrorModal from "@Components/ErrorModal.vue";

    const props = defineProps({
        comment: {},
        video: {},
        authUserChannel: {}
    })
    
    const openReply = ref(false)
    const openReplies = ref(false)
    const replyInput = ref('')
    const replies = ref([])
    const openActions = ref(false)
    const editComment = ref(false)
    const newCommentText = ref(props.comment.content)
    const showAuthModal = ref(false)
    const showErrorModal = ref(false)
    
    const closeErrorModal = () => showErrorModal.value = false

    const storeComment = async () => {
        try {
            const {data} = await axios.post(
                route('comments.store', {video: props.video.id}),
                {
                    text: replyInput.value,
                    comment_id: props.comment.id
                })

            replyInput.value = ''
            openReply.value = false
            openReplies.value = true

            props.comment.replies.unshift(data)
        } catch (e) {
            showErrorModal.value = false
            throw e
        }
    }

    const toggleActions = () => openActions.value = !openActions.value

    const closeEditComment = () => editComment.value = false

    const commentEdit = () => {
        openActions.value = false
        editComment.value = !editComment.value
    }

    const updateComment = () => {
        router.patch(route('comments.update', {comment: props.comment.id}), {
            content: newCommentText.value
        }, {
            onSuccess: () => editComment.value = false,
            preserveScroll: true,
            preserveState: false
        })
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

    const isRecordUpdated = computed(() => props.comment.updated_at > props.comment.created_at ? '(Düzenlendi)' : '')

</script>

<template>
<ErrorModal :visibleable="showErrorModal"
            @close="closeErrorModal"/>

<AuthenticationModal @close="closeAuthModal"
                     :visibleable="showAuthModal"/>

<div class="-my-12">
    <div class="flex space-x-4 text-sm text-gray-500">
        <div class="flex-none py-10">
            <Link :href="`/@${comment?.user?.channel?.identifier}/videos`">
                <img :src="comment?.user?.channel.channel_photo_url"
                     alt="" class="h-10 w-10 rounded-full bg-gray-100">
            </Link>
        </div>
        <div class="flex-1 py-10 border-gray-200">
            <div class="flex items-center">
                <Link :href="`/@${props.comment?.user?.channel?.identifier}/videos`">
                    <h3 class="font-medium text-gray-900">@{{ props.comment?.user?.channel?.identifier }}</h3>
                </Link>
                <p class="ml-1.5 font-medium">
                    <time datetime="2021-07-12">{{ props.comment.comment_created_at }}
                        <span class="text-gray-700">{{ isRecordUpdated }}</span>
                    </time>
                </p>

                <!-- Dropdown Action -->
                <DropdownAction v-if="video?.channel?.user_id === authUserChannel?.user_id || comment?.user_id === authUserChannel?.user_id"
                                :video="props.video"
                                :comment="props.comment"
                                :auth-user-channel="authUserChannel"
                                :openActions="openActions"
                                @editAction="commentEdit"
                                @toggle="toggleActions"/>
            </div>

            <div class="prose prose-sm mt-1 max-w-none text-gray-500">
                <CommentEdit v-if="editComment"
                             v-model="newCommentText"
                             @close-edit-comment="closeEditComment"
                             @update-comment="updateComment"/>
                
                <p v-else>{{ props.comment.content }}</p>
            </div>

            <div class="flex mt-3">
                <VoteComponent :default-votes="props.comment.votes"
                               :key="props.comment.id"
                               :entity-id="props.comment.id"
                               :auth-user-id="authUserChannel?.user_id"/>

                <button @click="openReply = !openReply"
                        type="button"
                        class="text-md ms-4 font-semibold text-black hover:text-neutral-500">
                    Yanıtla
                </button>
            </div>

            <!-- Store Reply -->
            <CommentStoreReply v-if="openReply"
                               :auth-user-channel-photo="authUserChannel?.channel_photo_url"
                               @store-reply="storeComment"
                               v-model="replyInput"
                               :openReply="openReply"/>


            <!-- Replies -->
            <Replies :comment="comment"
                     :key="comment.id"
                     :auth-user-channel="authUserChannel"
                     :video="video"
            />

        </div>
    </div>
</div>
</template>
