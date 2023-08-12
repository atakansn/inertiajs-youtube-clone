<script setup>
    import {Link} from "@inertiajs/vue3";

    defineProps({
        video: {}
    })
</script>

<template>
<Link :href="`@${video.channel.identifier}/videos`"
      class="group block mt-0.5 flex-shrink-0">
    <div class="flex items-center">
        <div>
            <img class="inline-block h-11 w-11 rounded-full"
                 :src="`${video.channel.channel_photo_url}`"
                 alt="">
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">
                {{ video.channel.name }}
            </p>
            <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">
                {{ video.channel.subscriptions_count ?? video.channel.subscriptions.length }} Abone
            </p>
        </div>
    </div>
</Link>
</template>

<style scoped>

</style>
