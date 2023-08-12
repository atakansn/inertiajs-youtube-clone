<script setup>
    import {Link} from "@inertiajs/vue3";

    defineProps({
        channelIdentifier: {}
    })

</script>

<template>
<div :class="$attrs.class">
    <Link :href="route('home')"
          :class="{'border-gray-700 text-gray-900 border-b-2': route().current('home')}"
          class="inline-flex items-center px-1 pt-1 text-sm text-gray-500 font-medium hover:border-gray-300 hover:text-gray-700 hover:border-b-2">
        Anasayfa
    </Link>

    <Link v-if="!!channelIdentifier" :href="`/@${channelIdentifier}/videos`"
          :class="{'border-gray-700 text-gray-900 border-b-2' : route().current('channel.videos')}"
          class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 hover:border-b-2">
        Kanalım
    </Link>

    <Link v-if="!!channelIdentifier" :href="route('settings.index')"
          :class="{'border-gray-700 text-gray-900 border-b-2' : route().current('settings.index')}"
          class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 hover:border-b-2">
        Ayarlar
    </Link>

    <Link :href="route('channels')"
          :class="{'border-gray-700 text-gray-900 border-b-2': route().current('channels')}"
          class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 hover:border-b-2">
        Kanallar
    </Link>
</div>
</template>

<style scoped>

</style>
