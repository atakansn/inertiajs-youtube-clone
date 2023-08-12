<script setup lang="ts">
    import {computed, ref} from "vue";
    import {usePage} from "@inertiajs/vue3";
    import Search from "./Search.vue";
    import NavbarLinks from "./NavbarLinks.vue";
    import DropdownMenu from "./DropdownMenu.vue";
    import MobileMenuButton from "./MobileMenuButton.vue";
    import MobileMenu from "./MobileMenu.vue";
    import NotificationButton from "./NotificationButton.vue";
    import Logo from "./Logo.vue";

    const props = defineProps({
        headerText: String,
        showHeader: Boolean,
    })

    const showMobileMenu = ref(false)
    const channelProp = computed(() => usePage().props.auth.channel)
</script>

<template>
<nav class="bg-white shadow">
    <div class="mx-auto max-w-full px-2 sm:px-4 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex px-2 lg:px-0">
                <div class="flex flex-shrink-0 items-center">
                    <Logo custom-class="block h-8 w-auto lg:hidden" />
                    <Logo custom-class="hidden h-8 w-auto lg:block" />
                </div>
                <NavbarLinks :channel-identifier="channelProp?.identifier"
                             class="hidden lg:ml-6 lg:flex lg:space-x-8"/>
            </div>

            <!-- Search -->
            <div class="flex flex-1 items-center justify-center px-2 lg:ml-6 lg:justify-end">
                <Search/>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center lg:hidden">
                <MobileMenuButton @show-mobile-menu="showMobileMenu = !showMobileMenu"/>
            </div>

            <!-- Dropdown Menu -->
            <div class="hidden lg:ml-4 lg:flex lg:items-center">
                <NotificationButton/>
                <DropdownMenu :channel="channelProp"/>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <MobileMenu v-if="showMobileMenu" :channel="channelProp"/>
</nav>
</template>
