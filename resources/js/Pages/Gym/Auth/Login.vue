<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

function submit() {
  form.post('/admin/login', {
    onSuccess: () => form.reset('password'),
    onError: () => {
      console.log(form.errors);
    },
  });
}
</script>

<template>
  <Head title="Login Administrador - Tenant" />

  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-200 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full">
      <!-- Logotipo ou Ícone -->
      <div class="flex justify-center mb-6">
        <img src="/logo-tenant.png" alt="Logotipo Tenant" class="h-12 w-auto" />
      </div>

      <!-- Título e Contexto -->
      <h1 class="text-3xl font-bold text-gray-900 text-center">Painel Administrativo</h1>
      <p class="text-gray-600 text-center mt-2 mb-6">Acesse o sistema de gerenciamento da sua tenant</p>

      <!-- Formulário -->
      <form @submit.prevent="submit" class="space-y-6">
        <!-- Campo Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            autocomplete="email"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
            :class="{ 'border-red-500 ring-1 ring-red-500': form.errors.email }"
            placeholder="admin@tenant.com"
            aria-describedby="email-error"
          />
          <div v-if="form.errors.email" id="email-error" class="text-red-500 text-sm mt-1 animate-pulse">
            {{ form.errors.email }}
          </div>
        </div>

        <!-- Campo Senha -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            autocomplete="current-password"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
            :class="{ 'border-red-500 ring-1 ring-red-500': form.errors.password }"
            placeholder="••••••••"
            aria-describedby="password-error"
          />
          <div v-if="form.errors.password" id="password-error" class="text-red-500 text-sm mt-1 animate-pulse">
            {{ form.errors.password }}
          </div>
        </div>

        <!-- Lembrar-me -->
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input
              id="remember"
              v-model="form.remember"
              type="checkbox"
              class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
              aria-label="Lembrar-me"
            />
            <label for="remember" class="ml-2 text-sm text-gray-600">Lembrar-me</label>
          </div>
          <Link
            href="/forgot-password"
            class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline"
            aria-label="Esqueceu sua senha?"
          >
            Esqueceu sua senha?
          </Link>
        </div>

        <!-- Botão de Submit -->
        <button
          type="submit"
          class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out transform disabled:bg-gray-400 disabled:cursor-not-allowed"
          :disabled="form.processing"
        >
          <span v-if="form.processing" class="flex items-center justify-center">
            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Entrando...
          </span>
          <span v-else>Entrar</span>
        </button>
      </form>

      <!-- Rodapé -->
      <div class="text-center mt-6 text-sm text-gray-500">
        Sistema de Gerenciamento de Tenants | © {{ new Date().getFullYear() }}
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Adiciona uma animação suave para o formulário */
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