<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="mb-5">
            <Link href="/">
                <ApplicationLogo class="w-52 fill-current text-gray-500" />
            </Link>
        </div>
        <slot />
    </div>
</template>
