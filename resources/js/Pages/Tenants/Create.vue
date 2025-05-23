<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  tenant: Object, // For editing, if a tenant is passed
});

const form = useForm({
  name: props.tenant?.name || '',
  email: props.tenant?.email || '',
  domain: props.tenant?.domain || '',
  cnpj: props.tenant?.cnpj || '',
  street: props.tenant?.street || '',
  number: props.tenant?.number || '',
  complement: props.tenant?.complement || '',
  city: props.tenant?.city || '',
  state: props.tenant?.state || '',
  postal_code: props.tenant?.postal_code || '',
});

function submit() {
  if (props.tenant) {
    form.put(`/tenants/${props.tenant.id}`);
  } else {
    form.post('/tenants');
  }
}

function resetForm() {
  form.reset();
}
</script>

<template>
  <Head :title="props.tenant ? 'Editar Tenant' : 'Novo Tenant'" />

  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl w-full">
      <h1 class="text-2xl font-bold text-gray-800 mb-6">
        {{ props.tenant ? 'Editar Tenant' : 'Novo Tenant' }}
      </h1>

      <form @submit.prevent="submit" class="space-y-8">
        <!-- General Information -->
        <div class="space-y-6">
          <h2 class="text-lg font-semibold text-gray-700">Informações Gerais</h2>

          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
            <input
              id="name"
              v-model="form.name"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
              :class="{ 'border-red-500': form.errors.name }"
              placeholder="Digite o nome do tenant"
            />
            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ form.errors.name }}
            </div>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
              :class="{ 'border-red-500': form.errors.email }"
              placeholder="Digite o email"
            />
            <div v-if="form.errors.email" class="text-red-500 text-sm mt-1 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ form.errors.email }}
            </div>
          </div>

          <div>
            <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ</label>
            <input
              id="cnpj"
              v-model="form.cnpj"
              v-mask="'##.###.###/####-##'"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
              :class="{ 'border-red-500': form.errors.cnpj }"
              placeholder="12.345.678/0001-90"
            />
            <div v-if="form.errors.cnpj" class="text-red-500 text-sm mt-1 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ form.errors.cnpj }}
            </div>
          </div>

          <div>
            <label for="domain" class="block text-sm font-medium text-gray-700">Domínio</label>
            <input
              id="domain"
              v-model="form.domain"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
              :class="{ 'border-red-500': form.errors.domain }"
              placeholder="Digite o domínio (ex: empresa.com)"
            />
            <div v-if="form.errors.domain" class="text-red-500 text-sm mt-1 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ form.errors.domain }}
            </div>
          </div>
        </div>

        <!-- Address Information -->
        <div class="space-y-6">
          <h2 class="text-lg font-semibold text-gray-700">Endereço</h2>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="street" class="block text-sm font-medium text-gray-700">Rua</label>
              <input
                id="street"
                v-model="form.street"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                :class="{ 'border-red-500': form.errors.street }"
                placeholder="Digite a rua"
              />
              <div v-if="form.errors.street" class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ form.errors.street }}
              </div>
            </div>

            <div>
              <label for="number" class="block text-sm font-medium text-gray-700">Número</label>
              <input
                id="number"
                v-model="form.number"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                :class="{ 'border-red-500': form.errors.number }"
                placeholder="Digite o número"
              />
              <div v-if="form.errors.number" class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ form.errors.number }}
              </div>
            </div>
          </div>

          <div>
            <label for="complement" class="block text-sm font-medium text-gray-700">Complemento</label>
            <input
              id="complement"
              v-model="form.complement"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
              :class="{ 'border-red-500': form.errors.complement }"
              placeholder="Digite o complemento (opcional)"
            />
            <div v-if="form.errors.complement" class="text-red-500 text-sm mt-1 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ form.errors.complement }}
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="city" class="block text-sm font-medium text-gray-700">Cidade</label>
              <input
                id="city"
                v-model="form.city"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                :class="{ 'border-red-500': form.errors.city }"
                placeholder="Digite a cidade"
              />
              <div v-if="form.errors.city" class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ form.errors.city }}
              </div>
            </div>

            <div>
              <label for="state" class="block text-sm font-medium text-gray-700">Estado</label>
              <input
                id="state"
                v-model="form.state"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                :class="{ 'border-red-500': form.errors.state }"
                placeholder="Digite o estado (ex: SP)"
              />
              <div v-if="form.errors.state" class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ form.errors.state }}
              </div>
            </div>
          </div>

          <div>
            <label for="postal_code" class="block text-sm font-medium text-gray-700">CEP</label>
            <input
              id="postal_code"
              v-model="form.postal_code"
              v-mask="'#####-###'"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
              :class="{ 'border-red-500': form.errors.postal_code }"
              placeholder="12345-678"
            />
            <div v-if="form.errors.postal_code" class="text-red-500 text-sm mt-1 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ form.errors.postal_code }}
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between items-center">
          <div class="flex space-x-4">
            <Link href="/dashboard" class="text-blue-600 hover:underline">Voltar</Link>
            <button
              type="button"
              @click="resetForm"
              class="text-gray-600 hover:text-gray-800"
            >
              Limpar
            </button>
          </div>
          <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 disabled:bg-gray-400 flex items-center"
            :disabled="form.processing"
          >
            <svg v-if="form.processing" class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ form.processing ? 'Salvando...' : 'Salvar' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>