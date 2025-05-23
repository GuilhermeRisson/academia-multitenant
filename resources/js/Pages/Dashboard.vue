<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const searchQuery = ref('');
const props = defineProps({
  stats: Object,
  companies: Array
});

const goToCreateCompany = () => {
    router.get(route('tenants.create'));
};

const deleteCompany = (id) => {
  if (confirm('Tem certeza que deseja excluir esta academia?')) {
    router.delete(route('companies.destroy', id), {
      onSuccess: () => {
        // Atualização opcional da lista após exclusão
        router.reload({ only: ['companies'] });
      }
    });
  }
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Botões e Busca -->
                <div class="mb-6 flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
                    <div class="flex space-x-4">
                        <button @click="goToCreateCompany" class="btn-primary">
                            Nova Academia
                        </button>
                    </div>
                    <div class="w-full md:w-64">
                        <input
                            v-model="searchQuery"
                            @keyup.enter="router.get(route('dashboard'), { search: searchQuery })"
                            type="text"
                            placeholder="Buscar academias..."
                            class="input-search"
                        />
                    </div>
                </div>

                <!-- Cartão de Estatísticas -->
                <div class="mb-6 rounded-lg bg-white p-6 shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Total de Academias</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ stats.totalTenants }}</p>
                </div>

                <!-- Tabela de Academias -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="companies.length" class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Nome
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Email
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Domínio
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Ações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="company in companies" :key="company.id">
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            {{ company.name }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            {{ company.email }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            {{ company.domain }}
                                        </td>
                                        <!-- <td class="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link 
                                                :href="route('companies.edit', company.id)" 
                                                class="text-blue-600 hover:text-blue-900"
                                            >
                                                Editar
                                            </Link>
                                            <button
                                                @click="deleteCompany(company.id)"
                                                class="ml-4 text-red-600 hover:text-red-900"
                                            >
                                                Excluir
                                            </button>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else class="rounded-lg bg-gray-50 p-8 text-center">
                            <p class="text-gray-500">Nenhuma academia cadastrada</p>
                            <button @click="goToCreateCompany" class="mt-4 btn-primary">
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
.btn-primary {
  @apply rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition-colors;
}

.input-search {
  @apply w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500;
}
</style>