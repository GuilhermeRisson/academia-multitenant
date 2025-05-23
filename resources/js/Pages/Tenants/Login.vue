<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

function submit() {
  form.post('/login', {
    onSuccess: () => form.reset('password'),
  });
}
</script>

<template>
  <Head title="Login Admin" />

  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
      <h1 class="text-2xl font-bold text-gray-800 mb-6">Login Admin</h1>

      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            :class="{ 'border-red-500': form.errors.email }"
            placeholder="Digite seu email"
          />
          <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            :class="{ 'border-red-500': form.errors.password }"
            placeholder="Digite sua senha"
          />
          <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</div>
        </div>

        <div class="flex items-center">
          <input
            id="remember"
            v-model="form.remember"
            type="checkbox"
            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
          />
          <label for="remember" class="ml-2 text-sm text-gray-600">Lembrar-me</label>
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 disabled:bg-gray-400"
          :disabled="form.processing"
        >
          {{ form.processing ? 'Entrando...' : 'Entrar' }}
        </button>
      </form>

      <div class="text-center mt-4">
        <Link href="/forgot-password" class="text-blue-600 hover:underline">Esqueceu sua senha?</Link>
      </div>
    </div>
  </div>
</template>