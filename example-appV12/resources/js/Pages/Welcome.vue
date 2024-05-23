<template>
    <div class="bg-white text-gray-900 min-h-screen">
      <!-- Header Section -->
      <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3 bg-white">
        <div class="flex lg:justify-start lg:col-start-1 pl-10 pr-10">
          <!-- Adicione o logo ou título aqui, se necessário -->
          <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" class="w-20 h-22">
            <image href="https://pasmars.com/wp-content/uploads/2024/05/Duhaclinica.svg" height="100%" width="100%"/>
          </svg>
        </div>
        <nav v-if="canLogin" class="flex justify-end lg:col-start-3 pr-10">
          <Link
            v-if="$page.props.auth.user"
            :href="getDashboardRoute($page.props.auth.user.role)"
            class="rounded-md px-3 py-2 text-white bg-[#20B2AA] ring-1 ring-transparent transition hover:bg-[#17a2a1] focus:outline-none focus-visible:ring-[#20B2AA] dark:text-white dark:hover:bg-[#17a2a1] dark:focus-visible:ring-white"
          >
            Dashboard
          </Link>
          <template v-else>
            <Link
              :href="route('login')"
              class="rounded-md px-3 py-2 text-white bg-[#20B2AA] ring-1 ring-transparent transition hover:bg-[#17a2a1] focus:outline-none focus-visible:ring-[#20B2AA] dark:text-white dark:hover:bg-[#17a2a1] dark:focus-visible:ring-white"
            >
              Log in
            </Link>
            <Link
              v-if="canRegister"
              :href="route('register')"
              class="rounded-md px-3 py-2 text-white bg-[#000000] ring-1 ring-transparent transition hover:bg-[#17a2a1] focus:outline-none focus-visible:ring-[#20B2AA] dark:text-white dark:hover:bg-[#17a2a1] dark:focus-visible:ring-white"
            >
              Register
            </Link>
          </template>
        </nav>
      </header>
  
      <!-- Main Content -->
      <main class="space-y-12 p-6">
        <!-- Descrição dos Serviços -->
        <section>
          <h2 class="text-3xl font-bold text-[#302E50] mb-4">Descrição dos Serviços</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </section>
  
        <!-- Sobre a Clínica -->
        <section>
          <h2 class="text-3xl font-bold text-[#302E50] mb-4">Sobre a Clínica</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </section>
  
        <!-- Depoimentos de Pacientes -->
        <section>
          <h2 class="text-3xl font-bold text-[#302E50] mb-4">Depoimentos de Pacientes</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </section>
  
        <div class="container mx-auto p-4">
          <h1 class="text-3xl font-bold mb-4">Adicionar Secretária</h1>
          <form @submit.prevent="submitSecretariaForm">
            <div class="mb-4">
              <label for="secretaria-name" class="block text-gray-700">Nome</label>
              <input id="secretaria-name" v-model="secretaria.name" type="text" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
              <label for="secretaria-email" class="block text-gray-700">Email</label>
              <input id="secretaria-email" v-model="secretaria.email" type="email" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
              <label for="secretaria-password" class="block text-gray-700">Senha</label>
              <input id="secretaria-password" v-model="secretaria.password" type="password" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
              <label for="secretaria-telefone" class="block text-gray-700">Telefone</label>
              <input id="secretaria-telefone" v-model="secretaria.telefone" type="text" class="mt-1 block w-full" required>
            </div>
            <div class="mt-4">
              <button type="submit" class="px-4 py-2 bg-blue-500 text-white">Adicionar Secretária</button>
            </div>
          </form>
        </div>
        
        <!-- Formulário de Contato -->
        <section>
          <h2 class="text-3xl font-bold text-[#302E50] mb-4">Formulário de Contato</h2>
          <form @submit.prevent="submitContactForm">
            <div class="mb-4">
              <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
            <input type="text" id="name" v-model="contactForm.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
          </div>
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" v-model="contactForm.email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
          </div>
          <div class="mb-4">
            <label for="message" class="block text-sm font-medium text-gray-700">Mensagem</label>
            <textarea id="message" v-model="contactForm.message" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required></textarea>
          </div>
          <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-[#FC486B] text-white rounded-md hover:bg-pink-600 transition focus:outline-none focus:ring">
              Enviar
            </button>
          </div>
        </form>
      </section>

      <!-- Informações de Contato -->
      <section>
        <h2 class="text-3xl font-bold text-[#302E50] mb-4">Informações de Contato</h2>
        <p><strong>Telefone:</strong> (99) 99999-9999</p>
        <p><strong>Email:</strong> contato@clinica.com</p>
        <p><strong>Endereço:</strong> Rua Exemplo, 123, Bairro Exemplo, Cidade Exemplo, Estado Exemplo</p>
      </section>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const { props } = usePage();

const contactForm = ref({
    name: '',
    email: '',
    message: ''
});

const submitContactForm = () => {
    // Implement the form submission logic here.
    alert('Formulário enviado com sucesso!');
};

const message = ref('');

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function getDashboardRoute(userRole) {
    switch (userRole) {
        case 'secretaria':
            return route('secretaria.dashboard');
        case 'psicologo':
            return route('psicologo.dashboard');
        case 'cliente':
            return route('cliente.dashboard');
        default:
            return route('login');
    }
}

const secretaria = ref({
    name: '',
    email: '',
    password: '',
    telefone: ''
});

const submitSecretariaForm = () => {
    const data = {
        name: secretaria.value.name,
        email: secretaria.value.email,
        password: secretaria.value.password,
        telefone: secretaria.value.telefone
    };

    fetch(route('secretarias.teste'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (response.ok) {
            alert('Secretária adicionada com sucesso!');
            window.location.href = '/secretaria/dashboard';
        } else {
            throw new Error('Erro ao adicionar secretária');
        }
    })
    .catch(error => {
        console.error(error);
    });
};

</script>
<style scoped>
/* Adicione seu estilo personalizado aqui */
</style>
