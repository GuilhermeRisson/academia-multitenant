<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';

// Register all Chart.js components
Chart.register(...registerables);

const props = defineProps({
  total_members: Number,
  members_this_month: Number,
  recent_members: Array,
  monthly_data: Object,
});

const chartRef = ref(null);

onMounted(() => {
  if (!chartRef.value) {
    console.error('Canvas element not found');
    return;
  }

  const chartData = props.monthly_data?.members || Array(12).fill(0);

  try {
    new Chart(chartRef.value, {
      type: 'line',
      data: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        datasets: [{
          label: 'Novos Membros por Mês',
          data: chartData,
          borderColor: '#4F46E5',
          backgroundColor: 'rgba(79, 70, 229, 0.2)',
          fill: true,
          tension: 0.4,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              font: {
                size: 14,
                family: 'Inter, sans-serif',
              },
            },
          },
          title: {
            display: true,
            text: 'Crescimento de Membros em ' + new Date().getFullYear(),
            font: {
              size: 18,
              family: 'Inter, sans-serif',
              weight: '600',
            },
            padding: 20,
          },
          tooltip: {
            enabled: true,
            mode: 'index',
            intersect: false,
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1,
              font: {
                family: 'Inter, sans-serif',
              },
            },
          },
          x: {
            grid: {
              display: false,
            },
            ticks: {
              font: {
                family: 'Inter, sans-serif',
              },
            },
          },
        },
      },
    });
  } catch (error) {
    console.error('Chart initialization error:', error);
  }
});
</script>

<template>
  <Head title="Dashboard - Tenant" />

  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Enhanced Header -->
    <header class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl shadow-xl p-6 mb-8 sticky top-0 z-10">
      <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="text-center sm:text-left">
          <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
            Dashboard da Unidade
          </h1>
          <p class="mt-1 text-sm sm:text-base text-indigo-100 opacity-90">
            Visão geral dos membros e atividades recentes
          </p>
        </div>
        <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
          <Link
            href="/admin/tenants"
            class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-indigo-50 hover:text-indigo-800 transition-all duration-300"
          >
            Ver Perfil
          </Link>
          <Link
            href="/admin/members"
            class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-indigo-50 hover:text-indigo-800 transition-all duration-300"
          >
            Ver Todos os Membros
          </Link>
          <Link
            href="/admin/members/create"
            class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-600 transition-all duration-300"
          >
            Cadastrar Novo Membro
          </Link>
          <Link
            href="/admin/plans"
            class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-indigo-50 hover:text-indigo-800 transition-all duration-300"
          >
            Gerenciar Planos
          </Link>
        </div>
      </div>
    </header>

    <div class="max-w-7xl mx-auto">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in">
          <h2 class="text-lg font-semibold text-gray-700">Total de Membros</h2>
          <p class="text-3xl font-bold text-indigo-600">{{ total_members }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in">
          <h2 class="text-lg font-semibold text-gray-700">Membros este Mês</h2>
          <p class="text-3xl font-bold text-indigo-600">{{ members_this_month }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in">
          <h2 class="text-lg font-semibold text-gray-700">Taxa de Crescimento</h2>
          <p class="text-3xl font-bold text-indigo-600">
            {{ members_this_month > 0 ? ((members_this_month / total_members) * 100).toFixed(1) : 0 }}%
          </p>
        </div>
      </div>

      <!-- Chart Section -->
      <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-fade-in">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Crescimento Mensal</h2>
        <div class="relative h-96">
          <canvas ref="chartRef"></canvas>
        </div>
      </div>

      <!-- Recent Members Table -->
      <div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold text-gray-700">Membros Recentes</h2>
          <Link
            href="/admin/members"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition-all duration-300"
          >
            Ver Todos
          </Link>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-indigo-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">Nome</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">E-mail</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">Data de Cadastro</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="member in recent_members" :key="member.id" class="hover:bg-indigo-50 transition-colors duration-200">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ member.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ member.email || '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  {{ new Date(member.created_at).toLocaleDateString('pt-BR') }}
                </td>
              </tr>
              <tr v-if="recent_members.length === 0">
                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Nenhum membro recente.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fadeIn 0.5s ease-out;
}

.bg-white {
  transition: all 0.3s ease;
}

canvas {
  width: 100% !important;
  height: 100% !important;
}

header.sticky {
  z-index: 10;
}

/* Ajustes gerais para o cabeçalho */
header {
  padding: 1rem; /* Reduz o padding no mobile */
}

/* Ajustes para o container interno do cabeçalho */
header .max-w-7xl {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

/* Estilização do título e descrição */
header h1 {
  font-size: 1.5rem; /* Reduz o tamanho da fonte no mobile */
  line-height: 1.2;
}

header p {
  font-size: 0.875rem; /* Reduz a descrição no mobile */
}

/* Ajustes para os botões */
header .flex-wrap {
  display: flex;
  flex-direction: column;
  gap: 0.5rem; /* Menor espaçamento entre botões */
}

header .flex-wrap a {
  width: auto; /* Remove largura total */
  padding: 0.5rem 1rem; /* Padding mais compacto */
  text-align: center;
  font-size: 0.875rem; /* Fonte menor para botões */
}

/* Media query para telas maiores que 640px */
@media (min-width: 640px) {
  header .max-w-7xl {
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }

  header .flex-wrap {
    flex-direction: row;
    gap: 1rem;
  }

  header h1 {
    font-size: 1.875rem; /* Tamanho original para desktop */
  }

  header p {
    font-size: 1rem; /* Tamanho original para desktop */
  }

  header .flex-wrap a {
    width: auto;
    padding: 0.5rem 1rem;
    font-size: 1rem;
  }
}

table tr:nth-child(even) {
  background-color: #f8fafc;
}

button,
a {
  transition: all 0.3s ease;
}
</style>