<template>
    <AuthenticatedLayout>
      
      <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard do Psicólogo</h2>
      </template>

      <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Adicionar Usuário</h1>
        <div class="tabs mb-4 flex space-x-4">
          <button @click="activeTab = 'cliente'" :class="{'active': activeTab === 'cliente'}" class="tab px-4 py-2">Cliente</button>
          <button @click="activeTab = 'psicologo'" :class="{'active': activeTab === 'psicologo'}" class="tab px-4 py-2">Psicólogo</button>
          <button @click="activeTab = 'secretaria'" :class="{'active': activeTab === 'secretaria'}" class="tab px-4 py-2">Secretária</button>
        </div>

        <form v-if="activeTab === 'cliente'" @submit.prevent="submitClientForm">
          <div class="mb-4">
            <label for="client-name" class="block text-gray-700">Nome</label>
            <input id="client-name" v-model="client.name" type="text" class="mt-1 block w-full" required>
          </div>
          <div class="mb-4">
            <label for="client-email" class="block text-gray-700">Email</label>
            <input id="client-email" v-model="client.email" type="email" class="mt-1 block w-full" required>
          </div>
          <div class="mb-4">
            <label for="client-password" class="block text-gray-700">Senha</label>
            <input id="client-password" v-model="client.password" type="password" class="mt-1 block w-full" required>
          </div>
          <div class="mb-4">
            <label for="client-cep" class="block text-gray-700">CEP</label>
            <input id="client-cep" v-model="client.cep" @blur="fetchAddress" type="text" class="mt-1 block w-full" required>
          </div>
          <div class="mb-4">
            <label for="client-logradouro" class="block text-gray-700">Logradouro</label>
            <input id="client-logradouro" v-model="client.logradouro" type="text" class="mt-1 block w-full" readonly>
          </div>
          <div class="mb-4">
            <label for="client-bairro" class="block text-gray-700">Bairro</label>
            <input id="client-bairro" v-model="client.bairro" type="text" class="mt-1 block w-full" readonly>
          </div>
          <div class="mb-4">
            <label for="client-cidade" class="block text-gray-700">Cidade</label>
            <input id="client-cidade" v-model="client.cidade" type="text" class="mt-1 block w-full" readonly>
          </div>
          <div class="mb-4">
            <label for="client-estado" class="block text-gray-700">Estado</label>
            <input id="client-estado" v-model="client.estado" type="text" class="mt-1 block w-full" readonly>
          </div>
          <div class="mb-4">
            <label for="client-telefone" class="block text-gray-700">Telefone</label>
            <input id="client-telefone" v-model="client.telefone" type="text" class="mt-1 block w-full" required>
          </div>
          <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white">Adicionar Cliente</button>
          </div>
        </form>

        <form v-if="activeTab === 'psicologo'" @submit.prevent="submitPsicologoForm">
          <div class="mb-4">
            <label for="psicologo-name" class="block text-gray-700">Nome</label>
            <input id="psicologo-name" v-model="psicologo.name" type="text" class="mt-1 block w-full" required>
          </div>
          <div class="mb-4">
            <label for="psicologo-email" class="block text-gray-700">Email</label>
            <input id="psicologo-email" v-model="psicologo.email" type="email" class="mt-1 block w-full" required>
          </div>
          <div class="mb-4">
            <label for="psicologo-password" class="block text-gray-700">Senha</label>
            <input id="psicologo-password" v-model="psicologo.password" type="password" class="mt-1 block w-full" required>
          </div>
          <div class="mb-4">
            <label for="psicologo-crm" class="block text-gray-700">CRM</label>
            <input id="psicologo-crm" v-model="psicologo.crm" type="text" class="mt-1 block w-full" required>
          </div>
          <div class="mb-4">
            <label for="psicologo-telefone" class="block text-gray-700">Telefone</label>
            <input id="psicologo-telefone" v-model="psicologo.telefone" type="text" class="mt-1 block w-full" required>
          </div>
          <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white">Adicionar Psicólogo</button>
          </div>
        </form>

        <form v-if="activeTab === 'secretaria'" @submit.prevent="submitSecretariaForm">
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
      
  </AuthenticatedLayout>
</template>

<script>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';


const { props } = usePage();

const highlightedSession = ref(null);
const attendedSessions = ref([]);

export default {
  data() {
    return {
      activeTab: 'cliente',
      client: {
        name: '',
        email: '',
        password: '',
        cep: '',
        logradouro: '',
        bairro: '',
        cidade: '',
        estado: '',
        telefone: ''
      },
      psicologo: {
        name: '',
        email: '',
        password: '',
        crm: '',
        telefone: ''
      },
      secretaria: {
        name: '',
        email: '',
        password: '',
        telefone: ''
      }
    };
  },
  methods: {
    fetchAddress() {
      const cep = this.client.cep.replace(/\D/g, '');
      if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
          .then(response => response.json())
          .then(data => {
            if (!data.erro) {
              this.client.logradouro = data.logradouro;
              this.client.bairro = data.bairro;
              this.client.cidade = data.localidade;
              this.client.estado = data.uf;
            }
          });
      }
    },
    submitClientForm() {
      this.$inertia.post(route('clients.store'), this.client, {
        onSuccess: () => {
          alert('Cliente adicionado com sucesso!');
          window.location = route('secretaria.dashboard');        
        },
        onError: (errors) => {
          console.error(errors);
        }
      });
    },
    submitPsicologoForm() {
      this.$inertia.post(route('psicologos.store'), this.psicologo, {
        onSuccess: () => {
          alert('Psicólogo adicionado com sucesso!');
          window.location = route('secretaria.dashboard');        
        },
        onError: (errors) => {
          console.error(errors);
        }
      });
    },
    submitSecretariaForm() {
      this.$inertia.post(route('secretarias.store'), this.secretaria, {
        onSuccess: () => {
          alert('Secretária adicionada com sucesso!');
          window.location = route('secretaria.dashboard');        
        },
        onError: (errors) => {
          console.error(errors);
        }
      });
    }
  }
};
</script>

<style>
.tab {
  cursor: pointer;
  padding: 10px 20px;
  border: 1px solid #ccc;
  border-bottom: none;
  background-color: #fff;
  border-radius: 5px 5px 0 0;
}
.tab.active {
  background-color: #007bff;
  color: white;
}
.tab + .tab {
  margin-left: -1px; /* Remove a borda duplicada entre os botões */
}
</style>
