<script>
import axios from 'axios';
import AlertBox from '../components/AlertBox.vue';

export default {
  data() {
    return ({
      form: {
        nome: '',
        email: '',
        senha: '',
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
    AlertBox,
  },
  mounted() {
    if (this.editId) {
      this.getFormData();
    }
  },
  methods: {
    handleSubmit() {
      var vm = this;
      var form = this.form;
      if (this.editId) {
        axios.put('http://localhost:8000/api/usuarios/' + this.editId, form).then((response) => {
          vm.alertBox.msg = response.data.msg;
          vm.alertBox.type = 'success';
        }).catch((error) => {
          console.log(error);
        });
      } else {
        axios.post('http://localhost:8000/api/usuarios', form).then((response) => {
          vm.alertBox.msg = response.data.msg;
          vm.alertBox.type = 'success';
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    getFormData() {
      var form = this.form;
      axios.get('http://localhost:8000/api/usuarios/' + this.editId).then((response) => {
        form.nome = response.data.nome;
        form.email = response.data.email;
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
      <h1 class="text-xl font-bold">{{ editId? 'Editar' : 'Novo' }} usuário {{ editId? '#' + editId : '' }}</h1>
    </div>

    <form @submit.prevent="handleSubmit">
      <div class="mb-4">
        <div><label for="nome">Nome</label></div>
        <div><input id="nome" name="nome" type="text" v-model="form.nome" required /></div>
      </div>
      <div class="mb-4">
        <div><label for="email">E-mail</label></div>
        <div><input id="email" name="email" type="email" v-model="form.email" required /></div>
      </div>
      <div class="mb-4">
        <div><label for="senha">Senha</label></div>
        <div><input id="senha" name="senha" type="password" v-model="form.senha" :required="editId? false : true" /></div>
        <div class="text-xs ml-2 text-slate-600">Para manter a senha antiga, deixe este campo vazio.</div>
      </div>
      <AlertBox :msg="alertBox.msg" :type="alertBox.type" />
      <div class="mb-4 text-start">
        <button type="submit" class="mr-2 font-medium inline-block bg-green-400 px-4 py-2 rounded hover:bg-green-600 hover:text-white transition">Salvar</button>
        <RouterLink to="/usuarios" class="text-slate-400 hover:text-black transition">Cancelar</RouterLink>
      </div>
    </form>

  </main>
</template>

<style lang="scss" scoped>
label {
  @apply text-sm;
  @apply ml-2;
}

input, select {
  @apply bg-slate-200;
  @apply rounded-lg;
  @apply px-4;
  @apply py-2;
  @apply w-full;
  @apply transition;
  @apply ease-in-out;
  &:focus {
    @apply bg-slate-300;
    outline: none;
  }
}
</style>