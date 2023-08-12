<script setup>
    import ChannelDashboard from "../../Layouts/ChannelDashboard.vue";

    defineProps({
        totalSubscriptions: {},
        totalVideos: {},
        totalComments: {}
    })
</script>

<template>

<ChannelDashboard class="bg-none" head-title="Kontrol Paneli">
    <template #pageHeading>
        Panel
    </template>

    <div class="mt-5">
        <h3 class="text-md font-medium leading-6 text-gray-900">İstatistikler</h3>

        <dl class="mt-2 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Toplam Abone</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{totalSubscriptions ?? 0}}</dd>
            </div>

            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Toplam Video</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{totalVideos ?? 0}}</dd>
            </div>

            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Yapmış Olduğunuz Yorum Sayısı</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{totalComments ?? 0}}</dd>
            </div>
        </dl>
    </div>
</ChannelDashboard>
</template>

<style scoped>

</style>
