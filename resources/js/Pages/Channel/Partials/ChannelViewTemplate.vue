<script setup>
    import AppLayout from "@/Layouts/AppLayout.vue";
    import {usePage} from "@inertiajs/vue3";
    import CoverPhoto from "../Partials/CoverPhoto.vue";
    import Tab from "./Tab.vue";
    import ChannelCard from "./ChannelCard.vue";

    const props = defineProps({
        channelVideos: {},
        channel: {},
        headTitle: String
    })

    const auth = usePage().props.auth

</script>

<template>
<AppLayout class="py-0" :head-title="headTitle">
    <div>
        <!-- Cover Photo -->
        <CoverPhoto :channel-cover-photo="channel.channel_cover_photo_url"/>

        <!-- Channel Information -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <ChannelCard :channel="channel" :auth="auth"/>
        </div>

        <!--Tab-->
        <Tab :identifier="channel"/>

        <!-- Content -->
        <div class="mx-auto max-w-7xl px-4 py-12 lg:py-9">
            <div class="px-3">
                <div class="space-y-12">
                    <slot/>
                </div>
            </div>
        </div>
    </div>
</AppLayout>
</template>

<style scoped>

</style>
