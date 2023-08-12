<script setup>
    import {nextTick, onMounted, onUnmounted, ref, watch} from "vue";
    import {Link} from "@inertiajs/vue3";
    import TheLoadingSpinner from "./LoadingSpinner.vue";

    const openSearchBox = ref(false)
    const searchResults = ref([])
    const search = ref('')
    const searchInputRef = ref(null)
    const showLoadingSpinner = ref(false)

    watch([search, openSearchBox], ([newValueSearch, newValueOpenSearchBox], oldValue, onCleanup) => {

        newValueOpenSearchBox
            ? document.body.style.overflow = 'hidden'
            : document.body.style.overflow = 'visible'


        if (newValueSearch.length === 0 || !search.value) {
            searchResults.value = []
            showLoadingSpinner.value = false
            return
        }

        showLoadingSpinner.value = true

        const clearSetTimeout = setTimeout(() => {
            axios.get('http://127.0.0.1:8000/search', {
                params: {
                    q: newValueSearch.toLowerCase()
                }
            })
                .then(response => {
                    console.log(response.data)
                    searchResults.value = response.data
                    showLoadingSpinner.value = false
                })
        }, 500)


        onCleanup(() => {
            clearTimeout(clearSetTimeout)
        })
    })

    const keydownEventHandle = event => {
        if (event.ctrlKey && event.key === 'k') {
            event.preventDefault();
            openSearchBox.value = true
            nextTick(() => {
                searchInputRef.value.focus()
            })
        }

        if (event.key === 'Escape') {
            openSearchBox.value = false
        }
    }

    onMounted(() => {
        window.addEventListener('keydown', keydownEventHandle)
    })

    onUnmounted(() => {
        window.removeEventListener('keydown', keydownEventHandle)
    })

</script>

<template>
<div class="w-full max-w-lg lg:max-w-xs">
    <label for="search" class="sr-only">Ara</label>
    <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                 fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                      d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                      clip-rule="evenodd"/>
            </svg>
        </div>
        <input @click="openSearchBox = !openSearchBox"
               id="search"
               name="search"
               class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-3 leading-5 placeholder-gray-500 focus:border-indigo-500 focus:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
               placeholder="Ara"
               type="search">
    </div>
</div>

<div v-if="openSearchBox" class="relative z-10 overflow-hidden" role="dialog" aria-modal="true">

    <!--
      Background backdrop, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
    <Transition name="background-backdrop">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    </Transition>

    <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
        <!--
          Command palette, show/hide based on modal state.

          Entering: "ease-out duration-300"
            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            To: "opacity-100 translate-y-0 sm:scale-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100 translate-y-0 sm:scale-100"
            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        -->
        <Transition name="command-palette">
            <div
                class="mx-auto max-w-xl transform overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
                <div class="relative">
                    <!-- Heroicon name: mini/magnifying-glass -->
                    <svg class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                              clip-rule="evenodd"/>
                    </svg>

                    <input v-model="search"
                           ref="searchInputRef"
                           type="text"
                           class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm"
                           placeholder="Ara..." role="combobox" aria-expanded="false" aria-controls="options">
                </div>

                <!-- Default state, show/hide based on command palette state -->
                <div v-if="search.length < 1" class="border-t border-gray-100 py-14 px-6 text-center text-sm sm:px-14">
                    <!-- Heroicon name: outline/globe-americas -->
                    <svg class="mx-auto h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64"/>
                    </svg>
                    <p class="mt-4 font-semibold text-gray-900">Kanalları ve videoları arayın.</p>
                    <p class="mt-2 text-gray-500">Global bir arama yapıp, kanallara ve videolara hızlı erişin.</p>
                </div>

                <!-- Loading Spinner -->
                <TheLoadingSpinner v-if="showLoadingSpinner" class="mb-10 mt-6" spinner-class="w-7 h-7"/>

                <!-- Results, show/hide based on command palette state -->
                <div v-else-if="searchResults?.videos?.length !== 0 || searchResults?.channels?.length !== 0">
                    <ul class="max-h-80 scroll-pt-11 scroll-pb-2 space-y-2 overflow-y-auto pb-2" id="options"
                        role="listbox">
                        <li v-if="searchResults?.channels">
                            <h2 class="bg-gray-200 py-2.5 px-4 text-sm font-bold text-gray-900">Kanallar</h2>
                            <ul class="mt-2 text-sm text-gray-800">
                                <!-- Active: "bg-indigo-600 text-white" -->
                                <li v-for="channel in searchResults.channels"
                                    class="cursor-pointer select-none px-4 py-2 hover:bg-indigo-500 hover:text-white"
                                    id="option-1" role="option" tabindex="-1">
                                    <Link :href="route('channel.videos',{identifier: channel.id})">
                                        {{ channel.name }}
                                    </Link>
                                </li>
                            </ul>
                        </li>
                        <li v-if="searchResults?.videos">
                            <h2 class="bg-gray-200 py-2.5 px-4 text-sm font-bold text-gray-900">Videolar</h2>
                            <ul class="mt-2 text-sm text-gray-800">
                                <!-- Active: "bg-indigo-600 text-white" -->
                                <li v-for="video in searchResults.videos"
                                    class="cursor-pointer select-none px-4 py-2 hover:bg-indigo-500 hover:text-white"
                                    id="option-3" role="option" tabindex="-1">
                                    <Link :href="route('view',{video: video.id})">
                                        {{ video.title }}
                                    </Link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- Empty state, show/hide based on command palette state -->
                <div v-else-if="searchResults?.videos?.length === 0 && searchResults?.channels?.length === 0"
                     class="border-t border-gray-100 py-14 px-6 text-center text-sm sm:px-14">
                    <!-- Heroicon name: outline/face-frown -->
                    <svg class="mx-auto h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"/>
                    </svg>
                    <p class="mt-4 font-semibold text-gray-900">No results found</p>
                    <p class="mt-2 text-gray-500">We couldn’t find anything with that term. Please try again.</p>
                </div>
            </div>
        </Transition>
    </div>
</div>
</template>

<style scoped>
/**
          Entering: "ease-out duration-300"
            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            To: "opacity-100 translate-y-0 sm:scale-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100 translate-y-0 sm:scale-100"
            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
 */
.background-backdrop-enter-active {
    @apply ease-out duration-300
}

.background-backdrop-enter-from {
    @apply opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95
}

.background-backdrop-enter-to {
    @apply opacity-100 translate-y-0 sm:scale-100
}

.background-backdrop-leave-active {
    @apply ease-in duration-200
}

.background-backdrop-leave-from {
    @apply opacity-100 translate-y-0 sm:scale-100
}

.background-backdrop-leave-to {
    @apply opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95
}


/**
          Entering: "ease-out duration-300"
            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            To: "opacity-100 translate-y-0 sm:scale-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100 translate-y-0 sm:scale-100"
            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
 */
.command-palette-enter-active {
    @apply ease-out duration-300
}

.command-palette-enter-from {
    @apply opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95
}

.command-palette-enter-to {
    @apply opacity-100 translate-y-0 sm:scale-100
}

.command-palette-leave-active {
    @apply ease-in duration-200
}

.command-palette-leave-from {
    @apply opacity-100 translate-y-0 sm:scale-100
}

.command-palette-leave-to {
    @apply opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95
}

</style>
