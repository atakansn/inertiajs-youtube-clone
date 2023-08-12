<script setup>
    import {ref} from "vue";
    import CircularAvatarWithPlaceHolderIcon from "@Components/CircularAvatarWithPlaceHolderIcon.vue";
    import AuthenticationModal from "@Components/AuthenticationModal.vue";

    const props = defineProps({
        modelValue: String,
        authUserChannelPhoto: {},
        openReply: Boolean
    })

    const openReplyRef = ref(props.openReply)
    const showAuthModal = ref(false)

    const emits = defineEmits(['storeReply', 'update:modelValue'])

    const openAuthModal = () => {
        if (!props.authUserChannelPhoto) {
            return showAuthModal.value = true
        }

        showAuthModal.value = false
    }

    const closeAuthModal = () => showAuthModal.value = false
</script>

<template>
<AuthenticationModal @close="closeAuthModal"
                     :visibleable="showAuthModal" />

<div class="mt-4 flex items-start space-x-3">
    <div class="flex-shrink-0">
        <img v-if="!!authUserChannelPhoto" class="inline-block h-8 w-8 rounded-full"
             :src="authUserChannelPhoto" alt="">
        <CircularAvatarWithPlaceHolderIcon v-else/>
    </div>
    <div class="min-w-0 flex-1">
        <form @submit.prevent="emits('storeReply')">
            <div class="border-b border-gray-200 focus-within:border-indigo-600">
                <label for="comment" class="sr-only">Yanıtınızı Ekleyin...</label>
                <textarea @click="openAuthModal"
                          :disabled="showAuthModal"
                          @input="emits('update:modelValue', $event.target.value)"
                          :value="modelValue"
                          rows="3"
                          class="block w-full resize-none border-0 border-b border-transparent p-0 pb-2 focus:border-indigo-600 focus:ring-0 sm:text-sm"
                          placeholder="Yanıtızı Ekleyin...">
                </textarea>
            </div>
            <div v-if="!!authUserChannelPhoto" class="flex justify-end pt-2">
                <div class="flex-shrink-0">
                    <button
                        @click="openReplyRef = false"
                        type="button"
                        class="mr-2 inline-flex items-center rounded-full border border-transparent bg-indigo-600 px-4 py-2 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        İptal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center rounded-full border border-transparent bg-indigo-600 px-4 py-2 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Yanıtla
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</template>

<style scoped>

</style>
