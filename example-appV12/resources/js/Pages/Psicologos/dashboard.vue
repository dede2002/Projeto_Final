<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard do Psicólogo</h2>
            <Link
                    :href="route('psicologos.documentos')"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition focus:outline-none focus:ring"
                >
                    Documentos
                </Link>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>

                    <div class="container mx-auto p-4">
                        <h1 class="text-3xl font-bold mb-4">Sessões</h1>

                        <!-- Chegou no consultório Section -->
                        <div v-if="highlightedSession" class="mb-6">
                            <h2 class="text-2xl font-semibold text-blue-600">Chegou no consultório</h2>
                            <div class="bg-yellow-100 shadow overflow-hidden sm:rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="text-lg leading-6 font-medium text-gray-900">{{ highlightedSession.client.name }}</h2>
                                        <p class="text-sm leading-5 text-gray-500">Data: {{ highlightedSession.session_date }}</p>
                                    </div>
                                    <div class="relative">
                                        <button @mouseenter="showDetails(highlightedSession.id)" @mouseleave="hideDetails(highlightedSession.id)" class="text-blue-500 hover:text-blue-700">
                                            Detalhes
                                        </button>
                                        <div v-if="highlightedSession.showDetails" class="absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                            <div class="py-1">
                                                <p class="text-sm leading-5 text-gray-700">Email: {{ highlightedSession.client.email }}</p>
                                                <p class="text-sm leading-5 text-gray-700">Telefone: {{ highlightedSession.client.phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <button @click="finishSession(highlightedSession.id)" class="mt-2 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition focus:outline-none focus:ring">
                                        Finalizar Consulta
                                    </button>
                                    <Link :href="route('sessions.edit', highlightedSession.id)" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 transition focus:outline-none focus:ring">
                                        Editar Ficha
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- Próximas sessões Section -->
                        <h2 class="text-2xl font-semibold mb-2">Clientes Futuros</h2>
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <ul class="divide-y divide-gray-200">
                                <li v-for="session in upcomingSessions" :key="session.id" class="px-4 py-4 hover:bg-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h2 class="text-lg leading-6 font-medium text-gray-900">{{ session.client.name }}</h2>
                                            <p class="text-sm leading-5 text-gray-500">Data: {{ session.session_date }}</p>
                                        </div>
                                        <div class="relative">
                                            <button @mouseenter="showDetails(session.id)" @mouseleave="hideDetails(session.id)" class="text-blue-500 hover:text-blue-700">
                                                Detalhes
                                            </button>
                                            <div v-if="session.showDetails" class="absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                                <div class="py-1">
                                                    <p class="text-sm leading-5 text-gray-700">Email: {{ session.client.email }}</p>
                                                    <p class="text-sm leading-5 text-gray-700">Telefone: {{ session.client.phone }}</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Sessões passadas Section -->
                        <h2 class="text-2xl font-semibold mb-2">Clientes Passados</h2>
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <ul class="divide-y divide-gray-200">
                                <li v-for="session in pastSessions" :key="session.id" class="px-4 py-4 hover:bg-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h2 class="text-lg leading-6 font-medium text-gray-900">{{ session.client.name }}</h2>
                                            <p class="text-sm leading-5 text-gray-500">Data: {{ session.session_date }}</p>
                                        </div>
                                        <div class="relative">
                                            <button @mouseenter="showDetails(session.id)" @mouseleave="hideDetails(session.id)" class="text-blue-500 hover:text-blue-700">
                                                Detalhes
                                            </button>
                                            <div v-if="session.showDetails" class="absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                                <div class="py-1">
                                                    <p class="text-sm leading-5 text-gray-700">Email: {{ session.client.email }}</p>
                                                    <p class="text-sm leading-5 text-gray-700">Telefone: {{ session.client.phone }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <Link :href="route('sessions.edit', session.id)" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 transition focus:outline-none focus:ring">
                                            Editar Ficha
                                        </Link>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Link } from '@inertiajs/vue3';

const { props } = usePage();
const sessions = ref(props.sessions);

const highlightedSession = computed(() => {
    return sessions.value.find(session => session.client_arrived === 1) || null;
});

const upcomingSessions = computed(() => {
    return sessions.value.filter(session => session.client_arrived === 0);
});

const pastSessions = computed(() => {
    return sessions.value.filter(session => session.client_arrived === 2);
});

function showDetails(sessionId) {
    const session = findSessionById(sessionId);
    if (session)
    {
        session.showDetails = true;
    }
}

function hideDetails(sessionId) {
    const session = findSessionById(sessionId);
    if (session) {
        session.showDetails = false;
    }
}

function findSessionById(sessionId) {
    return sessions.value.find(s => s.id === sessionId) ||
           (highlightedSession.value && highlightedSession.value.id === sessionId ? highlightedSession.value : null);
}

async function finishSession(sessionId) {
    try {
        const response = await axios.post(route('finish.session'), { session_id: sessionId });
        alert(response.data.message); // Exibe mensagem de sucesso
        window.location.reload(); // Recarrega a página após finalizar a sessão
    } catch (error) {
        console.error('Erro ao finalizar a sessão: ', error);
        alert('Erro ao finalizar a sessão. Tente novamente.');
    }
}


</script>

<style scoped>
/* Adicione seu estilo personalizado aqui */
</style>
