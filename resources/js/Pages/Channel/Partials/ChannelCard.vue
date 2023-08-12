<script setup>
    import ChannelCustomizeButton from "./ChannelCustomizeButton.vue";
    import ChannelPhoto from "./ChannelPhoto.vue";
    import SubscriptionButton from "../../../Components/SubscriptionButton.vue";
    import {computed} from "vue";

    const props = defineProps({
        channel: {},
        auth: {}
    })
</script>

<template>
<div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
    <div class="flex">
        <ChannelPhoto :channel-photo="channel.channel_photo_url"/>
    </div>
    <div class="sm:flex sm:min-w-0 sm:flex-1 sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
        <div class="mt-9 min-w-0 flex-1 sm:hidden md:block">
            <h1 class="truncate text-2xl font-bold text-gray-900">{{ channel.name }}</h1>
            <p class="text-sm">
                <span class="font-bold me-2">@{{ channel.identifier }}</span>

                <span class="me-2">{{ channel.subscriptions_count ?? 0 }} Abone</span>
                <span>{{ channel.videos_count ?? 0 }} Video</span>
            </p>
        </div>
        <div class="justify-stretch mt-9 flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
            <SubscriptionButton :channel="channel"/>

            <ChannelCustomizeButton v-if="!!auth.user"
                                    v-show="channel.user_id === auth.user.id"
                                    :channel-id="channel.id"/>
        </div>
    </div>
</div>
<div class="mt-6 hidden min-w-0 flex-1 sm:block md:hidden">
    <h1 class="truncate text-2xl font-bold text-gray-900">{{ channel.name }}</h1>
</div>
</template>

<style scoped>

</style>
