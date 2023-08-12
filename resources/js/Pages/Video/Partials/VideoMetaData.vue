<script setup>
    import {ref} from "vue";

    defineProps({
        video: {
            type: Object,
            default: () => {}
        }
    })

    const toggleDescription = ref(false)
</script>

<template>
<div class="my-10 bg-neutral-100 py-3.5 px-3.5 rounded-lg space-y-1">
    <p class="text-sm font-bold text-gray-500">
        {{ video.view_count }} Görüntülenme
        <span class="ms-1">{{ video.video_created_at }}</span>
    </p>
    <p class="text-gray-500 font-normal"
       :class="{'truncate': !toggleDescription}">
        {{ video.description ?? 'Açıklama yok' }}
    </p>
    <span v-if="video.description?.length >= 120"
          @click="toggleDescription = !toggleDescription"
          class="cursor-pointer font-medium text-sm">Daha fazla göster</span>
</div>
</template>

<style scoped>

</style>
