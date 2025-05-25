<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  members: {
    type: Object, // Changed to Object to support paginated data
    default: () => ({ data: [], links: [] }),
  },
});

const search = ref('');

const filteredMembers = computed(() => {
  if (!search.value) return props.members.data || [];
  return (props.members.data || []).filter(member =>
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

// Handle pagination navigation
const goToPage = (url) => {
  if (url) {
    router.get(url, { search: search.value }, { preserveState: true });
  }
};
</script>

<template>
  <Head title="Gerenciar Membros - Tenant" />

  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Enhanced Header -->
    <header class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl shadow-xl p-6 mb-8 sticky top-0 z-10">
      <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="text-center sm:text-left">
          <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
            Gerenciamento de Membros
          </h1>
          <p class="mt-1 text-sm sm:text-base text-indigo-100 opacity-90">
            Visualize e gerencie os membros cadastrados
          </p>
        </div>
        <div>
          <Link href="/admin/dashboard"
            class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-indigo-50 hover:text-indigo-800 transition-all duration-300"
          >
            Dashboard
          </Link>
        </div>
        <div>
          <Link href="/admin/members/create"
            class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-indigo-50 hover:text-indigo-800 transition-all duration-300"
          >
            Novo Membro
          </Link>
        </div>
      </div>
    </header>

    <div class="max-w-7xl mx-auto">
      <!-- Search Input -->
      <div class="mb-6">
        <div class="relative max-w-md">
          <input
            v-model="search"
            type="text"
            placeholder="Buscar por nome, e-mail ou cidade..."
            class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pl-10 transition duration-200"
          />
          <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </span>
        </div>
      </div>

      <!-- Members Table -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-indigo-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">Nome</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">E-mail</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">Cidade</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">Estado</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-right text-xs font-semibold text-indigo-600 uppercase tracking-wider">Ações</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="member in filteredMembers" :key="member.id" class="hover:bg-indigo-50 transition-colors duration-200">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ member.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ member.email || '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ member.city || '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ member.state || '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <span :class="member.active ? 'text-green-600' : 'text-red-600'">
                  {{ member.active ? 'Ativo' : 'Inativo' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                <Link
                  :href="`/admin/members/${member.id}`"
                  class="text-indigo-600 hover:text-indigo-800 mr-4 font-medium"
                >
                  Ver
                </Link>
                <Link
                  :href="`/admin/members/${member.id}/edit`"
                  class="text-indigo-600 hover:text-indigo-800 mr-4 font-medium"
                >
                  Editar
                </Link>
                <button
                  @click="confirm(() => router.delete(`/admin/members/${member.id}`))"
                  class="text-red-600 hover:text-red-800 font-medium"
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

      <!-- Pagination -->
      <div v-if="props.members.links && props.members.links.length > 3" class="mt-6 flex justify-center items-center space-x-2">
        <button
          v-for="link in props.members.links"
          :key="link.label"
          @click="goToPage(link.url)"
          :disabled="!link.url"
          class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300"
          :class="{
            'bg-indigo-600 text-white hover:bg-indigo-700': link.active,
            'bg-white text-indigo-600 hover:bg-indigo-50 shadow-sm': link.url && !link.active,
            'text-gray-400 cursor-not-allowed': !link.url
          }"
          v-html="link.label"
        ></button>
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

header.sticky {
  z-index: 10;
}

table tr:nth-child(even) {
  background-color: #f8fafc;
}

input {
  transition: all 0.3s ease;
}

input:focus {
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
}

button, a {
  transition: all 0.3s ease;
}
</style>