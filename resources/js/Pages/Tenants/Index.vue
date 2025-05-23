<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  stats: Object
});
</script>

<template>

  <Head title="Dashboard Admin" />

  <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow p-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
      <Link href="/logout" class="text-blue-600 hover:underline">Sair</Link>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto p-6">
      <!-- Stats -->
      <div class="max-w-7xl mx-auto p-6">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
          <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total de Academias</h3>
            <p class="text-3xl font-bold text-blue-600">{{ stats.totalTenants }}</p>
          </div>

          <!-- Opcional: manter estrutura para futuras estatísticas -->
          <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Usuários Ativos</h3>
            <p class="text-3xl font-bold text-blue-600">0</p> <!-- Placeholder -->
          </div>

          <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Solicitações Pendentes</h3>
            <p class="text-3xl font-bold text-blue-600">0</p> <!-- Placeholder -->
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Ações Rápidas</h2>
        <div class="flex space-x-4">
          <Link href="/tenants/create" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
          Nova Academia
          </Link>
          <Link href="/tenants" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
            Gerenciar Academias
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>