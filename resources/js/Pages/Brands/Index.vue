<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,useForm } from '@inertiajs/vue3';
import BrandTable from './Components/BrandTable.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    brands: Array,
    newBrandID: Number,
});

const form = useForm({
    search: '',
});

const searchBrand = () => {
    form.get(route('brands.index'));
}
</script>

<template>
    <Head title="BRANDS" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mt-6 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-3 text-gray-900 font-bold text-4xl">BRANDS</div>
                </div>

                <form @submit.prevent="searchBrand">
                    <TextInput 
                        id="search"
                        type="text"
                        class="mt-3 block w-full"
                        v-model="form.search"
                        placeholder="Search"
                    />
                </form>

                <BrandTable
                    class="mt-3"
                    :brands="brands"
                    :newBrandID="newBrandID"
                />
            </div>        
        </div>
    </AuthenticatedLayout>
</template>
