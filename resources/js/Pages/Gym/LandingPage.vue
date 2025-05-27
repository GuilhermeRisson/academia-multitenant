<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Define the props for logo_url and company_name
const props = defineProps({
  logo_url: {
    type: String,
    default: null,
  },
  company_name: {
    type: String,
    default: 'FitPower Gym',
  },
  plans: {
    type: Array,
    default: () => [],
  },
});

const form = useForm({
  name: '',
  email: '',
  message: '',
});

const isMenuOpen = ref(false);

function submitContact() {
  form.post('/contact', {
    onSuccess: () => form.reset(),
    onError: () => { },
  });
}

function toggleMenu() {
  isMenuOpen.value = !isMenuOpen.value;
}
</script>

<template>

  <Head :title="`Bem-vindo à ${company_name}`" />

  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-gray-50 to-gray-100 text-gray-900 font-inter">
    <!-- Header -->
    <header class="bg-gradient-to-r from-indigo-600 to-indigo-800 shadow-lg p-6 sticky top-0 z-20">
      <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center">
          <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100">
            <img v-if="logo_url" :src="logo_url" :alt="`${company_name} Logo`" class="h-12 w-12 object-cover" />
            <div v-else class="flex items-center justify-center w-full h-full text-gray-400">
              <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
          </div>
          <h1 class="text-2xl font-extrabold text-white ml-4">{{ company_name }}</h1>
        </div>
        <!-- Desktop Navigation -->
        <nav class="hidden md:flex space-x-6">
          <Link href="#classes" class="text-white hover:text-indigo-200 transition duration-300">Aulas</Link>
          <Link href="#plans" class="text-white hover:text-indigo-200 transition duration-300">Planos</Link>
          <Link href="#contact" class="text-white hover:text-indigo-200 transition duration-300">Contato</Link>
          <Link href="/admin/login"
            class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-semibold hover:bg-indigo-50 transition duration-300">
          Área do Admin
          </Link>
        </nav>
        <!-- Mobile Menu Button -->
        <button @click="toggleMenu" class="md:hidden text-white focus:outline-none">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              :d="isMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16m-7 6h7'" />
          </svg>
        </button>
      </div>
      <!-- Mobile Navigation -->
      <nav v-if="isMenuOpen" class="md:hidden mt-4 flex flex-col space-y-4 animate-fade-in">
        <Link href="#classes" @click="isMenuOpen = false" class="text-white hover:text-indigo-200">Aulas</Link>
        <Link href="#plans" @click="isMenuOpen = false" class="text-white hover:text-indigo-200">Planos</Link>
        <Link href="#contact" @click="isMenuOpen = false" class="text-white hover:text-indigo-200">Contato</Link>
        <Link href="/admin/login" @click="isMenuOpen = false"
          class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-semibold hover:bg-indigo-50 text-center">
        Área do Membro
        </Link>
      </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-indigo-600 to-indigo-800 text-white py-24 overflow-hidden">
      <div class="relative max-w-6xl mx-auto text-center px-6">
        <h2 class="text-4xl sm:text-5xl font-extrabold mb-4 animate-fade-in">Transforme Sua Vida na {{ company_name }}
        </h2>
        <p class="text-lg sm:text-xl max-w-2xl mx-auto mb-8 animate-fade-in delay-100">
          Junte-se à nossa comunidade e alcance seus objetivos com treinos personalizados, aulas dinâmicas e
          equipamentos de ponta.
        </p>
      </div>
    </section>

    <!-- Classes Section -->
    <section id="classes" class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-12 text-gray-800">Nossas Aulas</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
          <div
            class="group text-center p-6 bg-gray-50 rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
            <h4 class="text-xl font-semibold mb-2 text-indigo-600">Yoga</h4>
            <p class="text-gray-600">Relaxe e fortaleça seu corpo com nossas aulas de yoga guiadas por instrutores
              experientes.</p>
          </div>
          <div
            class="group text-center p-6 bg-gray-50 rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
            <h4 class="text-xl font-semibold mb-2 text-indigo-600">CrossFit</h4>
            <p class="text-gray-600">Desafie seus limites com treinos intensos e funcionais em grupo.</p>
          </div>
          <div
            class="group text-center p-6 bg-gray-50 rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
            <h4 class="text-xl font-semibold mb-2 text-indigo-600">Spinning</h4>
            <p class="text-gray-600">Pedale ao ritmo da música em nossas aulas energizantes de spinning.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Membership Plans Section -->
    <section id="plans" class="py-16 bg-gray-100">
      <div class="max-w-6xl mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-12 text-gray-800">Escolha Seu Plano</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
          <div v-for="plan in plans" :key="plan.id"
            class="group bg-white p-6 rounded-xl shadow-lg text-center transform hover:scale-105 transition duration-300"
            :class="{ 'border-2 border-indigo-600': plan.name.toLowerCase() === 'premium' }">
            <h4 class="text-xl font-semibold mb-2 text-indigo-600">{{ plan.name }}</h4>
            <p class="text-3xl font-bold mb-4 text-gray-800">R$ {{ Number(plan.price).toFixed(2) }}/mês</p>
            <ul class="text-left mb-6 text-gray-600">
              <li v-for="(feature, index) in plan.features" :key="index" class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ feature }}
              </li>
            </ul>
            <Link :href="`/admin/plans/${plan.id}/signup`"
              class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
            Escolher Plano
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6 text-center">
        <h3 class="text-3xl font-bold mb-8 text-gray-800">Entre em Contato</h3>
        <p class="text-lg mb-8 text-gray-600">Tem dúvidas ou quer agendar uma visita? Fale conosco!</p>
        <form @submit.prevent="submitContact" class="max-w-lg mx-auto space-y-4">
          <div class="relative">
            <input v-model="form.name" type="text" placeholder="Nome"
              class="w-full p-3 rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pl-10 transition duration-200"
              :class="{ 'border-red-500': form.errors.name }" />
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </span>
            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.name }}</div>
          </div>
          <div class="relative">
            <input v-model="form.email" type="email" placeholder="E-mail"
              class="w-full p-3 rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pl-10 transition duration-200"
              :class="{ 'border-red-500': form.errors.email }" />
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
              </svg>
            </span>
            <div v-if="form.errors.email" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.email }}
            </div>
          </div>
          <div class="relative">
            <textarea v-model="form.message" placeholder="Mensagem"
              class="w-full p-3 rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 h-32"
              :class="{ 'border-red-500': form.errors.message }"></textarea>
            <div v-if="form.errors.message" class="text-red-500 text-sm mt-1 animate-fade-in">{{ form.errors.message }}
            </div>
          </div>
          <button type="submit"
            class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-indigo-800 transition duration-300"
            :disabled="form.processing">
            {{ form.processing ? 'Enviando...' : 'Enviar' }}
          </button>
        </form>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-8">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <div class="flex justify-center space-x-6 mb-4">
          <a href="#" class="text-white hover:text-indigo-200">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96 0 4.41 3.58 8.06 8.23 8.85v-6.27h-2.48v-2.58h2.48v-1.97c0-2.45 1.49-3.78 3.67-3.78 1.04 0 1.94.08 2.2.11v2.55h-1.51c-1.18 0-1.41.56-1.41 1.38v1.81h2.82l-.37 2.58h-2.45v6.27c4.65-.79 8.23-4.44 8.23-8.85 0-5.5-4.46-9.96-9.96-9.96z" />
            </svg>
          </a>
          <a href="#" class="text-white hover:text-indigo-200">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M12 2C6.48 2 2 6.48 2 12c0 4.41 3.29 8.06 7.55 8.85v-6.27h-2.27v-2.58h2.27v-1.97c0-2.24 1.34-3.47 3.29-3.47.93 0 1.73.07 1.96.1v2.27h-1.34c-1.07 0-1.27.51-1.27 1.25v1.64h2.55l-.33 2.58h-2.22v6.27c4.26-.79 7.55-4.44 7.55-8.85 0-5.52-4.48-10-10-10z" />
            </svg>
          </a>
        </div>
        <p class="text-sm">© 2025 {{ company_name }}. Todos os direitos reservados.</p>
        <p class="text-sm mt-2">Powered by
          <Link href="/" class="underline text-indigo-200 hover:text-white">Gestão de Academias</Link>
        </p>
      </div>
    </footer>
  </div>
</template>

<style scoped>
.font-inter {
  font-family: 'Inter', sans-serif;
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

.animate-fade-in {
  animation: fadeIn 0.5s ease-out;
}

.delay-100 {
  animation-delay: 0.1s;
}

.delay-200 {
  animation-delay: 0.2s;
}

input,
textarea {
  transition: all 0.3s ease;
}

input:focus,
textarea:focus {
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
}

button,
a {
  transition: all 0.3s ease;
}
</style>