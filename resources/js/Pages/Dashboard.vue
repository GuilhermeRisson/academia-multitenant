<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { Chart, registerables } from 'chart.js';
import { debounce } from 'lodash'; // Use lodash for debouncing

Chart.register(...registerables);

const props = defineProps({
  stats: {
    type: Object,
    required: true,
  },
  companies: {
    type: Array,
    required: true,
  },
  filters: {
    type: Object,
    default: () => ({ search: '' }),
  },
});

const searchQuery = ref(props.filters.search || '');
const chartRef = ref(null);
let chartInstance = null;

const goToCreateCompany = () => {
  router.get(route('tenants.create'));
};

const deleteCompany = (id) => {
  if (confirm('Tem certeza que deseja excluir esta academia?')) {
    router.delete(route('tenants.destroy', id), {
      onSuccess: () => {
        router.reload({ only: ['companies'] });
      },
    });
  }
};

const createChart = () => {
  if (chartInstance) {
    chartInstance.destroy();
  }

  if (!chartRef.value) return;

  const ctx = chartRef.value.getContext('2d');
  const gradient = ctx.createLinearGradient(0, 0, 0, 300);
  gradient.addColorStop(0, 'rgba(79, 70, 229, 0.7)'); // indigo-600
  gradient.addColorStop(1, 'rgba(79, 70, 229, 0.3)');

  chartInstance = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
      datasets: [{
        label: 'Academias Criadas por Mês',
        data: props.stats.monthly_data.tenants || Array(12).fill(0),
        backgroundColor: gradient,
        borderColor: '#4F46E5', // indigo-600
        borderWidth: 1,
        borderRadius: 6,
        barThickness: 20,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'top',
          labels: {
            font: { size: 14, family: 'Inter, sans-serif', weight: '600' },
            color: '#1F2937',
            padding: 20,
          },
        },
        title: {
          display: true,
          text: `Crescimento de Academias em ${new Date().getFullYear()}`,
          font: { size: 18, family: 'Inter, sans-serif', weight: '600' },
          color: '#1F2937',
          padding: { top: 10, bottom: 20 },
        },
        tooltip: {
          backgroundColor: 'rgba(79, 70, 229, 0.9)',
          titleFont: { family: 'Inter, sans-serif', size: 14, weight: '600' },
          bodyFont: { family: 'Inter, sans-serif', size: 12 },
          padding: 12,
          cornerRadius: 8,
          callbacks: {
            label: (context) => `${context.dataset.label}: ${context.parsed.y} academias`,
          },
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            font: { family: 'Inter, sans-serif', size: 12 },
            color: '#6B7280',
            padding: 10,
          },
          grid: { color: 'rgba(0, 0, 0, 0.05)' },
        },
        x: {
          ticks: {
            font: { family: 'Inter, sans-serif', size: 12 },
            color: '#6B7280',
            padding: 10,
          },
          grid: { display: false },
        },
      },
      animation: { duration: 1000, easing: 'easeOutQuart' },
    },
  });
};

// Debounced search
const debouncedSearch = debounce(() => {
  router.get(route('dashboard'), { search: searchQuery.value }, { preserveState: true });
}, 300);

watch(searchQuery, () => {
  debouncedSearch();
});

watch(() => props.stats, () => {
  createChart();
});

onMounted(() => {
  createChart();
});

onUnmounted(() => {
  if (chartInstance) {
    chartInstance.destroy();
  }
});
</script>

<template>
  <Head title="Dashboard - Gestão de Academias" />

  <AuthenticatedLayout>
    <template #header>
      <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl shadow-xl p-6 text-white">
        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
          Dashboard de Gestão
        </h2>
        <p class="mt-1 text-sm sm:text-base opacity-90">
          Visão geral das academias cadastradas
        </p>
      </div>
    </template>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-gray-50 to-gray-100">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Botões e Busca -->
        <div class="mb-8 flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0 animate-fade-in">
          <div class="flex space-x-4">
            <button
              @click="goToCreateCompany"
              class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-4 py-2 rounded-lg shadow-md hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300"
            >
              Nova Academia
            </button>
          </div>
          <div class="relative w-full md:w-64">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Buscar academias..."
              class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pl-10 pr-4 py-2 transition duration-200"
            />
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </span>
          </div>
        </div>

        <!-- Cartão de Estatísticas -->
        <div class="mb-8 grid grid-cols-1 sm:grid-cols-2 gap-6 animate-fade-in">
          <div class="rounded-xl bg-white p-6 shadow-lg border-l-4 border-indigo-600 transform hover:scale-105 transition duration-300">
            <h3 class="text-lg font-semibold text-gray-700">Total de Academias</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ stats.total_tenants }}</p>
            <p class="text-sm text-gray-500 mt-1">Criadas neste mês: {{ stats.tenants_this_month }}</p>
          </div>
        </div>

        <!-- Gráfico -->
        <div class="mb-8 bg-white rounded-xl shadow-lg p-6 animate-fade-in">
          <h3 class="text-lg font-semibold text-gray-700 mb-4">Crescimento Mensal</h3>
          <div class="relative h-80">
            <canvas ref="chartRef"></canvas>
          </div>
        </div>

        <!-- Tabela de Academias -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in">
          <div class="p-6">
            <div v-if="companies.length" class="mt-4 overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">
                      Nome
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">
                      Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">
                      Domínio
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-indigo-600 uppercase tracking-wider">
                      Ações
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr v-for="company in companies" :key="company.id" class="hover:bg-indigo-50 transition-colors duration-200">
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                      {{ company.name }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                      {{ company.email }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                      {{ company.domain }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm space-x-4">
                      <Link
                        :href="route('tenants.edit', company.id)"
                        class="text-indigo-600 hover:text-indigo-800 flex items-center"
                      >
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Editar
                      </Link>
                      <button
                        @click="deleteCompany(company.id)"
                        class="text-red-600 hover:text-red-800 flex items-center"
                      >
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Excluir
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div v-else class="rounded-lg bg-gray-50 p-8 text-center animate-fade-in">
              <p class="text-gray-500 text-lg">Nenhuma academia cadastrada</p>
              <button
                @click="goToCreateCompany"
                class="mt-4 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-2 rounded-lg shadow-md hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300"
              >
                Cadastre a primeira academia
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.font-inter {
  font-family: 'Inter', sans-serif;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fadeIn 0.5s ease-out;
}

input:focus {
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
}

button, a {
  transition: all 0.3s ease;
}

table tr:nth-child(even) {
  background-color: #f8fafc;
}

canvas {
  width: 100% !important;
  height: 100% !important;
}
</style>