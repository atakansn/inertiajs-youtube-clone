<script setup>
    import {ref, defineProps, reactive, toRefs} from "vue";

    const props = defineProps({
        success: {
            type: Boolean
        },
        danger: {
            type: Boolean
        },
        information: {
            type: Boolean
        },
        warning: {
            type: Boolean
        }
    })

    const propsToRef = toRefs(props)

    const bgColorClasses = reactive({
        'bg-green-100': propsToRef.success,
        'bg-red-100': propsToRef.danger,
        'bg-blue-100': propsToRef.information,
        'bg-yellow-100': propsToRef.warning
    })

    const textColorClasses = reactive({
        'text-green-800': propsToRef.success,
        'text-red-700': propsToRef.danger,
        'text-blue-700': propsToRef.information,
        'text-yellow-700': propsToRef.warning,
    })

</script>

<template>
<div :class="bgColorClasses" class="rounded-md p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <!-- Heroicon name: mini/information-circle -->
            <svg v-show="information" class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
            </svg>

            <!-- Heroicon name: mini/check-circle -->
            <svg v-show="success" class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>

            <!-- Heroicon name: mini/x-circle -->
            <svg v-show="danger" class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
            </svg>

            <!-- Heroicon name: mini/exclamation-triangle -->
            <svg v-show="warning" class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3 flex-1 md:flex md:justify-between">
            <div class="text-sm font-normal" :class="textColorClasses">
                <slot name="message" />
                <ul role="list" class="mt-2 list-disc space-y-1 pl-5 text-gray-800 font-medium">
                    <slot name="list" />
                </ul>
            </div>
<!--            <p class="mt-3 text-sm md:mt-0 md:ml-6">-->
<!--                <a href="#" class="whitespace-nowrap font-medium text-blue-700 hover:text-blue-600">-->
<!--                    Details-->
<!--                    <span aria-hidden="true"> &rarr;</span>-->
<!--                </a>-->
<!--            </p>-->
        </div>
    </div>
</div>

</template>

<style scoped>

</style>
