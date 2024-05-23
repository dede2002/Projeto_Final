<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notas da Sessão</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <div class="p-6 text-gray-900">You're logged in!</div>
                    <div class="mb-4">
                                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                                    <p class="font-bold">Atestado Médico</p>
                                    <p>{{ session.client.name }} teve uma sessão com {{ session.psychologist.name }} às {{ session.session_date }} - id da sessão: {{  session.id }}</p>
                                </div>
                            </div>
                    <div class="container mx-auto p-4">
                        <h1 class="text-3xl font-bold mb-4">Notas da Sessão</h1>
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-4">

                            <div>
                                <h2 class="text-lg leading-6 font-medium text-gray-900">{{ session.psychologist.name }}</h2>
                                <p class="text-sm leading-5 text-gray-500">CRM: {{ session.psychologist.crm }}</p>
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Notas:</h3>
                                <p class="text-sm leading-5 text-gray-700">{{ session.notes }}</p>
                            </div>
                            <Link :href="route('cliente.dashboard')" class="mt-20 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition focus:outline-none focus:ring">
                                Voltar
                            </Link>
                        </div>
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

const { props } = usePage();
const session = ref(props.session);
</script>

<style scoped>
/* Adicione seu estilo personalizado aqui */
</style>
