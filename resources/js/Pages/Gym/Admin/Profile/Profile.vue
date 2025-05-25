<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
  tenant_details: {
    type: Array,
    required: true,
    default: () => [],
  },
});

// Compute the first tenant detail, or null if none exists
const tenant = computed(() => props.tenant_details[0] || null);

// Format CNPJ and postal code for display
const formattedCnpj = computed(() => {
  if (!tenant.value?.cnpj) return '-';
  const cnpj = tenant.value.cnpj.replace(/\D/g, '');
  return cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
});

const formattedPostalCode = computed(() => {
  if (!tenant.value?.postal_code) return '-';
  const postal = tenant.value.postal_code.replace(/\D/g, '');
  return postal.replace(/(\d{5})(\d{3})/, '$1-$2');
});

// Construct full domain
const fullDomain = computed(() => {
  if (!tenant.value?.domain) return '-';
  return `${tenant.value.domain}.${import.meta.env.VITE_TENANCY_CENTRAL_DOMAIN || 'example.com'}`;
});

// Logo upload form
const form = useForm({
  logo: null,
});
const isUploading = ref(false);

const handleFileChange = (event) => {
  form.logo = event.target.files[0] || null;
};

const submitLogo = () => {
  if (!form.logo) return; 

  isUploading.value = true;
  
  form.post('/admin/tenants/logo', { 
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => {
      form.reset('logo');
      isUploading.value = false;

      if (tenant.value) {
        tenant.value.logo_url = `${tenant.value.logo_url}?${new Date().getTime()}`;
      }
    },
    onError: (errors) => {
      isUploading.value = false;
      alert('Erro ao atualizar o logo: ' + (errors.logo || 'Tente novamente.'));
    }
  });
};
</script>

<template>
  <Head title="Perfil da Academia - Gestão" />

  <AuthenticatedLayout>
    <template #header>
      <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl shadow-xl p-6 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
          <div class="text-center sm:text-left">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
              Perfil da Academia
            </h1>
            <p class="mt-1 text-sm sm:text-base text-indigo-100 opacity-90">
              Informações gerais da academia
            </p>
          </div>
          <div>
            <Link
              href="/admin/dashboard"
              class="inline-flex items-center px-4 py-2 bg-white rounded-lg shadow-md text-indigo-600 font-semibold hover:bg-indigo-50 hover:text-indigo-800 transition-all duration-300"
            >
              <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Voltar
            </Link>
          </div>
        </div>
      </div>
    </template>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-gray-50 to-gray-100 font-inter">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div v-if="tenant" class="bg-white rounded-xl shadow-lg p-8 animate-fade-in">
          <!-- Logo Section -->
          <div class="mb-8 text-center">
            <div class="inline-block w-32 h-32 rounded-full overflow-hidden bg-gray-100 border-4 border-indigo-200">
              <img
                v-if="tenant.logo_url"
                :src="tenant.logo_url"
                alt="Logo da Academia"
                aria-label="Logo da Academia"
                class="w-full h-full object-cover"
              />
              <div v-else class="flex items-center justify-center w-full h-full text-gray-400">
                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
            <h2 class="mt-4 text-xl font-semibold text-gray-800">{{ tenant.name || 'Sem Nome' }}</h2>
          </div>

          <!-- Logo Upload Form -->
          <div class="mt-6">
            <form @submit.prevent="submitLogo">
              <label class="block text-sm font-medium text-gray-600 mb-1">Alterar Logo</label>
              <input
                type="file"
                accept="image/*"
                @change="handleFileChange"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
              <button
                type="submit"
                class="mt-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white px-4 py-2 rounded-lg shadow-md transition-all duration-300"
                :disabled="isUploading || !form.logo"
              >
                {{ isUploading ? 'Enviando...' : 'Salvar Logo' }}
              </button>
            </form>
          </div>

          <!-- General Information -->
          <div class="space-y-6 mt-8">
            <h3 class="text-lg font-semibold text-gray-800 border-b border-indigo-200 pb-2">
              Informações Gerais
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-600">Nome</label>
                <p class="mt-1 text-gray-900">{{ tenant.name || '-' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">Email</label>
                <p class="mt-1 text-gray-900">{{ tenant.email || '-' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">CNPJ</label>
                <p class="mt-1 text-gray-900">{{ formattedCnpj }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">Domínio</label>
                <p class="mt-1 text-gray-900">{{ fullDomain }}</p>
              </div>
            </div>
          </div>

          <!-- Address Information -->
          <div class="space-y-6 mt-8">
            <h3 class="text-lg font-semibold text-gray-800 border-b border-indigo-200 pb-2">
              Endereço
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-600">Rua</label>
                <p class="mt-1 text-gray-900">{{ tenant.street || '-' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">Número</label>
                <p class="mt-1 text-gray-900">{{ tenant.number || '-' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">Complemento</label>
                <p class="mt-1 text-gray-900">{{ tenant.complement || '-' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">Cidade</label>
                <p class="mt-1 text-gray-900">{{ tenant.city || '-' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">Estado</label>
                <p class="mt-1 text-gray-900">{{ tenant.state || '-' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">CEP</label>
                <p class="mt-1 text-gray-900">{{ formattedPostalCode }}</p>
              </div>
            </div>
          </div>

          <!-- Back Button -->
          <div class="mt-8 flex justify-end">
            <Link
              href="/admin/dashboard"
              class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-2 rounded-lg shadow-md hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300 flex items-center"
            >
              <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Voltar ao Dashboard
            </Link>
          </div>
        </div>
        <div v-else class="bg-white rounded-xl shadow-lg p-8 animate-fade-in text-center">
          <p class="text-gray-500 text-lg">Nenhuma informação de academia encontrada.</p>
          <Link
            href="/admin/dashboard"
            class="mt-4 inline-flex items-center px-6 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-lg shadow-md hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300"
          >
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
            Voltar ao Dashboard
          </Link>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.font-inter {
  font-family: 'Inter', sans-serif;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fadeIn 0.5s ease-out;
}

button, a {
  transition: all 0.3s ease;
}

input[type="file"] {
  transition: all 0.3s ease;
}
</style>