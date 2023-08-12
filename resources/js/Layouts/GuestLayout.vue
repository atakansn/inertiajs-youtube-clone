<script setup>
import Logo from '../Components/Logo.vue'
</script>

<template>
<div class="flex min-h-[900px] flex-col">
    <div class="flex min-h-full flex-col flex-1 justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md flex justify-center">
            <slot name="logo">
                <Logo class="h-28 w-28" />
            </slot>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <slot name="content"/>
            </div>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
