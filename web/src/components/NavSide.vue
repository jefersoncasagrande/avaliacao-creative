<template>
  <div>
    <div class="p-6">
      <nav>
        <ul>
          <li><RouterLink to="/tarefas">Tarefas</RouterLink></li>
          <li><RouterLink to="/usuarios">Usuários</RouterLink></li>
        </ul>
      </nav>
    </div>
    <div class="p-6 border-t border-slate-900">
      <ul>
          <li><RouterLink to="/meus-dados">Meus dados</RouterLink></li>
          <li><RouterLink to="/logout">Sair</RouterLink></li>
        </ul>
    </div>
  </div>
</template>

<style lang="scss" scoped>
a {
  @apply block;
  @apply py-4;
  @apply px-6;
  @apply rounded-lg;
  @apply transition;
  @apply ease-in-out;
  &:hover, &.router-link-active {
    @apply bg-slate-900;
  }
}

li {
  @apply mb-1
}
</style>
