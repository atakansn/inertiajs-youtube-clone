<script setup>
    import ChannelDashboard from "@/Layouts/ChannelDashboard.vue";
    import {Link, router} from "@inertiajs/vue3";
    import {computed, ref, watch} from "vue";
    import Modal from "@Components/Modal.vue";
    import Notification from "@Components/Notification.vue";
    import Badge from "@Components/Badge.vue";
    import {useFormattedDuration} from "@Composables/useFormattedDuration.js";
    import {useDynamicRouteParams} from "@Composables/useDynamicRouteParams.js";

    const {routeParam} = useDynamicRouteParams()

    const props = defineProps({
        videos: {},
        filters: {}
    })

    const videos = ref(props.videos)
    const selectedItems = ref([])
    const showModal = ref(false)
    const showNotification = ref(false)
    const search = ref(props.filters.search)
    const selectAll = ref(false)

    const isEmpty = computed(() => (Array.isArray(videos.value.data) && videos.value.data.length === 0))
    const checkNextPageUrl = computed(() => videos.value.next_page_url === null)
    const checkPrevPageUrl = computed(() => videos.value.prev_page_url === null)

    watch(search, (newValue) => {
        router.get(route('channel-dashboard.videos.index', {channel: routeParam.value}), {search: newValue}, {
            preserveState: true,
            replace: true
        })
    })

    const deleteSelectedVideos = () => {
        if (selectedItems.value.length === 0) {
            alert('Lütfen seçim yapınız.')
            return
        }

        showModal.value = true
    }

    const deleteVideos = () => {
        router.delete(route('channel-dashboard.videos.destroy', {channel: routeParam.value}), {
            onSuccess: () => {
                showModal.value = false
                selectedItems.value = []
                showNotification.value = true
            },
            onFinish: () => {
                setTimeout(() => showNotification.value = false, 3000)
            },
            data: {
                ids: selectedItems.value
            },

        })
    }

    const isSelected = value => {
        return selectedItems.value.includes(value)
    }

    const toggleSelectAll = () => {
        selectedItems.value = []

        if (!selectAll.value) {
            for (let video in props.videos.data) {
                selectedItems.value.push(props.videos.data[video].id)
            }
        }
    }

    const closeModal = () => {
        showModal.value = false
    }

    const closeNotification = () => {
        showNotification.value = false
    }

    const videoPublished = async (id, isPublished) => {
        router.patch(
            route('channel-dashboard.video.published', {video: id}),
            {
                is_published: isPublished
            }
        )
    }

</script>

<template>
<ChannelDashboard class="bg-none px-0 py-0" head-title="Kanal Videoları">
    <template #pageHeading>
        Videolar
    </template>
    <div>
        <div class="sm:flex sm:items-center">
            <!-- Search Input --->
            <div class="sm:flex-auto">
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>

                    <input :disabled="videos.data.length < 5"
                           :class="{'disabled: opacity-60': videos.data.length < 5 }"
                           v-model="search"
                           id="search"
                           name="search"
                           class="block w-80 rounded-md border border-gray-300 bg-white py-2 pl-10 pr-3 leading-5 placeholder-gray-500 focus:border-indigo-500 focus:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                           placeholder="Ara"
                           type="search">
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <nav class="flex items-center justify-between py-3" aria-label="Pagination">
                    <div class="flex flex-1 justify-between sm:justify-end">
                        <Link :href="props.videos.prev_page_url ?? ''"
                              as="button"
                              :disabled="checkPrevPageUrl"
                              :class="{'disabled:opacity-60': checkPrevPageUrl, 'hover:bg-gray-50': !checkNextPageUrl}"
                              class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700">
                            Geri
                        </Link>
                        <Link :href="props.videos.next_page_url ?? ''"
                              as="button"
                              :disabled="checkNextPageUrl"
                              :class="{'disabled:opacity-60': checkNextPageUrl, 'hover:bg-gray-50': !checkNextPageUrl}"
                              class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700">
                            İleri
                        </Link>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Table --->
        <div class="flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <!-- Delete Button Selected row actions, only show when rows are selected.-->
                        <div v-if="selectedItems.length >= 1"
                             class="absolute top-0 left-12 flex h-12 items-center space-x-3 bg-gray-50 sm:left-16">
                            <button @click.prevent="deleteSelectedVideos"
                                    :disabled="isEmpty"
                                    :class="{'disabled: opacity-70': isEmpty}"
                                    type="button"
                                    class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30">
                                Sil ({{ selectedItems.length }})
                            </button>
                        </div>

                        <table class="min-w-full table-fixed divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                                    <!-- Select all checkbox -->
                                    <input @click="toggleSelectAll"
                                           v-model="selectAll"
                                           :disabled="isEmpty"
                                           :class="{'disabled: opacity-60': isEmpty}"
                                           type="checkbox"
                                           class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6">
                                </th>
                                <th scope="col"
                                    class="min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">
                                    Başlık
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Görüntülenme
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Süre
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Yüzde
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Durum
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Yüklenme Tarihi
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Yayınlanma Durumu
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Düzenle</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            <!-- Selected: "bg-gray-50" -->
                            <tr v-for="(video,index) in props.videos.data"
                                :key="index"
                                :class="{'bg-gray-100': isSelected(video.id)}">
                                <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                                    <!-- Selected row marker, only show when row is selected. -->
                                    <div v-if="isSelected(video.id)"
                                         class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"></div>
                                    <input v-model="selectedItems" :value="video.id"
                                           :id="index" type="checkbox"
                                           class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6">
                                </td>
                                <!-- Selected: "text-indigo-600", Not Selected: "text-gray-900" -->
                                <td class="whitespace-nowrap py-4 pr-3 text-sm font-medium text-gray-900">
                                    {{ video.title }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ video.view_count }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{useFormattedDuration(video.duration)}}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <Badge :success="video.processing_percentage === 100" :danger="video.processing_percentage !== 100">
                                        <template #text>
                                            %{{ video.processing_percentage }}
                                        </template>
                                    </Badge>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <Badge :success="video.is_published === 1"
                                           :information="video.is_published === 0">
                                        <template v-if="video.is_published === 1" #text>
                                            Yayında
                                        </template>

                                        <template v-else #text>
                                            Yayında Değil
                                        </template>
                                    </Badge>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                    {{ video.video_created_at }}
                                </td>
                                <td class="whitespace-nowrap py-4 pr-12 text-center text-sm font-medium sm:pr-12">
                                    <button v-if="video.is_published === 0"
                                            @click.prevent="videoPublished(video.id, true)"
                                            type="button"
                                            class="text-indigo-600 hover:text-indigo-900">
                                        Yayınla
                                    </button>

                                    <button v-else
                                            @click.prevent="videoPublished(video.id, false)"
                                            type="button"
                                            class="text-red-600 hover:text-indigo-900">
                                        Geri Al
                                    </button>

                                </td>
                                <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <Link :href="route('channel-dashboard.videos.edit',{video: video.id})"
                                          class="text-indigo-600 hover:text-indigo-900">
                                        Düzenle
                                    </Link>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <Modal :data="selectedItems.length" v-if="showModal" @close="closeModal" @action="deleteVideos">
        <template #title>
            Siliniyor ?
        </template>
        <template #content>
            Seçtiğiniz videoları/videoyu silmek istiyor musunuz ?
        </template>
    </Modal>

    <!-- Notification -->
    <Notification v-if="showNotification" @close="closeNotification">
        <template #title>
            Başarılı
        </template>
        <template #text>
            Videolar/Video silindi.
        </template>
    </Notification>

</ChannelDashboard>
</template>

<style scoped>

</style>
