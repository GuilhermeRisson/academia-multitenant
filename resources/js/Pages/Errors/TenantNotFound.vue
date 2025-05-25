<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Academia não encontrada" />
  <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full text-center">
      <h1 class="text-3xl font-bold text-red-600 mb-4">Academia não encontrada</h1>
      <p class="text-gray-700 mb-6">
        O subdomínio informado não corresponde a nenhuma academia cadastrada.<br>
        Verifique o endereço e tente novamente.
      </p>
      <Link href="/" class="text-blue-600 hover:underline">Voltar para a página inicial</Link>
    </div>
  </div>
</template>
