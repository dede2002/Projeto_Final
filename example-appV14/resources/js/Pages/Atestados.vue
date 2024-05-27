<template>
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
    <div class="container mx-auto p-6">
      <h1 class="text-3xl font-bold mb-4">Buscar Detalhes da Sessão</h1>
      <div class="mb-4">
        <label for="session-id" class="block text-gray-700">ID da Sessão</label>
        <input
          id="session-id"
          v-model="sessionId"
          type="text"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          placeholder="Insira o ID da Sessão"
        />
      </div>
      <div class="mb-4">
        <button
          @click="fetchSessionDetails"
          class="px-4 py-2 bg-blue-500 text-white rounded-md"
        >
          Buscar
        </button>
      </div>
      <div v-if="sessionDetails" class="mt-6">
        <h2 class="text-2xl font-bold mb-2">Detalhes da Sessão</h2>
        <p><strong>Cliente:</strong> {{ sessionDetails.client.name }}</p>
        <p><strong>Médico:</strong> {{ sessionDetails.psychologist.name }}</p>
        <p><strong>Data:</strong> {{ sessionDetails.session_date }}</p>
      </div>
      <div v-if="error" class="mt-6 text-red-500">
        <p>{{ error }}</p>
      </div>
    </div>
  </template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';


const sessionId = ref('');
const sessionDetails = ref(null);
const error = ref('');

const fetchSessionDetails = async () => {
  try {
    error.value = '';
    const response = await axios.get(`/Atestados/${sessionId.value}`);
    sessionDetails.value = response.data;
  } catch (err) {
    sessionDetails.value = null;
    error.value = 'Erro ao buscar os detalhes da sessão. Verifique o ID e tente novamente.';
  }
};
</script>
