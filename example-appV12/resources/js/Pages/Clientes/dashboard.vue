<template>
  <AuthenticatedLayout>
      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard do Cliente</h2>
      </template>

      <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 text-gray-900">You're logged in!</div>

                  <div class="container mx-auto p-4">
                      <h1 class="text-3xl font-bold mb-4">Psicólogos Atendidos</h1>
                      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                          <ul class="divide-y divide-gray-200">
                              <li v-for="session in sessions" :key="session.id" class="px-4 py-4 hover:bg-gray-100">
                                  <div class="flex items-center justify-between">
                                      <div>
                                          <h2 class="text-lg leading-6 font-medium text-gray-900">{{ session.psychologist.name }}</h2>
                                          <p class="text-sm leading-5 text-gray-500">CRM: {{ session.psychologist.crm }}</p>
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
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Link } from '@inertiajs/vue3';

const { props } = usePage();
const sessions = ref(props.sessions);
</script>

<style scoped>
/* Adicione seu estilo personalizado aqui */
</style>
