<script setup>
    import {computed, ref} from "vue";
    import {Head, usePage} from "@inertiajs/vue3";
    import DropdownMenu from "../Components/DropdownMenu.vue";
    import SidebarMenuForMobile from "../Pages/ChannelDashboard/Partials/Statics/SidebarMenuForMobile.vue";
    import SidebarMenuForDesktop from "../Pages/ChannelDashboard/Partials/Statics/SidebarMenuForDesktop.vue";
    
    const channelProp = computed(() => usePage().props.auth.channel)

    const props = defineProps({
        class:{
            type: String,
            default: () => 'bg-white px-5 py-5'
        },
        headTitle: String
    })
</script>

<template>
<Head>
    <title>{{headTitle}}</title>
</Head>

<div>
    <SidebarMenuForMobile :channel="channelProp" />

    <SidebarMenuForDesktop :channel="channelProp" />

    <div class="flex flex-1 flex-col md:pl-64">
        <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-white shadow">
            <button type="button" class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                <span class="sr-only">Open sidebar</span>
                <!-- Heroicon name: outline/bars-3-bottom-left -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                </svg>
            </button>
            <div class="flex flex-1 justify-end px-4">
                <div class="ml-4 flex items-center md:ml-6">
                    <button type="button" class="rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">View notifications</span>
                        <!-- Heroicon name: outline/bell -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </button>

                    <DropdownMenu :channel="channelProp" />
                </div>
            </div>
        </div>

        <main class="flex-1">
            <div class="py-6">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        <slot name="pageHeading"/>
                    </h1>
                </div>
                <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                    <!-- Replace with your content -->
                    <div class="py-4">
                        <div class="rounded-lg" :class="props.class">
                            <slot />
                        </div>
                    </div>
                    <!-- /End replace -->
                </div>
            </div>
        </main>
    </div>
</div>

</template>

<style scoped>

</style>
