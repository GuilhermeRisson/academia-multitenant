<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

defineProps({
  member: Object, // Este objeto agora incluirá o relacionamento 'plan'
});

const confirm = (action) => {
  if (window.confirm('Tem certeza que deseja excluir este membro?')) {
    action();
  }
};
</script>

<template>
  <Head title="Detalhes do Membro - Tenant" />

  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <header class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl shadow-xl p-6 mb-8 sticky top-0 z-10">
      <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="text-center sm:text-left">
          <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
            Detalhes do Membro
          </h1>
          <p class="mt-1 text-sm sm:text-base text-indigo-100 opacity-90">
            Informações completas do membro selecionado
          </p>
        </div>
        <div>
          <Link
            href="/admin/members"
            class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-indigo-50 hover:text-indigo-800 transition-all duration-300"
          >
            Voltar
          </Link>
        </div>
      </div>
    </header>

    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8 animate-fade-in">
      <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div class="flex items-start">
            <span class="flex-shrink-0 w-8 h-8 text-gray-400">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </span>
            <div>
              <span class="block text-sm font-medium text-gray-700">Nome</span>
              <span class="block text-gray-900">{{ member.name }}</span>
            </div>
          </div>
          <div class="flex items-start">
            <span class="flex-shrink-0 w-8 h-8 text-gray-400">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
              </svg>
            </span>
            <div>
              <span class="block text-sm font-medium text-gray-700">E-mail</span>
              <span class="block text-gray-900">{{ member.email || 'Não informado' }}</span>
            </div>
          </div>
          <div class="flex items-start">
            <span class="flex-shrink-0 w-8 h-8 text-gray-400">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
            </span>
            <div>
              <span class="block text-sm font-medium text-gray-700">Telefone</span>
              <span class="block text-gray-900">{{ member.phone || 'Não informado' }}</span>
            </div>
          </div>
          <div class="flex items-start">
            <span class="flex-shrink-0 w-8 h-8 text-gray-400">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </span>
            <div>
              <span class="block text-sm font-medium text-gray-700">Data de Nascimento</span>
              <span class="block text-gray-900">{{ member.birth_date ? new Date(member.birth_date).toLocaleDateString('pt-BR') : 'Não informado' }}</span>
            </div>
          </div>
          <div class="flex items-start sm:col-span-2">
            <span class="flex-shrink-0 w-8 h-8 text-gray-400">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </span>
            <div>
              <span class="block text-sm font-medium text-gray-700">Endereço</span>
              <span class="block text-gray-900">
                {{ member.street ? `${member.street}, ${member.number || ''} ${member.complement || ''}, ${member.neighborhood || ''}, ${member.city || ''} - ${member.state || ''}, ${member.postal_code || ''}` : 'Não informado' }}
              </span>
            </div>
          </div>
          <div class="flex items-start">
            <span class="flex-shrink-0 w-8 h-8 text-gray-400">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </span>
            <div>
              <span class="block text-sm font-medium text-gray-700">Status</span>
              <span class="block" :class="member.active ? 'text-green-600' : 'text-red-600'">
                {{ member.active ? 'Ativo' : 'Inativo' }}
              </span>
            </div>
          </div>
          <div class="flex items-start">
            <span class="flex-shrink-0 w-8 h-8 text-gray-400">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </span>
            <div>
              <span class="block text-sm font-medium text-gray-700">Data de Registro</span>
              <span class="block text-gray-900">{{ member.registration_date ? new Date(member.registration_date).toLocaleDateString('pt-BR') : 'Não informado' }}</span>
            </div>
          </div>

          <div class="flex items-start">
            <span class="flex-shrink-0 w-8 h-8 text-gray-400">
              <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </span>
            <div>
              <span class="block text-sm font-medium text-gray-700">Plano</span>
              <span class="block text-gray-900">
                {{ member.plan ? `${member.plan.name} (R$ ${member.plan.price})` : 'Não vinculado' }}
              </span>
            </div>
          </div>
          </div>
      </div>

      <div class="mt-8 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
        <Link
          :href="`/admin/members/${member.id}/edit`"
          class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-4 py-2 rounded-lg shadow-md hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300"
        >
          Editar
        </Link>
        <button
          @click="confirm(() => router.delete(`/admin/members/${member.id}`))"
          class="flex-1 bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 rounded-lg shadow-md hover:from-red-700 hover:to-red-800 transition-all duration-300"
        >
          Excluir
        </button>
      </div>
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

button, a {
  transition: all 0.3s ease;
}
</style>