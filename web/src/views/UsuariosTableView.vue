<script>
import axios from 'axios';
import AlertBox from '../components/AlertBox.vue';

export default {
  data() {
    return ({
      usuarios: [],
      alertBox: {
        msg: undefined,
        type: undefined
      }
    })
  },
  components: {
    AlertBox
  },
  mounted() {
    this.handleRefresh();
  },
  methods: {
    handleRefresh() {
      var vm = this;
      axios.get('http://localhost:8000/api/usuarios').then((response) => {
        vm.usuarios = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    handleDelete(id) {
      var vm = this;
      axios.delete('http://localhost:8000/api/usuarios/' + id).then((response) => {
        vm.alertBox.msg = response.data.msg;
        vm.alertBox.type = 'success';
        vm.handleRefresh();
      }).catch((error) => {
        console.log(error);
      });
    }
  }
}
</script>

<template>
  <div>
    
    <div class="mb-4 text-start">
      <RouterLink to="/usuarios/novo" class="mr-1 font-medium inline-block bg-green-400 px-4 py-2 rounded hover:bg-green-600 hover:text-white transition">Adicionar</RouterLink>
      <a href="#" @click.prevent="handleRefresh()" class="font-medium inline-block bg-slate-400 px-4 py-2 rounded hover:bg-slate-600 hover:text-white transition">Atualizar</a>
    </div>
    
    <AlertBox :msg="alertBox.msg" :type="alertBox.type" />

    <table class="table-auto w-full">
      <thead>
        <th>ID</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th></th>
      </thead>
      <tbody>
        <tr v-for="usuario in usuarios" key="{{ usuario.id }}" class="even:bg-slate-100 hover:bg-slate-200">
          <td>{{ usuario.id }}</td>
          <td>{{ usuario.nome }}</td>
          <td>{{ usuario.email }}</td>
          <td class="text-end">
            <RouterLink :to="{ name: 'usuarios-editar', params: { id: usuario.id } }" class="font-medium inline-block bg-slate-400 px-4 py-1 rounded hover:bg-slate-600 hover:text-white transition">Editar</RouterLink>
            <a href="javascript:void(0)" @click.prevent="handleDelete(usuario.id)" class="ml-1 font-medium inline-block bg-red-400 px-4 py-1 rounded hover:bg-red-600 hover:text-white transition">Excluir</a>
          </td>
        </tr>
      </tbody>
    </table>

    <RouterView />

  </div>
</template>

<style lang="scss" scoped>
th {
  @apply bg-slate-800;
  @apply text-white;
  @apply px-4;
  @apply py-2;
  @apply text-start;
  @apply font-medium;
  &:first-child {
    @apply rounded-l-lg;
  }
  &:last-child {
    @apply rounded-r-lg;
  }
}
td {
  @apply px-4;
  @apply py-2;
  &:first-child {
    @apply rounded-l-lg;
  }
  &:last-child {
    @apply rounded-r-lg;
  }
}
</style>