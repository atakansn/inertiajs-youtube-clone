<script setup>
    import {Head} from "@inertiajs/vue3"
    
    defineProps({
        headTitle: String
    })
</script>

<template>
<Head>
    <title>{{headTitle}}</title>
</Head>

<div class="flex min-h-[900px] flex-col">
    <div class="flex min-h-full flex-col flex-1 justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <slot class="mx-auto" name="logo"/>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <slot />

                <slot name="underside"/>
            </div>
        </div>

        <slot name="outOfTheCard"/>
    </div>
</div>
</template>

<style scoped>

</style>
