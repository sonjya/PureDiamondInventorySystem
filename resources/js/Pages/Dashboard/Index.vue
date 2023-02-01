<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Overview from './Components/Overview.vue';

defineProps({ 
    totalBrands: Number,
    totalItems: Number,
}); 

</script>

<template>
    <Head title="DASHBOARD" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mt-6 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-3 text-gray-900 font-bold text-4xl">DASHBOARD</div>
                </div>
        
                <Overview 
                    class="mt-3 cursor-default"
                    :totalBrands="totalBrands"
                    :totalItems="totalItems"
                />
            </div>
        </div>
    </AuthenticatedLayout>
    
</template>
