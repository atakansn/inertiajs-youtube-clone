<script setup>
    import CircularAvatarWithPlaceHolderIcon from "@Components/CircularAvatarWithPlaceHolderIcon.vue";
    import AuthenticationModal from "@Components/AuthenticationModal.vue";
    import {ref} from "vue";

    const props = defineProps({
        video: {
            type: Object,
            required: true
        },
        authUserChannel: {
            required: true,
        },
        modelValue: {
            type: String
        }
    })

    const shoAuthModal = ref(false)
    const emit = defineEmits(['storeNewComment', 'update:modelValue'])

    const openAuthModal = () => {
        if (!props.authUserChannel) {
            return shoAuthModal.value = true
        }

        shoAuthModal.value = false
    }

    const close = () => {
        shoAuthModal.value = false
    }
</script>

<template>
<AuthenticationModal @close="close"
                     :visibleable="shoAuthModal"/>
<div>
    <h2 class="text-lg font-medium text-gray-900 border-b border-gray-200 mb-7">
        {{ video.comments_count }} Yorum</h2>
    <div class="flex items-start space-x-4">
        <div class="flex-shrink-0">
            <img v-if="!!authUserChannel"
                 class="inline-block h-10 w-10 rounded-full"
                 :src="authUserChannel?.channel_photo_url"
                 alt="">
            <CircularAvatarWithPlaceHolderIcon v-else
                                               class="h-10 w-10"/>
        </div>
        <div class="min-w-0 flex-1 mb-8">
            <form @submit.prevent="emit('storeNewComment')">
                <div class="border-b border-gray-200 focus-within:border-indigo-600">
                    <label for="comment" class="sr-only">Yanıtınızı Ekleyin</label>
                    <textarea @click.stop="openAuthModal"
                              :value="modelValue"
                              :disabled="shoAuthModal"
                              @input="emit('update:modelValue', $event.target.value)" rows="3" name="comment"
                              id="comment"
                              class="block w-full resize-none border-0 border-b border-transparent p-0 focus:border-indigo-600 focus:ring-0 sm:text-sm"
                              placeholder="Yorum Ekleyin..."></textarea>
                </div>
                <div v-if="modelValue.length > 0"
                     class="flex justify-end pt-2">
                    <button type="submit"
                            :disabled="modelValue.length === 0"
                            :class="{'disabled:opacity-75': modelValue.length === 0, 'hover:bg-indigo-700': modelValue.length > 0}"
                            class="disabled:opacity-75 inline-flex items-center rounded-full border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Yorum Yap
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
