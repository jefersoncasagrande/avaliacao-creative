<script>
export default {
  data() {
    return ({
      form: {
        login: '',
        senha: ''
      }
    });
  },
  methods: {
    handleLogin() {
      console.log(this.form.login);
      console.log(this.form.senha);
    }
  }
}
</script>


<template>
  <div class="flex h-full items-center content-center">
    <div class="flex-initial bg-slate-600 rounded-lg p-6 text-white m-auto w-3/12 text-center">
      <div class="mb-6"><h1 class="text-2xl">Avaliação Creative</h1></div>
      <div>
        <form @submit.prevent="handleLogin">
          <div class="mb-3">
            <div class="text-start"><label for="login">Login</label></div>
            <div><input id="login" type="text" name="login" v-model="form.login" class="" required /></div>
          </div>
          <div class="mb-6">
            <div class="text-start"><label for="senha">Senha</label></div>
            <div><input id="senha" type="password" name="senha" v-model="form.senha" class="" required /></div>
          </div>
          <div>
            <button type="submit" class="font-medium inline-block bg-gray-400 px-4 py-2 rounded hover:bg-gray-500 hover:text-white transition">Entrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
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