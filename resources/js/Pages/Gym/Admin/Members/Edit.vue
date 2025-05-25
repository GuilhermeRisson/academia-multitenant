<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { mask } from 'vue-the-mask';

defineProps({
  member: Object,
});

const form = useForm({
  name: member.name,
  email: member.email || '',
  phone: member.phone || '',
  birth_date: member.birth_date || '',
  street: member.street || '',
  number: member.number || '',
  complement: member.complement || '',
  neighborhood: member.neighborhood || '',
  city: member.city || '',
  state: member.state || '',
  postal_code: member.postal_code || '',
  active: member.active ?? true,
  registration_date: member.registration_date || '',
  notes: member.notes || '',
});

function submit() {
  form.put(`/tenant/admin/members/${member.id}`, {
    onSuccess: () => form.reset(),
  });
}
</script>

<template>
  <Head title="Editar Membro - Tenant" />

  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-2xl font-bold text-gray-900 mb-6">Editar Membro</h1>

      <form @submit.prevent="submit" class="space-y-6">
        <!-- Dados Pessoais -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.name }"
              placeholder="Nome completo"
            />
            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.email }"
              placeholder="email@exemplo.com"
            />
            <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
          </div>
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
            <input
              id="phone"
              v-model="form.phone"
              v-mask="'(##) #####-####'"
              type="text"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.phone }"
              placeholder="(99) 99999-9999"
            />
            <div v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</div>
          </div>
          <div>
            <label for="birth_date" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
            <input
              id="birth_date"
              v-model="form.birth_date"
              type="date"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.birth_date }"
            />
            <div v-if="form.errors.birth_date" class="text-red-500 text-sm mt-1">{{ form.errors.birth_date }}</div>
          </div>
        </div>

        <!-- Endereço -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="street" class="block text-sm font-medium text-gray-700">Rua</label>
            <input
              id="street"
              v-model="form.street"
              type="text"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.street }"
              placeholder="Rua Exemplo"
            />
            <div v-if="form.errors.street" class="text-red-500 text-sm mt-1">{{ form.errors.street }}</div>
          </div>
          <div>
            <label for="number" class="block text-sm font-medium text-gray-700">Número</label>
            <input
              id="number"
              v-model="form.number"
              type="text"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.number }"
              placeholder="123"
            />
            <div v-if="form.errors.number" class="text-red-500 text-sm mt-1">{{ form.errors.number }}</div>
          </div>
          <div>
            <label for="complement" class="block text-sm font-medium text-gray-700">Complemento</label>
            <input
              id="complement"
              v-model="form.complement"
              type="text"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.complement }"
              placeholder="Apto 101"
            />
            <div v-if="form.errors.complement" class="text-red-500 text-sm mt-1">{{ form.errors.complement }}</div>
          </div>
          <div>
            <label for="neighborhood" class="block text-sm font-medium text-gray-700">Bairro</label>
            <input
              id="neighborhood"
              v-model="form.neighborhood"
              type="text"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.neighborhood }"
              placeholder="Centro"
            />
            <div v-if="form.errors.neighborhood" class="text-red-500 text-sm mt-1">{{ form.errors.neighborhood }}</div>
          </div>
          <div>
            <label for="city" class="block text-sm font-medium text-gray-700">Cidade</label>
            <input
              id="city"
              v-model="form.city"
              type="text"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.city }"
              placeholder="São Paulo"
            />
            <div v-if="form.errors.city" class="text-red-500 text-sm mt-1">{{ form.errors.city }}</div>
          </div>
          <div>
            <label for="state" class="block text-sm font-medium text-gray-700">Estado (UF)</label>
            <input
              id="state"
              v-model="form.state"
              type="text"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.state }"
              placeholder="SP"
              maxlength="2"
            />
            <div v-if="form.errors.state" class="text-red-500 text-sm mt-1">{{ form.errors.state }}</div>
          </div>
          <div>
            <label for="postal_code" class="block text-sm font-medium text-gray-700">CEP</label>
            <input
              id="postal_code"
              v-model="form.postal_code"
              v-mask="'#####-###'"
              type="text"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.postal_code }"
              placeholder="12345-678"
            />
            <div v-if="form.errors.postal_code" class="text-red-500 text-sm mt-1">{{ form.errors.postal_code }}</div>
          </div>
        </div>

        <!-- Status e Data de Registro -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="active" class="block text-sm font-medium text-gray-700">Status</label>
            <select
              id="active"
              v-model="form.active"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.active }"
            >
              <option :value="true">Ativo</option>
              <option :value="false">Inativo</option>
            </select>
            <div v-if="form.errors.active" class="text-red-500 text-sm mt-1">{{ form.errors.active }}</div>
          </div>
          <div>
            <label for="registration_date" class="block text-sm font-medium text-gray-700">Data de Registro</label>
            <input
              id="registration_date"
              v-model="form.registration_date"
              type="date"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              :class="{ 'border-red-500': form.errors.registration_date }"
            />
            <div v-if="form.errors.registration_date" class="text-red-500 text-sm mt-1">{{ form.errors.registration_date }}</div>
          </div>
        </div>

        <!-- Observações -->
        <div>
          <label for="notes" class="block text-sm font-medium text-gray-700">Observações</label>
          <textarea
            id="notes"
            v-model="form.notes"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            :class="{ 'border-red-500': form.errors.notes }"
            placeholder="Notas adicionais"
            rows="4"
          ></textarea>
          <div v-if="form.errors.notes" class="text-red-500 text-sm mt-1">{{ form.errors.notes }}</div>
        </div>

        <div class="flex space-x-4">
          <button
            type="submit"
            class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 disabled:bg-gray-400"
            :disabled="form.processing"
          >
            {{ form.processing ? 'Salvando...' : 'Atualizar Membro' }}
          </button>
          <Link
            href="/admin/members"
            class="flex-1 text-center bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300"
          >
            Cancelar
          </Link>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
form {
  animation: fadeIn 0.5s ease-in-out;
}

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
</style>