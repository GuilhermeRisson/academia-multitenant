<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { mask } from 'vue-the-mask';

const form = useForm({
  name: '',
  email: '',
  phone: '',
  birth_date: '',
  street: '',
  number: '',
  complement: '',
  neighborhood: '',
  city: '',
  state: '',
  postal_code: '',
  active: true,
  registration_date: new Date().toISOString().split('T')[0],
  notes: '',
});

function submit() {
  form.post('/admin/members', {
    onSuccess: () => form.reset(),
  });
}
</script>

<template>
  <Head title="Criar Membro - Tenant" />

  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Enhanced Header -->
    <header class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl shadow-xl p-6 mb-8 sticky top-0 z-10">
      <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="text-center sm:text-left">
          <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
            Criar Novo Membro
          </h1>
          <p class="mt-1 text-sm sm:text-base text-indigo-100 opacity-90">
            Adicione um novo membro ao sistema
          </p>
        </div>
        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
          <Link
            href="/admin/dashboard"
            class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-indigo-50 hover:text-indigo-800 transition-all duration-300"
          >
            Voltar ao Dashboard
          </Link>
        </div>
      </div>
    </header>

    <!-- Form -->
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8 animate-fade-in">
      <form @submit.prevent="submit" class="space-y-8">
        <!-- Dados Pessoais -->
        <div class="space-y-6">
          <h2 class="text-xl font-semibold text-gray-800">Dados Pessoais</h2>
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
                  placeholder="Nome completo"
                />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </span>
              </div>
              <div v-if="form.errors.name" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.name }}</div>
            </div>
            <div class="relative">
              <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
              <div class="mt-1 relative">
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 pl-10"
                  :class="{ 'border-red-500': form.errors.email }"
                  placeholder="email@exemplo.com"
                />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                  </svg>
                </span>
              </div>
              <div v-if="form.errors.email" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.email }}</div>
            </div>
            <div class="relative">
              <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
              <div class="mt-1 relative">
                <input
                  id="phone"
                  v-model="form.phone"
                  v-mask="'(##) #####-####'"
                  type="text"
                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 pl-10"
                  :class="{ 'border-red-500': form.errors.phone }"
                  placeholder="(99) 99999-9999"
                />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                </span>
              </div>
              <div v-if="form.errors.phone" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.phone }}</div>
            </div>
            <div class="relative">
              <label for="birth_date" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
              <div class="mt-1 relative">
                <input
                  id="birth_date"
                  v-model="form.birth_date"
                  type="date"
                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 pl-10"
                  :class="{ 'border-red-500': form.errors.birth_date }"
                />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </span>
              </div>
              <div v-if="form.errors.birth_date" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.birth_date }}</div>
            </div>
          </div>
        </div>

        <!-- Endereço -->
        <div class="space-y-6">
          <h2 class="text-xl font-semibold text-gray-800">Endereço</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="relative">
              <label for="street" class="block text-sm font-medium text-gray-700">Rua</label>
              <input
                id="street"
                v-model="form.street"
                type="text"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                :class="{ 'border-red-500': form.errors.street }"
                placeholder="Rua Exemplo"
              />
              <div v-if="form.errors.street" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.street }}</div>
            </div>
            <div class="relative">
              <label for="number" class="block text-sm font-medium text-gray-700">Número</label>
              <input
                id="number"
                v-model="form.number"
                type="text"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                :class="{ 'border-red-500': form.errors.number }"
                placeholder="123"
              />
              <div v-if="form.errors.number" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.number }}</div>
            </div>
            <div class="relative">
              <label for="complement" class="block text-sm font-medium text-gray-700">Complemento</label>
              <input
                id="complement"
                v-model="form.complement"
                type="text"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                :class="{ 'border-red-500': form.errors.complement }"
                placeholder="Apto 101"
              />
              <div v-if="form.errors.complement" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.complement }}</div>
            </div>
            <div class="relative">
              <label for="neighborhood" class="block text-sm font-medium text-gray-700">Bairro</label>
              <input
                id="neighborhood"
                v-model="form.neighborhood"
                type="text"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                :class="{ 'border-red-500': form.errors.neighborhood }"
                placeholder="Centro"
              />
              <div v-if="form.errors.neighborhood" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.neighborhood }}</div>
            </div>
            <div class="relative">
              <label for="city" class="block text-sm font-medium text-gray-700">Cidade</label>
              <input
                id="city"
                v-model="form.city"
                type="text"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                :class="{ 'border-red-500': form.errors.city }"
                placeholder="São Paulo"
              />
              <div v-if="form.errors.city" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.city }}</div>
            </div>
            <div class="relative">
              <label for="state" class="block text-sm font-medium text-gray-700">Estado (UF)</label>
              <input
                id="state"
                v-model="form.state"
                type="text"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                :class="{ 'border-red-500': form.errors.state }"
                placeholder="SP"
                maxlength="2"
              />
              <div v-if="form.errors.state" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.state }}</div>
            </div>
            <div class="relative">
              <label for="postal_code" class="block text-sm font-medium text-gray-700">CEP</label>
              <input
                id="postal_code"
                v-model="form.postal_code"
                v-mask="'#####-###'"
                type="text"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                :class="{ 'border-red-500': form.errors.postal_code }"
                placeholder="12345-678"
              />
              <div v-if="form.errors.postal_code" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.postal_code }}</div>
            </div>
          </div>
        </div>

        <!-- Status e Data de Registro -->
        <div class="space-y-6">
          <h2 class="text-xl font-semibold text-gray-800">Status e Registro</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="relative">
              <label for="active" class="block text-sm font-medium text-gray-700">Status</label>
              <select
                id="active"
                v-model="form.active"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                :class="{ 'border-red-500': form.errors.active }"
              >
                <option :value="true">Ativo</option>
                <option :value="false">Inativo</option>
              </select>
              <div v-if="form.errors.active" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.active }}</div>
            </div>
            <div class="relative">
              <label for="registration_date" class="block text-sm font-medium text-gray-700">Data de Registro</label>
              <div class="mt-1 relative">
                <input
                  id="registration_date"
                  v-model="form.registration_date"
                  type="date"
                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 pl-10"
                  :class="{ 'border-red-500': form.errors.registration_date }"
                />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </span>
              </div>
              <div v-if="form.errors.registration_date" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.registration_date }}</div>
            </div>
          </div>

        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
          <button
            type="submit"
            class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-4 py-2 rounded-lg shadow-md hover:from-indigo-700 hover:to-indigo-800 disabled:bg-gray-400 transition-all duration-300"
            :disabled="form.processing"
          >
            {{ form.processing ? 'Salvando...' : 'Criar Membro' }}
          </button>
          <Link
            href="/admin/members"
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
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fadeIn 0.5s ease-out;
}

header,
form {
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