<script setup>
    import {computed} from "vue";
    import {Head, usePage} from "@inertiajs/vue3";
    import ChannelViewTemplate from "@/Pages/Channel/Partials/ChannelViewTemplate.vue";

    const props = defineProps({
        channel: {}
    })

    const auth = computed(() => usePage().props.auth)
</script>

<template>
<Head>
    <title>Kanal Hakkında</title>
</Head>

<ChannelViewTemplate :channel="channel" :head-title="`${channel.name} - Hakkında`">
    <div>
        <dl class="divide-y divide-gray-100">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Kanal Adı</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{channel.name}}</dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Belirteç</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{channel.identifier}}</dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">E-posta</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{channel.user.email}}</dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Hakkında</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    {{channel.description ?? 'Açıklama yok'}}
                </dd>
            </div>
        </dl>
    </div>
</ChannelViewTemplate>
</template>

<style scoped>

</style>
