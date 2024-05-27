<template>
  <div class="bg-white text-gray-900 min-h-screen flex flex-col justify-between">
    <!-- Header Section -->
    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3 bg-white">
      <div class="flex lg:justify-start lg:col-start-1 pl-10 pr-10">
        <!-- Logo Section -->
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
        </template>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-center space-y-12 p-6">
      <!-- Bem Vindo Section -->
      <section class="text-center">
        <h1 class="text-4xl font-bold text-[#302E50] mb-4">Bem vindo à nossa clínica!</h1>
        <div class="flex justify-center space-x-4">
          <button
            @click="navigateToAtestado"
            class="rounded-md px-4 py-2 text-white bg-[#FC486B] hover:bg-pink-600 transition focus:outline-none focus:ring"
          >
            Atestado
          </button>
          <button
            @click="scrollToSection('contato')"
            class="rounded-md px-4 py-2 text-white bg-[#FC486B] hover:bg-pink-600 transition focus:outline-none focus:ring"
          >
            Contato
          </button>
        </div>
      </section>

      <!-- Descrição dos Serviços (Hidden) -->
      <section class="hidden">
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

      <!-- Formulário de Contato -->
      <section id="contato">
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

    <!-- Footer Section -->
    <footer class="bg-gray-200 py-6">
      <div class="container mx-auto text-center">
        <Link
          v-if="canRegister"
          :href="route('register')"
          class="rounded-md px-3 py-2 text-white bg-[#000000] ring-1 ring-transparent transition hover:bg-[#17a2a1] focus:outline-none focus-visible:ring-[#20B2AA] dark:text-white dark:hover:bg-[#17a2a1] dark:focus-visible:ring-white"
        >
          Register
        </Link>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useForm, router } from '@inertiajs/vue3'; // Import useForm and router from inertia-vue3

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

const navigateToAtestado = () => {
  // Use Inertia to navigate to the "Atestados" page
  router.get(route('atestado')); // Use router from inertia-vue3 to navigate
};

const scrollToSection = (sectionId) => {
  const element = document.getElementById(sectionId);
  if (element) {
    element.scrollIntoView({ behavior: 'smooth' });
  }
};
</script>
<style scoped>
/* Adicione seu estilo personalizado aqui */
</style>
