<script>
import axios from 'axios';
import AlertBox from '../components/AlertBox.vue';

export default {
  data() {
    return ({
      tarefas: [],
      alertBox: {
        msg: undefined,
        type: undefined
      },
      sortBy: {
        key: 'id',
        order: 'desc'
      }
    })
  },
  watch: {
    'sortBy.key'() {
      this.sortByKeyOrder();
    },
    'sortBy.order'() {
      this.sortByKeyOrder();
    }
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
      axios.get('http://localhost:8000/api/tarefas').then((response) => {
        if (response.data.length > 0) {
          vm.tarefas = response.data;
        } else {
          vm.alertBox.msg = 'A lista de tarefas está vazia.';
          vm.alertBox.type = 'warning';
        }
      }).catch((error) => {
        console.log(error);
      });
    },
    dateFormat(date) {
      var formatedDate = new Date(Date.parse(date));
      return formatedDate.toLocaleDateString();
    },
    handleStatus(id, status, index) {
      var vm = this;
      axios.put('http://localhost:8000/api/tarefas/' + id, {status: status}).then((response) => {
        vm.tarefas[index] = response.data.tarefa;
      }).catch((error) => {
        console.log(error);
      });
    },
    handleDelete(id) {
      var vm = this;
      axios.delete('http://localhost:8000/api/tarefas/' + id).then((response) => {
        vm.alertBox.msg = response.data.msg;
        vm.alertBox.type = 'success';
        vm.handleRefresh();
      }).catch((error) => {
        console.log(error);
      });
    },
    handleSortBy(key) {
      if (this.sortBy.key === key) {
        this.sortBy.order = this.sortBy.order === 'asc'? 'desc' : 'asc' ;
      } else {
        this.sortBy.key = key;
        this.sortBy.order = 'asc';
      }
    },
    sortByKeyOrder() {
      if (this.sortBy.order === 'asc') {
        this.tarefas.sort((a, b) => (a[this.sortBy.key] > b[this.sortBy.key]) ? 1 : -1);
      } else {
        this.tarefas.sort((a, b) => (a[this.sortBy.key] < b[this.sortBy.key]) ? 1 : -1);
      }
    }
  }
}
</script>

<template>
  <div>
    
    <div class="mb-4 text-start">
      <RouterLink to="/tarefas/novo" class="mr-1 font-medium inline-block bg-green-400 px-4 py-2 rounded hover:bg-green-600 hover:text-white transition">Adicionar</RouterLink>
      <a href="#" @click.prevent="handleRefresh()" class="font-medium inline-block bg-slate-400 px-4 py-2 rounded hover:bg-slate-600 hover:text-white transition">Atualizar</a>
    </div>

    <AlertBox :msg="alertBox.msg" :type="alertBox.type" />
    
    <table class="table-auto w-full" v-if="tarefas.length > 0">
      <thead>
        <th><a href="jsvscript:void(0)" @click.prevent="handleSortBy('id')">ID</a></th>
        <th><a href="jsvscript:void(0)" @click.prevent="handleSortBy('tarefa')">Tarefa</a></th>
        <th><a href="jsvscript:void(0)" @click.prevent="handleSortBy('status')">Status</a></th>
        <th><a href="jsvscript:void(0)" @click.prevent="handleSortBy('entrega')">Entrega</a></th>
        <th><a href="jsvscript:void(0)" @click.prevent="handleSortBy('responsavel')">Responsável</a></th>
        <th></th>
      </thead>
      <tbody>
        <tr v-for="(tarefa, index) in tarefas" key="{{ tarefa.id }}" :class="tarefa.status !== 'Concluído'? 'even:bg-slate-200 odd:bg-slate-100 hover:bg-slate-300' : 'even:bg-green-200 odd:bg-green-100 hover:bg-green-300'">
          <td>{{ tarefa.id }}</td>
          <td>{{ tarefa.tarefa }}</td>
          <td>{{ tarefa.status }}</td>
          <td>{{ dateFormat(tarefa.entrega) }}</td>
          <td>{{ tarefa.usuario.nome }}</td>
          <td class="text-end" nowrap>
            <a href="javascript:void(0)" @click.prevent="handleStatus(tarefa.id, 'Em progresso', index)" v-if="tarefa.status === 'Nova' || tarefa.status === 'Em pausa'" class="font-medium inline-block bg-green-400 px-4 py-1 rounded hover:bg-green-600 hover:text-white transition">Trabalhar</a>
            <a href="javascript:void(0)" @click.prevent="handleStatus(tarefa.id, 'Concluído', index)" v-if="tarefa.status === 'Em progresso'" class="font-medium inline-block bg-green-400 px-4 py-1 rounded hover:bg-green-600 hover:text-white transition">Concluir</a>
            <a href="javascript:void(0)" @click.prevent="handleStatus(tarefa.id, 'Em pausa', index)" v-if="tarefa.status === 'Em progresso'" class="ml-1 font-medium inline-block bg-slate-400 px-4 py-1 rounded hover:bg-slate-600 hover:text-white transition">Pausar</a>
            <RouterLink :to="{ name: 'tarefas-editar', params: { id: tarefa.id } }" v-if="tarefa.status !== 'Concluído'" class="ml-1 font-medium inline-block bg-slate-400 px-4 py-1 rounded hover:bg-slate-600 hover:text-white transition">Editar</RouterLink>
            <a href="javascript:void(0)" @click.prevent="handleDelete(tarefa.id)" v-if="tarefa.status !== 'Concluído'" class="ml-1 font-medium inline-block bg-red-400 px-4 py-1 rounded hover:bg-red-600 hover:text-white transition">Excluir</a>
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