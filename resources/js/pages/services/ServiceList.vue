<template>
    <div class="space-y-4">
        <h2 class="text-xl font-bold">Service Management</h2>

        <div class="flex justify-between items-center">
            <router-link to="/services/create">
                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                    Add Service
                </button>
            </router-link>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Customer Name</th>
                    <th class="border px-4 py-2">Phone</th>
                    <th class="border px-4 py-2">Chassis Number</th>
                    <th class="border px-4 py-2">Service Charge</th>
                    <th class="border px-4 py-2">Parts Price</th>
                    <th class="border px-4 py-2">Total Amount</th>
                    <th class="border px-4 py-2">Start Time</th>
                    <th class="border px-4 py-2">End Time</th>
                    <th class="border px-4 py-2">Actual Time</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="s in services" :key="s.id">
                    <td class="border px-4 py-2">{{ s.customer_name }}</td>
                    <td class="border px-4 py-2">{{ s.phone }}</td>
                    <td class="border px-4 py-2">{{ s.chassis_number }}</td>
                    <td class="border px-4 py-2">{{ s.service_charge }}</td>
                    <td class="border px-4 py-2"></td>
                    <td class="border px-4 py-2"></td>
                    <td class="border px-4 py-2">{{ s.start_time }}</td>
                    <td class="border px-4 py-2">{{ s.end_time }}</td>
                    <td class="border px-4 py-2">{{ s.actual_time }}</td>
                    <td class="border px-4 py-2">
                        <button @click="serviceAction(s)" class="text-red-600 hover:underline">Action</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Confirm Modal -->
        <div v-if="showConfirm" class="fixed inset-0 bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg w-96 space-y-4">
                <h3 class="text-lg font-semibold">Update Service</h3>
                <p>You are about to update <strong>{{ serviceToUpdate?.customer_name }}</strong>.</p>
                <div class="flex justify-end gap-2">
                    <button @click="showConfirm = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button @click="confirmUpdate" class="px-4 py-2 bg-red-600 text-white rounded">Update</button>
                </div>
            </div>
        </div>

        <h2 class="text-xl font-bold">Discount Table</h2>

        <table class="table-auto w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Product Code</th>
                    <th class="border px-4 py-2">Retail Price</th>
                    <th class="border px-4 py-2">Discount Amount</th>
                    <th class="border px-4 py-2">Discount Percentage</th>
                    <th class="border px-4 py-2">Final Price</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="p in parts.parts" :key="p.id">
                    <td class="border px-4 py-2">{{ p.code }}</td>
                    <td class="border px-4 py-2">{{ p.retail_price }}</td>
                    <td class="border px-4 py-2">{{ p.discount_amount }}</td>
                    <td class="border px-4 py-2">{{ p.discount_percentage }}</td>
                    <td class="border px-4 py-2">{{ p.final_price }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import axios from 'axios'
import { onMounted, ref } from 'vue'

const services = ref({
    data: [],
})

const parts = ref({
    data: [],
})

const showConfirm = ref(false)
const serviceToUpdate = ref(null)

const fetchServices = async () => {
    const res = await axios.get('/api/services')
    services.value = res.data
}

const serviceAction = (service) => {
    serviceToUpdate.value = service
    showConfirm.value = true
}

const confirmUpdate = async () => {
    if (serviceToUpdate.value) {
        await axios.put(`/api/services/${serviceToUpdate.value.id}`, serviceToUpdate.value)
        showConfirm.value = false
        serviceToUpdate.value = null
        fetchServices();
    }
}

const totalAmount = (service) => {
    return service.service_charge + partsPrice(service);
}

const partsPrice = (service) => {
    const part = parts.value.find(p => p.id === service.part_id);
    return part ? part.final_price : 0;
}

const fetchParts = async () => {
    const res = await axios.get('/api/parts')
    parts.value = res.data
}

onMounted(() => {
    fetchServices();
    fetchParts();
});
</script>
