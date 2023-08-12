<script setup>
    defineProps({
        channelCoverPhoto: {}
    })
</script>

<template>
<div>
    <img class="h-32 w-full object-cover lg:h-56 rounded-md rounded-b-none"
         :src="channelCoverPhoto"
         alt="">
</div>
</template>

<style scoped>

</style>
