<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
                <Link
                    :href="route('users.create')"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition focus:outline-none focus:ring"
                >
                    Adicionar Usuário
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>

                    <!-- Timeline Section -->
                    <div class="container mx-auto p-4 mb-8">
                        <h1 class="text-3xl font-bold mb-4">Agendamentos</h1>
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-4">
                            <ul class="divide-y divide-gray-200">
                                <li v-for="appointment in filteredAppointments" :key="appointment.id" class="px-4 py-4 hover:bg-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h2 class="text-lg leading-6 font-medium text-gray-900">{{ appointment.client.name }} - {{ appointment.psychologist.name }}</h2>
                                            <p class="text-sm leading-5 text-gray-500">Data: {{ new Date(appointment.session_date).toLocaleString() }}</p>
                                            <p class="text-sm leading-5 text-gray-500">Notas: {{ appointment.notes }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button @click="announceArrival(appointment.id)" class="ml-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                                Anunciar Chegada
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="container mx-auto p-4">
                        <h1 class="text-3xl font-bold mb-4">Clientes</h1>
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <ul class="divide-y divide-gray-200">
                                <li v-for="client in clients" :key="client.id" class="px-4 py-4 hover:bg-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h2 class="text-lg leading-6 font-medium text-gray-900">{{ client.name }}</h2>
                                            <p class="text-sm leading-5 text-gray-500">{{ client.role }}</p>
                                        </div>
                                        <div class="relative">
                                            <button @mouseenter="showDetails(client.id)" @mouseleave="hideDetails(client.id)" class="text-blue-500 hover:text-blue-700">
                                                Detalhes
                                            </button>
                                            <div v-if="client.showDetails" class="absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                                <div class="py-1">
                                                    <p class="text-sm leading-5 text-gray-700">Email: {{ client.email }}</p>
                                                    <p class="text-sm leading-5 text-gray-700">Telefone: {{ client.phone }}</p>
                                                </div>
                                            </div>
                                            <button @click="openAppointmentModal(client.id)" class="ml-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                                Marcar Consulta
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
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
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';

const { props } = usePage();
const clients = ref(props.clients);
const appointments = ref(props.sessions || []);

function showDetails(clientId) {
    const client = clients.value.find(c => c.id === clientId);
    if (client) {
        client.showDetails = true;
    }
}

function hideDetails(clientId) {
    const client = clients.value.find(c => c.id === clientId);
    if (client) {
        client.showDetails = false;
    }
}

const showAppointmentModal = ref(false);
const selectedClientId = ref(null);
const selectedPsychologist = ref(null);
const appointmentDate = ref('');
const appointmentTime = ref('');
const psychologists = ref([]);

async function fetchPsychologists() {
    try {
        const response = await axios.get(route('secretaria.psychologists'));
        psychologists.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

function openAppointmentModal(clientId) {
    selectedClientId.value = clientId;
    showAppointmentModal.value = true;
    fetchPsychologists();
}

function closeAppointmentModal() {
    showAppointmentModal.value = false;
    selectedClientId.value = null;
    selectedPsychologist.value = null;
    appointmentDate.value = '';
    appointmentTime.value = '';
}

async function markAppointment() {
    try {
        await axios.post(route('mark.appointment'), {
            client_id: selectedClientId.value,
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

async function announceArrival(sessionId) {
    try {
        await axios.post(route('announce.arrival'), { session_id: sessionId });
        alert('Chegada anunciada com sucesso.');
        await fetchAppointments();
        window.location.reload(); // Recarrega a página após finalizar a sessão

    } catch (error) {
        console.error('Erro ao anunciar a chegada: ', error);
        alert('Erro ao anunciar a chegada. Tente novamente.');
    }
}

async function fetchAppointments() {
    try {
        const response = await axios.get(route('secretaria.appointments'));
        appointments.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar agendamentos: ', error);
    }
}

const filteredAppointments = computed(() => {
    return appointments.value.filter(appointments => appointments.client_arrived == 0);
});
</script>
