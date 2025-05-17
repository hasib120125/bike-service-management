<template>
    <div class="space-y-4">
        <h2 class="text-xl font-bold">{{ isEdit ? 'Edit Service' : 'Add Service' }}</h2>

        <form @submit.prevent="saveService" class="space-y-2">
            <div>
                <input v-model="form.customer_name" class="border p-2 rounded block w-full"
                    placeholder="Customer Name" />
                <p v-if="errors.customer_name" class="text-red-600 text-sm">{{ errors.customer_name[0] }}</p>
            </div>

            <div>
                <input v-model="form.phone" class="border p-2 rounded block w-full" placeholder="Phone" />
                <p v-if="errors.phone" class="text-red-600 text-sm">{{ errors.phone[0] }}</p>
            </div>

            <div>
                <input v-model="form.chassis_number" class="border p-2 rounded block w-full"
                    placeholder="Chassis Number" />
                <p v-if="errors.chassis_number" class="text-red-600 text-sm">{{ errors.chassis_number[0] }}</p>
            </div>

            <div>
                <input type="number" v-model="form.km_run" class="border p-2 rounded block w-full"
                    placeholder="Km Run" />
                <p v-if="errors.km_run" class="text-red-600 text-sm">{{ errors.km_run[0] }}</p>
            </div>

            <div>
                <input v-model="form.bay_number" class="border p-2 rounded block w-full" placeholder="Bay Number" />
                <p v-if="errors.bay_number" class="text-red-600 text-sm">{{ errors.bay_number[0] }}</p>
            </div>

            <div>
                <input v-model="form.service_charge" class="border p-2 rounded block w-full"
                    placeholder="Service Charge" />
                <p v-if="errors.service_charge" class="text-red-600 text-sm">{{ errors.service_charge[0] }}</p>
            </div>

            <div>
                <select v-model="form.service_type" class="border p-2 rounded block w-full">
                    <option value="" disabled>Select Service Type</option>
                    <option value="free">Free</option>
                    <option value="paid">Paid</option>
                </select>
            </div>

            <div>
                <input type="datetime-local" v-model="form.service_time" class="border p-2 rounded block w-full"
                    placeholder="Service Time" />
                <p v-if="errors.service_time" class="text-red-600 text-sm">{{ errors.service_time[0] }}</p>
            </div>

            <div>
                <input type="file" @change="event => form.image = event.target.files[0]"
                    class="border p-2 rounded block w-full" accept="image/*" />
                <p v-if="errors.image" class="text-red-600 text-sm">{{ errors.image[0] }}</p>
            </div>

            <div>
                <label class="block mb-1 font-medium">Select Parts</label>
                <select v-model="form.parts" multiple class="border p-2 rounded block w-full">
                    <option v-for="part in partsList" :key="part.id" :value="part.id">
                        {{ part.code }} - {{ part.retail_price }}
                    </option>
                </select>
                <p v-if="errors.parts" class="text-red-600 text-sm">{{ errors.parts[0] }}</p>
            </div>

            <div class="flex gap-2">
                <button class="bg-green-500 text-white px-4 py-2 rounded" type="submit">
                    {{ isEdit ? 'Update' : 'Add' }}
                </button>
                <button @click.prevent="cancel" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import axios from 'axios'
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const form = ref(
    {
        customer_name: '',
        phone: '',
        chassis_number: '',
        km_run: '',
        bay_number: '',
        service_charge: '',
        service_type: '',
        service_time: '',
        image: null,
        id: null,
        parts: [],
    }
)
const errors = ref({})
const isEdit = ref(false)
const partsList = ref([])

const route = useRoute()
const router = useRouter()

onMounted(async () => {
    // Fetch parts for the dropdown
    const resParts = await axios.get('/api/parts')
    partsList.value = resParts.data.parts || resParts.data

    if (route.params.id) {
        isEdit.value = true
        const res = await axios.get(`/api/services/${route.params.id}`)
        form.value = res.data
        // Ensure parts is always an array of IDs
        if (res.data.parts && Array.isArray(res.data.parts)) {
            form.value.parts = res.data.parts.map(p => p.id)
        }
    }
})

const saveService = async () => {
    errors.value = {} // clear previous errors
    try {
        const formData = new FormData();
        for (const key in form.value) {
            if (key === 'parts') {
                form.value.parts.forEach(partId => {
                    formData.append('parts[]', partId);
                });
            } else if (key === 'image' && form.value.image) {
                formData.append('image', form.value.image);
            } else if (form.value[key] !== null && form.value[key] !== undefined) {
                formData.append(key, form.value[key]);
            }
        }
        if (isEdit.value) {
            await axios.post(`/api/services/${form.value.id}?_method=PUT`, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
        } else {
            await axios.post('/api/services', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
        }
        router.push('/services')
    } catch (err) {
        if (err.response && err.response.status === 422) {
            errors.value = err.response.data.errors
        }
    }
}

const cancel = () => {
    router.push('/services')
}
</script>
