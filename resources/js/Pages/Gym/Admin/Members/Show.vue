<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
  member: Object,
});
</script>

<template>
  <Head title="Detalhes do Membro - Tenant" />

  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Detalhes do Membro</h1>
        <Link
          href="/tenant/admin/members"
          class="text-indigo-600 hover:text-indigo-800"
        >
          Voltar
        </Link>
      </div>

      <div class="space-y-4">
        <div>
          <span class="font-medium text-gray-700">Nome:</span>
          <span class="ml-2 text-gray-900">{{ member.name }}</span>
        </div>
        <div>
          <span class="font-medium text-gray-700">E-mail:</span>
          <span class="ml-2 text-gray-900">{{ member.email || 'Não informado' }}</span>
        </div>
        <div>
          <span class="font-medium text-gray-700">Telefone:</span>
          <span class="ml-2 text-gray-900">{{ member.phone || 'Não informado' }}</span>
        </div>
        <div>
          <span class="font-medium text-gray-700">Data de Nascimento:</span>
          <span class="ml-2 text-gray-900">{{ member.birth_date ? new Date(member.birth_date).toLocaleDateString('pt-BR') : 'Não informado' }}</span>
        </div>
        <div>
          <span class="font-medium text-gray-700">Endereço:</span>
          <span class="ml-2 text-gray-900">
            {{ member.street ? `${member.street}, ${member.number || ''} ${member.complement || ''}, ${member.neighborhood || ''}, ${member.city || ''} - ${member.state || ''}, ${member.postal_code || ''}` : 'Não informado' }}
          </span>
        </div>
        <div>
          <span class="font-medium text-gray-700">Status:</span>
          <span class="ml-2 text-gray-900" :class="member.active ? 'text-green-600' : 'text-red-600'">
            {{ member.active ? 'Ativo' : 'Inativo' }}
          </span>
        </div>
        <div>
          <span class="font-medium text-gray-700">Data de Registro:</span>
          <span class="ml-2 text-gray-900">{{ member.registration_date ? new Date(member.registration_date).toLocaleDateString('pt-BR') : 'Não informado' }}</span>
        </div>
        <div>
          <span class="font-medium text-gray-700">Observações:</span>
          <p class="ml-2 text-gray-900">{{ member.notes || 'Nenhuma observação' }}</p>
        </div>
      </div>

      <div class="mt-6 flex space-x-4">
        <Link
          :href="`/tenant/admin/members/${member.id}/edit`"
          class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700"
        >
          Editar
        </Link>
        <button
          @click="confirm(() => $inertia.delete(`/tenant/admin/members/${member.id}`))"
          class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"
        >
          Excluir
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    confirm(action) {
      if (window.confirm('Tem certeza que deseja excluir este membro?')) {
        action();
      }
    },
  },
};
</script>