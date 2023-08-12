<script setup>
    import {Link} from "@inertiajs/vue3";
    import {onMounted, ref} from "vue";
    import TheNoContent from "./NoContent.vue";
    import {useFormattedDuration} from "@Composables/useFormattedDuration.js";

    const props = defineProps({
        video: {},
        nextPageUrl:{},
        currentPage:{},
        showPhoto: {
            type: Boolean
        },
        showChannelName: {
            type: Boolean
        },
        infoClass: {
            type: String,
            default: 'ml-3'
        }
    })

    const image = ref([])

    onMounted(() => {

        const intersectionObserver = new IntersectionObserver((entries, intersectionObserver) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting){
                    return
                }

                const img = entry.target

                img.src = img.dataset.src
                img.onload = () => {
                    img.previousElementSibling?.remove()
                }
                intersectionObserver.unobserve(img)
            })
        })


        image.value.forEach(img => {
            intersectionObserver.observe(img)
        })

    })

</script>

<template>
<div class="flex flex-col overflow-hidden">
    <!-- Video Image -->
    <div ref="scroll" class="flex-shrink-0 relative">
        <Link :href="route('view',{v: video.id})">
            <img :ref="el => image.push(el)"
                 class="h-48 w-96 object-cover rounded-md"
                 :data-src="video.video_thumbnail"
                 alt="">
            <span class="absolute text-xs p-1 bg-gray-900 rounded bg-opacity-80 font-medium text-white bottom-2 right-2">
                {{useFormattedDuration(video.duration)}}
            </span>
        </Link>
    </div>
    <div class="col-span-12 sm:col-span-6 md:col-span-3 mt-2">
        <div class="w-full flex flex-col">
            <div class="flex flex-row mt-2 gap-2">
                <!-- Channel Picture -->
                <div v-show="showPhoto">
                    <Link :href="`/@${video.channel.identifier}`">
                        <span class="sr-only">{{ video.channel.name }}</span>
                        <img class="h-10 w-10 rounded-full"
                             :src="video.channel.channel_photo_url"
                             alt="">
                    </Link>
                </div>

                <!-- Info -->
                <div :class="infoClass" class="flex flex-col ms-1.5">
                    <a href="#">
                        <p class="text-black text-md font-semibold">{{video.title}}</p>
                    </a>
                    <div class="mt-1">
                        <p v-if="showChannelName" class="text-sm font-medium text-gray-700 hover:text-gray-900">
                            <Link :href="`@${video.channel.identifier}/videos`" class="hover:underline">
                                {{ video.channel.name }}
                            </Link>
                        </p>
                        <div class="flex space-x-1 text-sm text-gray-700 hover:text-gray-900">
                            <span>{{ video.view_count }} Görüntülenme</span>
                            <span aria-hidden="true">·</span>
                            <time datetime="2020-03-16">{{ video.video_created_at }}</time>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</template>

<style scoped>

</style>
