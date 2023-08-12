<script setup>
    import {Link} from "@inertiajs/vue3";

    const props = defineProps({
        title: {
            type: String,
            required: false,
        },
        description: {
            type: String,
            required: false,
        },
        link: {
            text: {
                type: String,
                required: false,
            },
            href: {
                type: String,
                required: false,
            }
        },
    })

</script>

<template>
<div class="py-24 px-6 sm:px-6 sm:py-32 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
        <h2 class="text-4xl font-bold tracking-tight text-gray-900">
            {{ title }}
        </h2>
        <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">
            {{ description }}
        </p>
        <div class="mt-10 flex items-center justify-center gap-x-6">
            <slot name="link">
                <Link :href="link?.href" class="text-base font-semibold leading-7 text-gray-900">
                    {{ link?.text }} <span aria-hidden="true">&rarr;</span>
                </Link>
            </slot>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
