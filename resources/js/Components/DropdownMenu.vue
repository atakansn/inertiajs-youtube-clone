<script setup>
    import {Link, usePage} from "@inertiajs/vue3";
    import {onMounted, onUnmounted, ref} from "vue";
    import CircularAvatarWithPlaceHolderIcon from "./CircularAvatarWithPlaceHolderIcon.vue";

    defineProps({
        channel: {}
    })

    const authUser = usePage().props.auth.user

    const dropdown = ref(false)

    const closeWithEscape = e => {
        dropdown.value = false
    }

    onMounted(() => {
        window.addEventListener('keydown', closeWithEscape)
    })

    onUnmounted(() => {
        window.removeEventListener('keydown', closeWithEscape)
    })
</script>

<template>
<div class="relative ml-4">
    <div>
        <button @click="dropdown = !dropdown"
                type="button"
                class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                id="user-menu-button" aria-expanded="false" aria-haspopup="true">

            <img v-if="!!channel" class="h-9 w-9 rounded-full"
                 :class="$attrs.class"
                 :src="channel.channel_photo_url"
                 alt="">

            <CircularAvatarWithPlaceHolderIcon v-else/>
        </button>
    </div>

    <Transition enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transition ease-out duration-100"
                appear-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
    >
        <div v-if="dropdown"
             class="absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
             role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            <div v-if="!!channel" class="px-4 py-3" role="none">
                <p class="text-sm" role="none">Olarak giriş yaptınız</p>
                <p class="truncate text-sm font-medium text-gray-900" role="none">{{ authUser.email }}</p>
            </div>

            <div v-if="!!channel" class="py-1" role="none">
                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                <Link :href="`/@${channel.identifier}/videos`"
                      class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      :class="{'bg-gray-100': route().current('channel-videos')}"
                      role="menuitem" tabindex="-1"
                      id="user-menu-item-0">
                    Kanalım
                </Link>

                <Link :href="route('channel-dashboard.video.upload.index',{channel: channel.id})"
                      class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      :class="{'bg-gray-100': route().current('channel-dashboard.video.upload.index')}"
                      role="menuitem" tabindex="-1"
                      id="user-menu-item-0">
                    Kontrol Paneli
                </Link>

                <Link :href="route('settings.index')"
                      class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      :class="{'bg-gray-100': route().current('settings.index')}"
                      role="menuitem"
                      tabindex="-1"
                      id="user-menu-item-1">
                    Ayarlar
                </Link>

                <Link :href="route('logout')"
                      method="post"
                      as="button"
                      type="button"
                      class="text-gray-700 block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 hover:text-gray-90"
                      role="menuitem"
                      tabindex="-1">
                    Çıkış Yap
                </Link>
            </div>

            <div v-else class="py-1" role="none">
                <Link href="/register"
                      class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      :class="{'bg-gray-100': route().current('register')}"
                      role="menuitem"
                      tabindex="-1"
                      id="user-menu-item-1">
                    Kayıt Ol
                </Link>

                <Link href="/login"
                      :class="{'bg-gray-100': route().current('login')}"
                      class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    Giriş Yap
                </Link>
            </div>
        </div>
    </Transition>
</div>
</template>

<style scoped>

</style>
