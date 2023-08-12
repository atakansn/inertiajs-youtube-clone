<script setup>
    import {Link} from "@inertiajs/vue3";

    defineProps({
        identifier: {
            type: Object,
            required: true
        }
    })
</script>

<template>
<div class="mt-5">
    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Seçim</label>
        <select id="tabs" name="tabs"
                class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option :selected="route().current('channel.videos')">Videolar</option>
            <option :selected="route().current('channel.about')">Hakkında</option>
        </select>
    </div>
    <div class="hidden sm:block">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex" aria-label="Tabs">
                <Link
                    :class="{'border-gray-500 text-gray-600 font-bold' : route().current('channel.videos')}"
                    :href="`/@${identifier.identifier}/videos`"
                    class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 text-md">
                    Videolar
                </Link>

                <Link
                    :class="{'border-gray-500 text-gray-600 font-bold' : route().current('channel.about')}"
                    :href="`/@${identifier.identifier}/about`"
                    class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 text-md">
                    Hakkında
                </Link>
            </nav>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
