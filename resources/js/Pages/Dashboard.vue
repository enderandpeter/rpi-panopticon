<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Alarm from "@/Pages/Alarm.vue";
import { Head } from '@inertiajs/vue3';

window.Echo.private();

defineProps({
    'alarms': {
        type: Array
    }
})

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div id="alarms-div" v-for="alarm in alarms" class="p-6 text-gray-900 dark:text-gray-100">
                        <alarm :alarm="alarm" />
                    </div>
                    <div id="alarms-div" v-if="alarms.length === 0">
                        <h3>No alarms found</h3>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
