<script setup>
  import { Head, Link } from '@inertiajs/vue3';
  import { ref, computed } from 'vue';
  import { router } from '@inertiajs/vue3';

  const props = defineProps({
    members: {
      type: Array,
      default: () => [], // Fallback para array vazio se members não for passado
    },
  });

  const search = ref('');

  const filteredMembers = computed(() => {
    if (!search.value) return props.members || []; // Use props.members instead of just members
    return (props.members || []).filter(member =>
      member.name?.toLowerCase().includes(search.value.toLowerCase()) ||
      (member.email && member.email.toLowerCase().includes(search.value.toLowerCase())) ||
      (member.city && member.city.toLowerCase().includes(search.value.toLowerCase()))
    );
  });

  const confirm = (action) => {
    if (window.confirm('Tem certeza que deseja excluir este membro?')) {
      action();
    }
  };
</script>
<template>
  <Head title="Gerenciar Membros - Tenant" />

  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Gerenciamento de Membros</h1>
        <Link
          href="/tenant/admin/members/create"
          class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition"
        >
          Novo Membro
        </Link>
      </div>

      <div class="mb-6">
        <input
          v-model="search"
          type="text"
          placeholder="Buscar por nome, e-mail ou cidade..."
          class="w-full max-w-md rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        />
      </div>

      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">E-mail</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cidade</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="member in filteredMembers" :key="member.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ member.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ member.email || '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ member.city || '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ member.state || '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <span :class="member.active ? 'text-green-600' : 'text-red-600'">
                  {{ member.active ? 'Ativo' : 'Inativo' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                <Link
                  :href="`/tenant/admin/members/${member.id}`"
                  class="text-indigo-600 hover:text-indigo-800 mr-4"
                >
                  Ver
                </Link>
                <Link
                  :href="`/tenant/admin/members/${member.id}/edit`"
                  class="text-indigo-600 hover:text-indigo-800 mr-4"
                >
                  Editar
                </Link>
                <button
                  @click="confirm(() => router.delete(`/tenant/admin/members/${member.id}`))"
                  class="text-red-600 hover:text-red-800"
                >
                  Excluir
                </button>
              </td>
            </tr>
            <tr v-if="!filteredMembers || filteredMembers.length === 0">
              <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Nenhum membro encontrado.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>