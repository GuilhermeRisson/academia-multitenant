<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Academia desativada" />
  <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full text-center">
      <h1 class="text-3xl font-bold text-yellow-600 mb-4">Academia desativada</h1>
      <p class="text-gray-700 mb-6">
        Esta academia está temporariamente desativada.<br>
        Entre em contato com o suporte para mais informações.
      </p>
      <Link href="/" class="text-blue-600 hover:underline">Voltar para a página inicial</Link>
    </div>
  </div>
</template>
