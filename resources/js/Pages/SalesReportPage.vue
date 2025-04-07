<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const salesReports = ref([])
const loading = ref(true)

const fetchReports = async () => {
  try {
    const response = await axios.get('/sales-reports')
    salesReports.value = response.data
  } catch (error) {
    console.error('Error fetching reports', error)
  } finally {
    loading.value = false
  }
}

onMounted(fetchReports)
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">📊 Sales Report</h1>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <table class="w-full text-left border">
        <thead>
          <tr class="bg-gray-200">
            <th class="p-2 border">Date</th>
            <th class="p-2 border">Total Sales</th>
            <th class="p-2 border">Transactions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="report in salesReports" :key="report.date">
            <td class="p-2 border">{{ report.date }}</td>
            <td class="p-2 border">{{ report.total_sales }}</td>
            <td class="p-2 border">{{ report.transactions }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
