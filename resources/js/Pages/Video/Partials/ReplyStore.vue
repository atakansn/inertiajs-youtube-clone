<script setup>
    import CircularAvatarWithPlaceHolderIcon from "@Components/CircularAvatarWithPlaceHolderIcon.vue";

    defineProps({
        authUserChannelPhoto: {},
        replyId: {},
        modelValue: {}
    })

    const emits = defineEmits(['update:modelValue', 'storeReplyAnswer', 'openAuthModal'])
</script>

<template>
<div class="flex items-start space-x-3 mt-4">
    <div class="flex-shrink-0">
        <img v-if="!!authUserChannelPhoto"
             class="inline-block h-8 w-8 rounded-full"
             :src="authUserChannelPhoto" alt="">
        <CircularAvatarWithPlaceHolderIcon v-else />
    </div>
    <div  class="min-w-0 flex-1">
        <form @submit.prevent="emits('storeReplyAnswer')">
            <div class="border-b border-gray-200 focus-within:border-indigo-600">
                <label for="comment" class="sr-only">Yanıtı cevaplayın...</label>
                <textarea @click="emits('openAuthModal')"
                          @input="emits('update:modelValue', $event.target.value)"
                          :value="modelValue"
                          rows="3"
                          class="block w-full resize-none border-0 border-b border-transparent p-0 pb-2 focus:border-indigo-600 focus:ring-0 sm:text-sm" placeholder="Yanıtı cevaplayın...">
                </textarea>
            </div>
            <div v-if="!!authUserChannelPhoto" class="flex justify-end pt-2">
                <div class="flex-shrink-0">
                    <button
                        @click="replyId = null"
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
