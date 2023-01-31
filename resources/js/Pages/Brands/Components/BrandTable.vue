<script setup>
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Toast from '@/Components/Toast.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SuccessButton from '@/Components/SuccessButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    brands: Array,
});

const form = useForm({
    BrandID: '',
    BrandName: '',
    IsActive: '',
});

const oldForm = useForm({
    BrandName: '',
    IsActive: '',
});

const updater = useForm({
    toastDescription: '',
})

const addModal = ref(false);
const openAddModal = () => {
    addModal.value = true;
}
const closeAddModal = () => {
    addModal.value = false;
    form.reset();
    form.clearErrors()
}

const viewModal = ref(false);
const openViewModal = (BrandID,BrandName,IsActive) => {
    form.BrandID = BrandID;
    oldForm.BrandName = BrandName;
    form.BrandName = BrandName;
    oldForm.IsActive = IsActive;
    form.IsActive = IsActive;
    viewModal.value = true;
}
const closeViewModal = () => {
    viewModal.value = false;
    form.reset();
    form.clearErrors()
}


const addForm = () => {
    form.post(route('brands.store'), {
        preserveScroll: true,
        onSuccess: () => {
            addModal.value = false;
            updater.toastDescription = "New brand name has been added.";
            form.reset();
            form.clearErrors()
        }
    })
}

const updateForm = () => {
    if(form.BrandName == oldForm.BrandName && form.IsActive == oldForm.IsActive) {
        console.log('NO ACTION');
    } else {
        form.patch(route('brands.update', form.BrandID), {
            preserveScroll: true,
            onSuccess: () => {
                viewModal.value = false;
                updater.toastDescription = form.BrandName + " has been updated.";
                form.reset();
                form.clearErrors()
            }
        })
    }
}

const deleteForm = () => {
    form.delete(route('brands.destroy',form.BrandID), {
        preserveScroll: true,
        onSuccess: () => {
            viewModal.value = false;
            updater.toastDescription = form.BrandName + " has been deleted.";
            form.reset();
            form.clearErrors()
        }
    })
}
</script>

<template>
    <section>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            BrandID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            BrandName
                        </th>
                        <th scope="col" class="px-6 py-3">
                            IsActive
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in brands" @click="openViewModal(item.BrandID,item.BrandName,item.IsActive)" class="bg-white border-b border-dashed cursor-default">
                        <td class="px-6 py-4">
                            {{ item.BrandID }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.BrandName }}
                        </td>
                        <td class="px-6 py-4 text-green-500" :class=" {'text-red-500': item.IsActive=='No'}">
                            {{ item.IsActive }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center mt-3">
            <PrimaryButton @click="openAddModal">ADD NEW BRAND</PrimaryButton>
        </div>

        <Toast v-if="form.recentlySuccessful">{{ updater.toastDescription }}</Toast>

        <Modal :show="viewModal" @close="closeViewModal">
            <div class="p-6">
                <h3 class="font-bold">VIEW BRAND</h3>
                <form>
                    <div class="mt-3">
                        <InputLabel for="BrandID" value="Brand ID"/>
                        <TextInput
                            id="BrandID"
                            type="text"
                            v-model="form.BrandID"
                            class="w-full"
                            required
                            readonly
                        />
                        <InputError class="mt-2" :message="form.errors.BrandID" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="BrandName" value="Brand Name"/>
                        <TextInput
                            id="BrandName"
                            type="text"
                            v-model="form.BrandName"
                            class="w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.BrandName" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="IsActive" value="IsActive"/>
                        <select id="IsActive" v-model="form.IsActive" class="w-full border-gray-300 shadow-sm rounded rounded-lg">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.IsActive" />
                    </div>
                    <div class="flex justify-end mt-3 gap-1">
                        <PrimaryButton type="button" @click="updateForm">UPDATE</PrimaryButton>
                        <DangerButton type="button" @click="deleteForm">DELETE</DangerButton>
                    </div>    
                </form>
            </div>
        </Modal>

        <Modal :show="addModal" @close="closeAddModal">
            <div class="p-6">
                <h3 class="font-bold">VIEW BRAND</h3>
                <form>
                    <div class="mt-3">
                        <InputLabel for="BrandName" value="Brand Name"/>
                        <TextInput
                            id="BrandName"
                            type="text"
                            v-model="form.BrandName"
                            class="w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.BrandName" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="IsActive" value="IsActive"/>
                        <select id="IsActive" v-model="form.IsActive" class="w-full border-gray-300 shadow-sm rounded rounded-lg">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.IsActive" />
                    </div>
                    <div class="flex justify-end mt-3 gap-3">
                        <SuccessButton type="button" @click="addForm">ADD</SuccessButton>
                    </div>    
                </form>
            </div>
        </Modal>

    </section>
</template>