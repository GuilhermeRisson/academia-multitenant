<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { mask } from 'vue-the-mask';

const props = defineProps({
    tenant: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.tenant.name || '',
    email: props.tenant.email || '',
    domain: props.tenant.domain || '',
    cnpj: props.tenant.cnpj || '',
    street: props.tenant.street || '',
    number: props.tenant.number || '',
    complement: props.tenant.complement || '',
    city: props.tenant.city || '',
    state: props.tenant.state || '',
    postal_code: props.tenant.postal_code || '',
});

// Converter nome para formato de domínio
const toDomainFormat = (name) => {
    return name
        .toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Remove acentos
        .replace(/[^a-z0-9-]/g, '-') // Substitui caracteres inválidos por hífen
        .replace(/-+/g, '-') // Remove hífens consecutivos
        .replace(/^-|-$/g, ''); // Remove hífens do início e fim
};

// Atualizar domínio quando o nome mudar
watch(() => form.name, (newName) => {
    form.domain = toDomainFormat(newName);
}, { immediate: true });

function submit() {
    form.put(`/tenants/${props.tenant.id}`, {
        onSuccess: () => {
            // Optionally redirect to dashboard or show success message
        },
    });
}

function resetForm() {
    if (confirm('Tem certeza que deseja limpar o formulário? Todas as alterações não salvas serão perdidas.')) {
        form.reset();
        // Restaurar o domínio baseado no nome após reset
        form.domain = toDomainFormat(form.name);
    }
}
</script>

<template>

    <Head title="Editar Tenant - Gestão de Academias" />

    <div
        class="min-h-screen bg-gradient-to-br from-indigo-50 via-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8 font-inter">
        <!-- Header -->
        <header class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl shadow-xl p-6 mb-8 sticky top-0 z-10">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-center sm:text-left">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        Editar Tenant
                    </h1>
                    <p class="mt-1 text-sm sm:text-base text-indigo-100 opacity-90">
                        Atualize as informações da academia
                    </p>
                </div>
                <div>
                    <Link href="/dashboard"
                        class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg shadow-md hover:bg-indigo-50 hover:text-indigo-800 transition-all duration-300">
                    Voltar
                    </Link>
                </div>
            </div>
        </header>

        <!-- Form -->
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8 animate-fade-in">
            <form @submit.prevent="submit" class="space-y-8">
                <!-- General Information -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-800">Informações Gerais</h2>

                    <div class="relative">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                        <div class="mt-1 relative">
                            <input id="name" v-model="form.name"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 pl-10"
                                :class="{ 'border-red-500': form.errors.name }" placeholder="Digite o nome do tenant" />
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </span>
                        </div>
                        <div v-if="form.errors.name"
                            class="text-red-500 text-sm mt-1 flex items-center animate-fade-in">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <div class="relative">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="mt-1 relative">
                            <input id="email" v-model="form.email" type="email"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 pl-10"
                                :class="{ 'border-red-500': form.errors.email }" placeholder="Digite o email" />
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                                </svg>
                            </span>
                        </div>
                        <div v-if="form.errors.email"
                            class="text-red-500 text-sm mt-1 flex items-center animate-fade-in">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <div class="relative">
                        <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ</label>
                        <div class="mt-1 relative">
                            <input id="cnpj" v-model="form.cnpj" v-mask="'##.###.###/####-##'"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 pl-10"
                                :class="{ 'border-red-500': form.errors.cnpj }" placeholder="12.345.678/0001-90" />
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </span>
                        </div>
                        <div v-if="form.errors.cnpj"
                            class="text-red-500 text-sm mt-1 flex items-center animate-fade-in">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ form.errors.cnpj }}
                        </div>
                    </div>

                    <div class="relative">
                        <label for="domain" class="block text-sm font-medium text-gray-700">Domínio</label>
                        <div class="mt-1 relative">
                            <input id="domain" v-model="form.domain"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 pl-10 bg-gray-100 cursor-not-allowed"
                                :readonly="true" placeholder="Gerado automaticamente" />
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Domínio completo: <span class="font-mono">{{ form.domain || 'exemplo'
                                }}.seusistema.com</span>
                        </p>
                        <div v-if="form.errors.domain"
                            class="text-red-500 text-sm mt-1 flex items-center animate-fade-in">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ form.errors.domain }}
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800">Endereço</h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="relative">
                                <label for="street" class="block text-sm font-medium text-gray-700">Rua</label>
                                <input id="street" v-model="form.street"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                    :class="{ 'border-red-500': form.errors.street }" placeholder="Digite a rua" />
                                <div v-if="form.errors.street"
                                    class="text-red-500 text-sm mt-1 flex items-center animate-fade-in">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ form.errors.street }}
                                </div>
                            </div>

                            <div class="relative">
                                <label for="number" class="block text-sm font-medium text-gray-700">Número</label>
                                <input id="number" v-model="form.number"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                    :class="{ 'border-red-500': form.errors.number }" placeholder="Digite o número" />
                                <div v-if="form.errors.number"
                                    class="text-red-500 text-sm mt-1 flex items-center animate-fade-in">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ form.errors.number }}
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <label for="complement" class="block text-sm font-medium text-gray-700">Complemento</label>
                            <input id="complement" v-model="form.complement"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                :class="{ 'border-red-500': form.errors.complement }"
                                placeholder="Digite o complemento (opcional)" />
                            <div v-if="form.errors.complement"
                                class="text-red-500 text-sm mt-1 flex items-center animate-fade-in">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ form.errors.complement }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="relative">
                                <label for="city" class="block text-sm font-medium text-gray-700">Cidade</label>
                                <input id="city" v-model="form.city"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                    :class="{ 'border-red-500': form.errors.city }" placeholder="Digite a cidade" />
                                <div v-if="form.errors.city"
                                    class="text-red-500 text-sm mt-1 flex items-center animate-fade-in">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ form.errors.city }}
                                </div>
                            </div>

                            <div class="relative">
                                <label for="state" class="block text-sm font-medium text-gray-700">Estado</label>
                                <input id="state" v-model="form.state"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                    :class="{ 'border-red-500': form.errors.state }"
                                    placeholder="Digite o estado (ex: SP)" maxlength="2" />
                                <div v-if="form.errors.state"
                                    class="text-red-500 text-sm mt-1 flex items-center animate-fade-in">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ form.errors.state }}
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">CEP</label>
                            <div class="mt-1 relative">
                                <input id="postal_code" v-model="form.postal_code" v-mask="'#####-###'"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 pl-10"
                                    :class="{ 'border-red-500': form.errors.postal_code }" placeholder="12345-678" />
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div v-if="form.errors.postal_code"
                                class="text-red-500 text-sm mt-1 flex items-center animate-fade-in">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ form.errors.postal_code }}
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <div class="flex space-x-4">
                            <Link href="/dashboard" class="text-indigo-600 hover:text-indigo-800 flex items-center">
                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Voltar
                            </Link>
                            <button type="button" @click="resetForm"
                                class="text-gray-600 hover:text-gray-800 flex items-center">
                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Limpar
                            </button>
                        </div>
                        <button type="submit"
                            class="w-full sm:w-auto bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-2 rounded-lg shadow-md hover:from-indigo-700 hover:to-indigo-800 disabled:bg-gray-400 transition-all duration-300 flex items-center justify-center"
                            :disabled="form.processing">
                            <svg v-if="form.processing" class="animate-spin h-5 w-5 mr-2 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            {{ form.processing ? 'Salvando...' : 'Salvar' }}
                        </button>
                    </div>
            </form>
        </div>
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

input:focus {
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
}

button,
a {
    transition: all 0.3s ease;
}
</style>