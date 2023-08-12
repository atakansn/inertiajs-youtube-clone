<script setup>
    defineProps({
        channelPhoto: {}
    })
</script>

<template>
<img class="h-24 w-24 rounded-full ring-4 ring-white sm:h-32 sm:w-32"
     :src="channelPhoto"
     alt="">
</template>

<style scoped>

</style>
