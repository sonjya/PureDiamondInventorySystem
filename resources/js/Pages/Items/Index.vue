<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,useForm } from '@inertiajs/vue3';
import ItemTable from './Components/ItemTable.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    items: Array,
    brands: Array,
    newItemID: Number,
});

const form = useForm({
    search: '',
});

const searchItem = () => {
    form.get(route('items.index'));
}

</script>

<template>
    <Head title="DASHBOARD" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mt-6 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-3 text-gray-900 font-bold text-4xl">ITEMS</div>
                </div>
                <form @submit.prevent="searchItem">
                    <TextInput
                        id="search"
                        type="text"
                        class="mt-3 block w-full"
                        v-model="form.search"
                        placeholder="Search"
                    />
                    
                </form>
                <ItemTable
                    class="mt-3"
                    :items="items"
                    :brands="brands"
                    :newItemID="newItemID"
                />
            </div>
        </div>
    </AuthenticatedLayout>
    
</template>
