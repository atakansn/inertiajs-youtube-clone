<script setup>
    import Navbar from "../Components/Navbar.vue";
    import {Head} from "@inertiajs/vue3";
    const props = defineProps({
        headerText: String,
        showHeader: Boolean,
        classes: String,
        class: {
            type: String,
            default: () => 'px-5 py-6 sm:px-7'
        },
        headTitle: String
    })

</script>

<template>
<Head>
    <title>{{headTitle}}</title>
</Head>

<div class="min-h-full">
    <Navbar :show-header="props.showHeader" :header-text="props.headerText"/>

    <div class="py-6">
        <header class="mx-auto max-w-screen-2xl" v-if="props.showHeader">
            <div class="mx-auto max-w-full px-5 sm:px-6 lg:px-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900">{{props.headerText}}</h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-screen-2xl py-6 sm:px-6 lg:px-9">
                <!-- Replace with your content -->
                <div class="rounded-lg bg-white shadow-md" :class="props.class">
                    <slot/>
                </div>
                <!-- /End replace -->
            </div>
        </main>
    </div>
</div>
</template>
