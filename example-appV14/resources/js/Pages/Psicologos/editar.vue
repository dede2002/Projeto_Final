<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Editando dados de: {{ session.client.name }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <!-- Informações do Paciente -->
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold mb-2">Informações do Paciente</h3>
                            <p><strong>Nome:</strong> {{ session.client.name }}</p>
                            <p><strong>Email:</strong> {{ session.client.email }}</p>
                            <p><strong>Telefone:</strong> {{ session.client.telefone }}</p>
                            <p><strong>CEP:</strong> {{ session.client.cep }}</p>
                            <p><strong>Logradouro:</strong> {{ session.client.logradouro }}</p>
                            <p><strong>Bairro:</strong> {{ session.client.bairro }}</p>
                            <p><strong>Cidade:</strong> {{ session.client.cidade }}</p>
                            <p><strong>Estado:</strong> {{ session.client.estado }}</p>
                        </div>

                        <!-- Formulário de Edição da Sessão -->
                        <form @submit.prevent="updateSession">
                            <div class="mb-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notas da Sessão</label>
                                <textarea id="notes" v-model="form.notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="restricted_info" class="block text-sm font-medium text-gray-700">Informações Restritas</label>
                                <textarea id="restricted_info" v-model="form.restricted_info" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition focus:outline-none focus:ring">
                                    Atualizar Sessão
                                </button>
                            </div>
                        </form>

                        <!-- Formulário de Geração de Documentos -->
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold mb-2">Gerar Documento</h3>
                            <form @submit.prevent="generateDocument">
                                <div class="mb-4">
                                    <label for="documentNotes" class="block text-sm font-medium text-gray-700">Notas Adicionais</label>
                                    <textarea id="documentNotes" v-model="documentNotes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                </div>
                                <div class="flex justify-end mb-4">
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 transition focus:outline-none focus:ring">
                                        Gerar Documento
                                    </button>
                                </div>
                            </form>
                            <div v-if="generatedDocument" class="bg-white shadow overflow-hidden sm:rounded-lg p-4">
                                <h3 class="text-xl font-semibold mb-2">Documento Gerado</h3>
                                <p v-html="generatedDocument"></p>
                            </div>
                        </div>

                        <!-- Sessões Anteriores -->
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold mb-2">Sessões Anteriores</h3>
                            <ul class="divide-y divide-gray-200">
                                <li v-for="pastSession in pastSessions" :key="pastSession.id" class="py-4">
                                    <div class="flex justify-between">
                                        <div>
                                            <p><strong>Data:</strong> {{ new Date(pastSession.session_date).toLocaleString() }}</p>
                                            <p><strong>Notas:</strong> {{ pastSession.notes }}</p>
                                            <p><strong>Informações Restritas:</strong> {{ pastSession.restricted_info }}</p>
                                        </div>
                                        <Link :href="route('sessions.edit', pastSession.id)" class="text-blue-500 hover:text-blue-700">
                                            Editar
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
import { ref, reactive, computed } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Link } from '@inertiajs/vue3';

const { props } = usePage();
const session = ref(props.session);
const client = ref(props.client);
const sessions = ref(props.sessions || []);
const form = reactive({
    notes: session.value.notes || '',
    restricted_info: session.value.restricted_info || '',
});

const documentNotes = ref('');
const generatedDocument = ref('');
const userName = ref(props.auth.user.name);

const documentTemplate = `
    <p>Eu, Dr(a). <strong>${userName.value}</strong>, atesto que o(a) paciente <strong>${session.value.client.name}</strong> compareceu à sessão em nossa clínica.</p>
    <p>Notas da sessão:</p>
    <p>{{documentNotes}}</p>
`;

const pastSessions = computed(() => {
    return sessions.value.filter(session => session.client_arrived === 2 && session.client_id === client.value.id);
});

const updateSession = () => {
    axios.patch(route('sessions.update', session.value.id), form)
        .then(response => {
            alert('Sessão atualizada com sucesso.');
            window.location = route('psicologo.dashboard');
        })
        .catch(error => {
            console.error(error);
            alert('Erro ao atualizar sessão.');
        });
};

const generateDocument = () => {
    generatedDocument.value = documentTemplate
        .replace('{{documentNotes}}', documentNotes.value);
};
</script>

<style scoped>
/* Adicione seu estilo personalizado aqui */
</style>
