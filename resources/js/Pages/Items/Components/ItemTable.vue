<script setup>
import Toast from '@/Components/Toast.vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import {ref} from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SuccessButton from '@/Components/SuccessButton.vue';
import DangerButton from '@/Components/DangerButton.vue';


const props = defineProps({
    items: Array,
    brands: Array,
    newItemID: Number,
});

const form = useForm({
    ItemID: '',
    ItemName: '',
    ItemPrice: '',
    ItemUOM: '',
    BrandID: '',
    MinStock: '',
    ReorderQty: '',
    IsActive: '',
});

const oldForm = useForm({
    ItemName: '',
    ItemPrice: '',
    ItemUOM: '',
    BrandID: '',
    MinStock: '',
    ReorderQty: '',
    IsActive: '',
});

const updater = useForm({
    toastDescription: '',
});

const addModal = ref(false);
const openAddModal = () => {
    addModal.value = true;
}
const closeAddModal = () => {
    addModal.value = false;
    form.reset();
    form.clearErrors();
}

const viewModal = ref(false);
const openViewModal = (ItemID,ItemName,ItemPrice,ItemUOM,BrandID,MinStock,ReorderQty,IsActive) => {
    form.ItemID = ItemID;
    form.ItemName = ItemName;
    form.ItemPrice = ItemPrice;
    form.ItemUOM = ItemUOM;
    form.BrandID = BrandID;
    form.MinStock = MinStock;
    form.ReorderQty = ReorderQty;
    form.IsActive = IsActive;

    oldForm.ItemName = ItemName;
    oldForm.ItemPrice = ItemPrice;
    oldForm.ItemUOM = ItemUOM;
    oldForm.BrandID = BrandID;
    oldForm.MinStock = MinStock;
    oldForm.ReorderQty = ReorderQty;
    oldForm.IsActive = IsActive;
    viewModal.value = true;
}
const closeViewModal = () => {
    viewModal.value = false;
    form.reset();
    form.clearErrors();
}

const addForm = () => {
    form.post(route('items.store'), {
        preserveScroll:true,
        onSuccess: () => {
            addModal.value = false;
            updater.toastDescription = "New inventory item has been added.";
            form.reset();
            form.clearErrors();
        }
    })
}

const updateForm = () => {

    if(form.ItemName == oldForm.ItemName && form.ItemPrice == oldForm.ItemPrice && form.ItemUOM == oldForm.ItemUOM && form.BrandID == oldForm.BrandID && form.MinStock == oldForm.MinStock && form.ReorderQty == oldForm.ReorderQty && form.IsActive == oldForm.IsActive) {
        console.log('NO ACTION');
    } else {
        form.patch(route('items.update', form.ItemID), {
            preserveScroll:true,
            onSuccess: () => {
                viewModal.value = false;
                updater.toastDescription = form.ItemName + " has been updated.";
                form.reset();
                form.clearErrors();
            }
        })
    }

}

const deleteForm = () => {
    form.delete(route('items.destroy',form.ItemID), {
        preserveScroll: true,
        onSuccess: () => {
            viewModal.value = false;
            updater.toastDescription = form.ItemName + " has been deleted.";
            form.reset();
            form.clearErrors();
        }
    });
}

</script>

<template>
    <section>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ItemID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ItemName
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ItemPrice
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ItemUOM
                        </th>
                        <th scope="col" class="px-6 py-3">
                            BrandID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            MinStock
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ReorderQty
                        </th>
                        <th scope="col" class="px-6 py-3">
                            IsActive
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" @click="openViewModal(item.ItemID,item.ItemName,item.ItemPrice,item.ItemUOM,item.BrandID,item.MinStock,item.ReorderQty,item.IsActive)" class="bg-white border-b border-dashed cursor-default">
                        <td class="px-6 py-4">
                            {{ item.ItemID }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.ItemName }}
                         </td>
                        <td class="px-6 py-4">
                            {{ item.ItemPrice }}
                         </td>
                        <td class="px-6 py-4">
                            {{ item.ItemUOM }}
                         </td>
                        <td class="px-6 py-4">
                            {{ item.BrandID }}
                         </td>
                        <td class="px-6 py-4">
                            {{ item.MinStock }}
                         </td>
                        <td class="px-6 py-4">
                            {{ item.ReorderQty }}
                        </td>
                        <td class="px-6 py-4 text-green-500" :class="{'text-red-500': item.IsActive=='No'}">
                            {{ item.IsActive }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center mt-3">
            <PrimaryButton @click="openAddModal">ADD NEW ITEM</PrimaryButton>
        </div>

        <Toast v-if="form.recentlySuccessful">{{ updater.toastDescription }}</Toast>

        <Modal :show="addModal" @close="closeAddModal">
            <div class="p-6">
                <h3 class="font-bold">ADD ITEM</h3>
                <form>
                    <div class="mt-3">
                        <InputLabel for="ItemID" value="Item ID"/>
                        <TextInput
                            id="ItemID"
                            type="number"
                            v-model="props.newItemID"
                            class="w-full"
                            required
                            readonly
                        />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="ItemName" value="Item Name"/>
                        <TextInput
                            id="ItemName"
                            type="text"
                            v-model="form.ItemName"
                            class="w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.ItemName" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="BrandID" value="Brand Name"/>
                        <select id="BrandID" v-model="form.BrandID" class="w-full border-gray-300 shadow-sm rounded rounded-lg">
                            <option v-for="brand in brands" :value="brand.BrandID">{{ brand.BrandName }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.BrandID" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="ItemPrice" value="Item Price"/>
                        <TextInput
                            id="ItemPrice"
                            type="number"
                            v-model="form.ItemPrice"
                            class="w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.ItemPrice" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="ItemUOM" value="Item UOM"/>
                        <select id="ItemUOM" v-model="form.ItemUOM" class="w-full border-gray-300 shadow-sm rounded rounded-lg">
                            <option value="Pc">Pc</option>
                            <option value="Pack/2s">Pack/2s</option>
                            <option value="Pack/24s">Pack/24s</option>
                            <option value="Box/10s">Box/10s</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.ItemUOM" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="MinStock" value="Minimum Stock"/>
                        <TextInput
                            id="MinStock"
                            type="number"
                            v-model="form.MinStock"
                            class="w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.MinStock" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="ReorderQty" value="Reorder Quantity"/>
                        <TextInput
                            id="ReorderQty"
                            type="number"
                            v-model="form.ReorderQty"
                            class="w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.ReorderQty" />
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

        <Modal :show="viewModal" @close="closeViewModal">
            <div class="p-6">
                <h3 class="font-bold">VIEW ITEM</h3>
                <form>
                    <div class="mt-3">
                        <InputLabel for="ItemID" value="Item ID"/>
                        <TextInput
                            id="ItemID"
                            type="text"
                            v-model="form.ItemID"
                            class="w-full"
                            required
                            readonly
                        />
                        <InputError class="mt-2" :message="form.errors.ItemID" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="ItemName" value="Item Name"/>
                        <TextInput
                            id="ItemName"
                            type="text"
                            v-model="form.ItemName"
                            class="w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.ItemName" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="BrandID" value="Brand Name"/>
                        <select id="BrandID" v-model="form.BrandID" class="w-full border-gray-300 shadow-sm rounded rounded-lg">
                            <option v-for="brand in brands" :value="brand.BrandID">{{ brand.BrandName }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.BrandID" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="ItemPrice" value="Item Price"/>
                        <TextInput
                            id="ItemPrice"
                            type="number"
                            v-model="form.ItemPrice"
                            class="w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.ItemPrice" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="ItemUOM" value="Item UOM"/>
                        <select id="ItemUOM" v-model="form.ItemUOM" class="w-full border-gray-300 shadow-sm rounded rounded-lg">
                            <option value="Pc">Pc</option>
                            <option value="Pack/2s">Pack/2s</option>
                            <option value="Pack/24s">Pack/24s</option>
                            <option value="Box/10s">Box/10s</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.ItemUOM" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="MinStock" value="Minimum Stock"/>
                        <TextInput
                            id="MinStock"
                            type="number"
                            v-model="form.MinStock"
                            class="w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.MinStock" />
                    </div>
                    <div class="mt-3">
                        <InputLabel for="ReorderQty" value="Reorder Quantity"/>
                        <TextInput
                            id="ReorderQty"
                            type="number"
                            v-model="form.ReorderQty"
                            class="w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.ReorderQty" />
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
                        <WarningButton type="button" @click="updateForm">UPDATE</WarningButton>
                        <DangerButton type="button" @click="deleteForm">DELETE</DangerButton>
                    </div>    
                </form>
            </div>
        </Modal>

    </section>
</template>