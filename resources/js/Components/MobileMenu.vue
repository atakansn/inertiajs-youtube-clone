<script setup>
    import {Link, usePage} from "@inertiajs/vue3";

    defineProps({
        channel: {}
    })

    const pageProps = usePage().props
    const authUser = pageProps.auth.user
</script>

<template>
<div class="lg:hidden" id="mobile-menu">
    <div class="space-y-1 pt-2 pb-3">
        <!-- Current: "bg-indigo-50 border-indigo-500 text-indigo-700", Default: "border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800" -->
        <Link :href="route('home')"
              :class="{'bg-indigo-50 border-indigo-500 text-indigo-700': route().current('home')}"
              class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800">
            Anasayfa
        </Link>

        <div v-if="!!channel">
            <Link :href="route('channel.videos',{identifier: channel?.id })"
                  :class="{'bg-indigo-50 border-indigo-500 text-indigo-700' : route().current('channel.videos')}"
                  class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800">
                Kanalım
            </Link>

            <Link :href="route('settings.index')"
                  :class="{'bg-indigo-50 border-indigo-500 text-indigo-700' : route().current('settings')}"
                  class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800">
                Ayarlar
            </Link>
        </div>

        <Link :href="route('channels')"
              :class="{'bg-indigo-50 border-indigo-500 text-indigo-700': route().current('channels')}"
              class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800">
            Kanallar
        </Link>
    </div>
    <div class="border-t border-gray-200 pt-4 pb-3">
        <div class="flex items-center px-4">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full"
                     :src="channel?.channel_photo_url"
                     alt="">
            </div>
            <div class="ml-3">
                <div class="text-base font-medium text-gray-800">{{ channel.name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ authUser.email }}</div>
            </div>
            <button type="button"
                    class="ml-auto flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <span class="sr-only">Bildirimleri Görüntüle</span>
                <!-- Heroicon name: outline/bell -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                </svg>
            </button>
        </div>
        <div class="mt-3 space-y-1">
            <div v-if="!!channel">
                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                <Link :href="route('channel.videos',{identifier: channel.id })"
                      class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800"
                      :class="{'bg-gray-100': route().current('channel-videos')}">
                    Kanalım
                </Link>

                <Link :href="route('settings.index')"
                      class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800"
                      :class="{'bg-gray-100': route().current('settings.index')}">
                    Ayarlar
                </Link>

                <Link :href="route('logout')"
                      method="post"
                      as="button"
                      type="button"
                      class="w-full px-4 py-2 text-start font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">
                    Çıkış Yap
                </Link>
            </div>

            <div v-else>
                <Link :href="route('register')"
                      class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800"
                      :class="{'bg-gray-100': route().current('register')}"
                      role="menuitem"
                      tabindex="-1"
                      id="user-menu-item-1">
                    Kayıt Ol
                </Link>

                <Link :href="route('login')"
                      :class="{'bg-gray-100': route().current('login')}"
                      class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">
                    Giriş Yap
                </Link>
            </div>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
