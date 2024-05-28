<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
                <button
                @click="openAppointmentModal" class="ml-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">                
                Marcar Consulta                
            </button>
            </div>
        </template>
  
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
  
                    <div class="container mx-auto p-4">
                        <h1 class="text-3xl font-bold mb-4">Psicólogos Atendidos</h1>
  
                        <!-- Sessões Futuras -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-semibold mb-4">Sessões Futuras</h2>
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                <ul class="divide-y divide-gray-200">
                                    <li v-for="session in futureSessions" :key="session.id" class="px-4 py-4 hover:bg-gray-100">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h2 class="text-lg leading-6 font-medium text-gray-900">{{ session.psychologist.name }}</h2>
                                                <p class="text-sm leading-5 text-gray-500">CRM: {{ session.psychologist.crm }}</p>
                                                <p class="text-sm leading-5 text-gray-500">Data: {{ session.session_date }}</p>
                                            </div>
                                            <div class="flex items-center">
                                                <button @click="cancelSession(session.id)" class="mt-2 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition focus:outline-none focus:ring">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
  
                        <!-- Sessões Passadas -->
                        <div>
                            <h2 class="text-2xl font-semibold mb-4">Sessões Passadas</h2>
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                <ul class="divide-y divide-gray-200">
                                    <li v-for="session in pastSessions" :key="session.id" class="px-4 py-4 hover:bg-gray-100">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h2 class="text-lg leading-6 font-medium text-gray-900">{{ session.psychologist.name }}</h2>
                                                <p class="text-sm leading-5 text-gray-500">CRM: {{ session.psychologist.crm }}</p>
                                                <p class="text-sm leading-5 text-gray-500">Data: {{ session.session_date }}</p>
                                            </div>
                                            <Link :href="route('sessions.notes', session.id)" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition focus:outline-none focus:ring">
                                                Ver Notas
                                            </Link>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
        <!-- Modal de Marcar Consulta -->
        <div v-if="showAppointmentModal" class="fixed z-10 inset-0 overflow-y-auto">
              <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                  <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                  </div>
                  <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                  <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                          <div class="sm:flex sm:items-start">
                              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                  <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Marcar Consulta</h3>
                                  <div class="mt-2">
                                      <p class="text-sm text-gray-500">Selecione um psicólogo e insira a data e hora da consulta.</p>
                                      <select v-model="selectedPsychologist" class="mt-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                          <option v-for="psychologist in psychologists" :key="psychologist.id" :value="psychologist.user.id">{{ psychologist.user.name }}</option>
                                      </select>
                                      <input v-model="appointmentDate" type="date" class="mt-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                                      <input v-model="appointmentTime" type="time" class="mt-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                          <button @click="markAppointment" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                              Marcar
                          </button>
                          <button @click="closeAppointmentModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                              Cancelar
                          </button>
                      </div>
                  </div>
              </div>
          </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { usePage, Link } from '@inertiajs/vue3';
  import axios from 'axios';
  
  const { props } = usePage();
  const sessions = ref(props.sessions);
  const futureSessions = ref([]);
  const pastSessions = ref([]);
  const showAppointmentModal = ref(false);
  const selectedPsychologist = ref(null);
  const appointmentDate = ref('');
  const appointmentTime = ref('');
  const psychologists = ref([]);
  
  // Pega o cliente logado dos props
  const loggedClientId = props.auth.user.id;
  
  // Filtra as sessões em futuras e passadas
  futureSessions.value = sessions.value.filter(session => session.client_arrived === 0);
  pastSessions.value = sessions.value.filter(session => session.client_arrived === 2);
  
  async function fetchPsychologists() {
      try {
          const response = await axios.get(route('secretaria.psychologists'));
          psychologists.value = response.data;
      } catch (error) {
          console.error(error);
      }
  }
  
  function openAppointmentModal() {
      showAppointmentModal.value = true;
      fetchPsychologists();
  }
  
  function closeAppointmentModal() {
      showAppointmentModal.value = false;
      selectedPsychologist.value = null;
      appointmentDate.value = '';
      appointmentTime.value = '';
  }
  
  async function markAppointment() {
      try {
          await axios.post(route('mark.appointment'), {
              client_id: loggedClientId, // Usa o ID do cliente logado
              psychologist_id: selectedPsychologist.value,
              session_date: appointmentDate.value,
              session_time: appointmentTime.value
          });
          alert('Consulta marcada com sucesso.');
          closeAppointmentModal();
          await fetchAppointments();
          window.location.reload(); // Recarrega a página após finalizar a sessão
  
      } catch (error) {
          console.error('Erro ao marcar a consulta: ', error);
          alert('Erro ao marcar a consulta. Tente novamente.');
      }
  }
  
  async function cancelSession(sessionId) {
      try {
          await axios.delete(`/sessions/${sessionId}`);
          futureSessions.value = futureSessions.value.filter(session => session.id !== sessionId);
          alert('Sessão cancelada com sucesso.');
      } catch (error) {
          console.error('Erro ao cancelar a sessão: ', error);
          alert('Erro ao cancelar a sessão. Tente novamente.');
      }
  }
  
  </script>
  
  <style scoped>
  /* Adicione seu estilo personalizado aqui */
  </style>
  