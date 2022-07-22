<script>
import axios from 'axios';
import AlertBox from '../components/AlertBox.vue';

export default {
  data() {
    return ({
      form: {
        tarefa: '',
        entrega: '',
        usuario: '',
      },
      usuarios: [],
      editId: this.$route.params.id,
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
    this.getUsuarios();
    if (this.editId) {
      this.getFormData();
    }
  },
  methods: {
    handleSubmit() {
      var vm = this;
      var form = this.form;
      if (this.editId) {
        axios.put('http://localhost:8000/api/tarefas/' + this.editId, form).then((response) => {
          vm.alertBox.msg = response.data.msg;
          vm.alertBox.type = 'success';
        }).catch((error) => {
          console.log(error);
        });
      } else {
        axios.post('http://localhost:8000/api/tarefas', form).then((response) => {
          vm.alertBox.msg = response.data.msg;
          vm.alertBox.type = 'success';
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    getUsuarios() {
      var vm = this;
      axios.get('http://localhost:8000/api/usuarios').then((response) => {
        vm.usuarios = response.data;
        vm.form.usuario = vm.usuarios.length > 0? vm.usuarios[0].id : '';
      }).catch((error) => {
        console.log(error);
      });
    },
    getFormData() {
      var form = this.form;
      axios.get('http://localhost:8000/api/tarefas/' + this.editId).then((response) => {
        let entrega = new Date(response.data.entrega);

        form.tarefa = response.data.tarefa;
        form.entrega = entrega.getFullYear() + '-';
        form.entrega += ((String(entrega.getMonth() + 1).length > 1)? entrega.getMonth() + 1 : '0' + entrega.getMonth() + 1) + '-';
        form.entrega += ((String(entrega.getDate()).length > 1)? entrega.getDate() : '0' + entrega.getDate());
        form.usuario = response.data.usuario_id;
      }).catch((error) => {
        console.log(error);
      });
    }
  }
}
</script>

<template>
  <main class="w-2/4 m-auto">

    <div class="mb-4">
      <h1 class="text-xl font-bold">{{ editId? 'Editar' : 'Nova' }} tarefa {{ editId? '#' + editId : '' }}</h1>
    </div>

    <form @submit.prevent="handleSubmit">
      <div class="mb-4">
        <div><label for="tarefa">Tarefa</label></div>
        <div><input id="tarefa" name="tarefa" type="text" v-model="form.tarefa" required /></div>
      </div>
      <!-- <div class="mb-4">
        <div><label for="status">Status</label></div>
        <div><input id="status" name="status" type="text" v-model="status" required /></div>
      </div> -->
      <div class="mb-4">
        <div><label for="entrega">Entrega</label></div>
        <div><input id="entrega" name="entrega" type="date" v-model="form.entrega" required /></div>
      </div>
      <div class="mb-4">
        <div><label for="usuario">Responsável</label></div>
        <div>
          <select id="usuario" name="usuario" v-model="form.usuario">
            <option v-for="(usuario, index) in usuarios" :value="usuario.id">{{ usuario.nome }}</option>
          </select>
        </div>
      </div>
      <AlertBox :msg="alertBox.msg" :type="alertBox.type" />
      <div class="mb-4 text-start">
        <button type="submit" class="mr-2 font-medium inline-block bg-green-400 px-4 py-2 rounded hover:bg-green-600 hover:text-white transition">Salvar</button>
        <RouterLink to="/tarefas" class="text-slate-400 hover:text-black transition">Cancelar</RouterLink>
      </div>
    </form>

  </main>
</template>

<style lang="scss" scoped>

</style>