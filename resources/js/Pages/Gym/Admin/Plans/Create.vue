<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  price: '',
  features: [],
});

function submit() {
  form.post('/admin/plans', {
    onSuccess: () => form.reset(),
  });
}

function addFeature() {
  form.features.push('');
}

function removeFeature(index) {
  form.features.splice(index, 1);
}
</script>

<template>
  <Head title="Criar Plano - Tenant" />

  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Enhanced Header -->
    <header class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl shadow-xl p-6 mb-8 sticky top-0 z-10">
      <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="text-center sm:text-left">
          <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
            Criar Novo Plano
          </h1>
          <p class="mt-1 text-sm sm:text-base text-indigo-100 opacity-90">
            Adicione um novo plano ao sistema
          </p>
        </div>
        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
          <Link
            href="/admin/dashboard"
            class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-indigo-50 hover:text-indigo-800 transition-all duration-300"
          >
            Voltar ao Dashboard
          </Link>
          <Link
            href="/admin/plans"
            class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-indigo-50 hover:text-indigo-800 transition-all duration-300"
          >
            Voltar aos Planos
          </Link>
        </div>
      </div>
    </header>

    <!-- Form -->
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8 animate-fade-in">
      <form @submit.prevent="submit" class="space-y-8">
        <!-- Plan Details -->
        <div class="space-y-6">
          <h2 class="text-xl font-semibold text-gray-800">Detalhes do Plano</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="relative">
              <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
              <div class="mt-1 relative">
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  required
                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 pl-10"
                  :class="{ 'border-red-500': form.errors.name }"
                  placeholder="Nome do plano"
                />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                  </svg>
                </span>
              </div>
              <div v-if="form.errors.name" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.name }}</div>
            </div>
            <div class="relative">
              <label for="price" class="block text-sm font-medium text-gray-700">Preço (R$/mês)</label>
              <div class="mt-1 relative">
                <input
                  id="price"
                  v-model="form.price"
                  type="number"
                  step="0.01"
                  required
                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 pl-10"
                  :class="{ 'border-red-500': form.errors.price }"
                  placeholder="99.00"
                />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </span>
              </div>
              <div v-if="form.errors.price" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.price }}</div>
            </div>
          </div>
        </div>

        <!-- Features -->
        <div class="space-y-6">
          <h2 class="text-xl font-semibold text-gray-800">Recursos do Plano</h2>
          <div v-for="(feature, index) in form.features" :key="index" class="flex items-center gap-4">
            <input
              v-model="form.features[index]"
              type="text"
              class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
              :class="{ 'border-red-500': form.errors[`features.${index}`] }"
              placeholder="Recurso do plano"
            />
            <button
              type="button"
              @click="removeFeature(index)"
              class="text-red-600 hover:text-red-800"
            >
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
            <div v-if="form.errors[`features.${index}`]" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors[`features.${index}`] }}</div>
          </div>
          <button
            type="button"
            @click="addFeature"
            class="text-indigo-600 hover:text-indigo-800 font-medium"
          >
            + Adicionar Recurso
          </button>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
          <button
            type="submit"
            class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-4 py-2 rounded-lg shadow-md hover:from-indigo-700 hover:to-indigo-800 disabled:bg-gray-400 transition-all duration-300"
            :disabled="form.processing"
          >
            {{ form.processing ? 'Salvando...' : 'Criar Plano' }}
          </button>
          <Link
            href="/admin/plans"
            class="flex-1 text-center bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow-md hover:bg-gray-300 transition-all duration-300"
          >
            Cancelar
          </Link>
        </div>
      </form>
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

header, form {
  animation: fadeIn 0.5s ease-in-out;
}

input, select, textarea {
  transition: all 0.3s ease;
}

input:focus, select:focus, textarea:focus {
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
}

button, a {
  transition: all 0.3s ease;
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

</style>