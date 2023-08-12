<script setup>
    import {Link, router} from "@inertiajs/vue3"
    import {computed, ref, watchEffect} from "vue";

    const props = defineProps({
        openActions: {
            type: Boolean
        },
        comment: {},
        authUserChannel: {},
        video: {}
    })

    const emit = defineEmits(['toggle', 'editAction'])
    const openActionsRef = ref()

    watchEffect(() => {
        openActionsRef.value = props.openActions
    })

    const commentDelete = () => {
        router.delete(route('comments.destroy', {comment: props.comment.id}), {
            preserveState: false,
            onSuccess: () => {
                openActionsRef.value = false
            },
            preserveScroll: true,
        })
    }

    const canDeleteComment = computed(
        () => props.comment.user_id === props.authUserChannel.user_id || props.authUserChannel.id === props.video.channel.id
    )
    const canEditComment = computed(() => props.comment.user_id === props.authUserChannel.user_id)
</script>

<template>
<div class="relative inline-block text-left ml-3">
    <div>
        <button @click="emit('toggle')"
                type="button"
                class="flex rounded-full items-center text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100">
            <span class="sr-only">Aksiyonları Gör</span>
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                 aria-hidden="true">
                <path
                    d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z"/>
            </svg>
        </button>
    </div>

    <Transition enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95">
        <div v-if="openActionsRef"
             class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
             role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            <div class="py-1" role="none">
                <button @click.prevent="commentDelete"
                        v-if="canDeleteComment"
                        class="text-gray-700 block px-4 w-full text-start py-2 text-sm hover:bg-gray-100"
                        role="menuitem" tabindex="-1" id="menu-item-0">Sil
                </button>

                <button @click.prevent="emit('editAction')"
                        v-if="canEditComment"
                        class="text-gray-700 block px-4 w-full text-start py-2 text-sm hover:bg-gray-100"
                        role="menuitem" tabindex="-1" id="menu-item-0">Düzenle
                </button>
            </div>
        </div>
    </Transition>
</div>
</template>

<style scoped>

</style>
