<script setup>
defineProps({ 
    totalBrands: Number,
    totalItems: Number,
}); 
</script>

<template>
    <section>
        <div class="grid grid-cols-3">
            <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">BRANDS</h5>
                <p class="font-normal text-gray-700 text-9xl text-center"> {{ totalBrands }}</p>
            </div>
            <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">ITEMS</h5>
                <p class="font-normal text-gray-700 text-9xl text-center"> {{ totalItems }}</p>
            </div>
        </div>
    </section>
</template>