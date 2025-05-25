<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Bem-vindo à FitPower Gym" />

  <div class="min-h-screen bg-gray-100 text-gray-900">
    <!-- Header -->
    <header class="bg-white shadow p-6 flex justify-between items-center">
      <div class="flex items-center">
        <!-- Replace with gym logo -->
        <img src="/images/fitpower-logo.png" alt="FitPower Gym Logo" class="h-12 mr-4" />
        <h1 class="text-3xl font-bold text-indigo-600">FitPower Gym</h1>
      </div>
      <nav class="space-x-4">
        <Link href="#classes" class="text-indigo-600 hover:text-indigo-800">Aulas</Link>
        <Link href="#plans" class="text-indigo-600 hover:text-indigo-800">Planos</Link>
        <Link href="#contact" class="text-indigo-600 hover:text-indigo-800">Contato</Link>
        <Link href="/admin/login" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
          Área do Membro
        </Link>
      </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-indigo-600 to-blue-500 text-white py-24">
      <div class="absolute inset-0">
        <!-- Background image of gym interior -->
        <img src="/images/gym-hero.jpg" alt="Gym Interior" class="w-full h-full object-cover opacity-50" />
      </div>
      <div class="relative max-w-6xl mx-auto text-center px-6">
        <h2 class="text-5xl font-extrabold mb-4">Transforme Sua Vida na FitPower Gym</h2>
        <p class="text-xl max-w-2xl mx-auto mb-8">
          Junte-se à nossa comunidade e alcance seus objetivos com treinos personalizados, aulas dinâmicas e equipamentos de ponta.
        </p>
        <Link
          href="#trial"
          class="bg-white text-indigo-600 px-6 py-3 rounded-md font-semibold hover:bg-gray-100"
        >
          Experimente Grátis por 7 Dias
        </Link>
      </div>
    </section>

    <!-- Classes Section -->
    <section id="classes" class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-12">Nossas Aulas</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center p-6 bg-gray-50 rounded-lg shadow">
            <img src="/images/yoga-class.jpg" alt="Yoga" class="w-full h-48 object-cover rounded-md mb-4" />
            <h4 class="text-xl font-semibold mb-2">Yoga</h4>
            <p>Relaxe e fortaleça seu corpo com nossas aulas de yoga guiadas por instrutores experientes.</p>
          </div>
          <div class="text-center p-6 bg-gray-50 rounded-lg shadow">
            <img src="/images/crossfit-class.jpg" alt="CrossFit" class="w-full h-48 object-cover rounded-md mb-4" />
            <h4 class="text-xl font-semibold mb-2">CrossFit</h4>
            <p>Desafie seus limites com treinos intensos e funcionais em grupo.</p>
          </div>
          <div class="text-center p-6 bg-gray-50 rounded-lg shadow">
            <img src="/images/spinning-class.jpg" alt="Spinning" class="w-full h-48 object-cover rounded-md mb-4" />
            <h4 class="text-xl font-semibold mb-2">Spinning</h4>
            <p>Pedale ao ritmo da música em nossas aulas energizantes de spinning.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Membership Plans Section -->
    <section id="plans" class="py-16 bg-gray-100">
      <div class="max-w-6xl mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-12">Escolha Seu Plano</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white p-6 rounded-lg shadow text-center">
            <h4 class="text-xl font-semibold mb-2">Básico</h4>
            <p class="text-3xl font-bold mb-4">R$99/mês</p>
            <ul class="text-left mb-6">
              <li>✔ Acesso a equipamentos</li>
              <li>✔ Aulas em grupo</li>
            </ul>
            <Link href="#signup" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
              Escolher Plano
            </Link>
          </div>
          <div class="bg-white p-6 rounded-lg shadow text-center border-2 border-indigo-600">
            <h4 class="text-xl font-semibold mb-2">Premium</h4>
            <p class="text-3xl font-bold mb-4">R$149/mês</p>
            <ul class="text-left mb-6">
              <li>✔ Tudo do plano Básico</li>
              <li>✔ Personal trainer</li>
              <li>✔ Aulas exclusivas</li>
            </ul>
            <Link href="#signup" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
              Escolher Plano
            </Link>
          </div>
          <div class="bg-white p-6 rounded-lg shadow text-center">
            <h4 class="text-xl font-semibold mb-2">Familiar</h4>
            <p class="text-3xl font-bold mb-4">R$249/mês</p>
            <ul class="text-left mb-6">
              <li>✔ Até 3 membros</li>
              <li>✔ Tudo do plano Premium</li>
              <li>✔ Descontos em eventos</li>
            </ul>
            <Link href="#signup" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
              Escolher Plano
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6 text-center">
        <h3 class="text-3xl font-bold mb-8">Entre em Contato</h3>
        <p class="text-lg mb-8">Tem dúvidas ou quer agendar uma visita? Fale conosco!</p>
        <form class="max-w-lg mx-auto space-y-4">
          <input type="text" placeholder="Nome" class="w-full p-3 rounded-md border" />
          <input type="email" placeholder="E-mail" class="w-full p-3 rounded-md border" />
          <textarea placeholder="Mensagem" class="w-full p-3 rounded-md border h-32"></textarea>
          <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700">
            Enviar
          </button>
        </form>
      </div>
    </section>

    <!-- Footer -->
    <footer class="p-6 bg-gray-800 text-white text-center">
      <p>© 2025 FitPower Gym. Todos os direitos reservados.</p>
      <p class="text-sm mt-2">Powered by <Link href="/" class="underline">Gestão de Academias</Link></p>
    </footer>
  </div>
</template>

<style scoped>
/* Add custom styles if needed */
</style>