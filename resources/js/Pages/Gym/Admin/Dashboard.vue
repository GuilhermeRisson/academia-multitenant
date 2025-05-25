<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
  total_members: Number,
  members_this_month: Number,
  recent_members: Array,
});
</script>

<template>
  <Head title="Dashboard - Tenant" />

  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard da Unidade</h1>

      <!-- Métricas -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
          <h2 class="text-lg font-medium text-gray-700">Total de Membros</h2>
          <p class="text-3xl font-bold text-indigo-600">{{ total_members }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6">
          <h2 class="text-lg font-medium text-gray-700">Membros este Mês</h2>
          <p class="text-3xl font-bold text-indigo-600">{{ members_this_month }}</p>
        </div>
      </div>

      <!-- Membros Recentes -->
      <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-medium text-gray-700 mb-4">Membros Recentes</h2>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">E-mail</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data de Cadastro</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="member in recent_members" :key="member.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ member.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ member.email || '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ new Date(member.created_at).toLocaleDateString('pt-BR') }}
              </td>
            </tr>
            <tr v-if="!recent_members.length">
              <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Nenhum membro recente.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>