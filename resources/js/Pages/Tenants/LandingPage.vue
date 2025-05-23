<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Bem-vindo à Gestão de Academias" />

  <div class="min-h-screen bg-gradient-to-br from-blue-500 to-indigo-600 text-white">
    <!-- Header -->
    <header class="p-6 flex justify-between items-center">
      <h1 class="text-3xl font-bold">Gestão de Academias</h1>
      <div>
        <Link href="/login" class="bg-white text-blue-600 px-4 py-2 rounded-md hover:bg-gray-100">
          Login
        </Link>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="flex flex-col items-center justify-center text-center py-20">
      <h2 class="text-5xl font-extrabold mb-4">Gerencie suas academias com facilidade</h2>
      <p class="text-lg max-w-2xl mb-8">
        Nossa plataforma permite que você crie, edite e gerencie academias de forma eficiente, com total controle e segurança.
      </p>

    </section>

    <!-- Features Section -->
    <section class="bg-white text-gray-800 py-16">
      <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-6">
        <div class="text-center">
          <h3 class="text-xl font-semibold mb-2">Gestão Simplificada</h3>
          <p>Crie e edite academias com poucos cliques.</p>
        </div>
        <div class="text-center">
          <h3 class="text-xl font-semibold mb-2">Controle Total</h3>
          <p>Gerencie usuários, domínios e permissões.</p>
        </div>
        <div class="text-center">
          <h3 class="text-xl font-semibold mb-2">Segurança</h3>
          <p>Dados protegidos com tecnologia de ponta.</p>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="p-6 text-center">
      <p>&copy; 2025 Gestão de Academias. Todos os direitos reservados.</p>
    </footer>
  </div>
</template>