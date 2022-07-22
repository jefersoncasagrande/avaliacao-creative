<script setup>
import { RouterLink, RouterView } from 'vue-router'
import NavSide from './components/NavSide.vue'
</script>

<template>
  <div class="mx-auto h-screen">
    <div class="flex h-full">
      <div class="flex-initial xl:w-1/6 lg:w-3/12 bg-slate-800 text-white" v-if="$route.name !== 'login'">
        <div class="p-6 bg-slate-900">
          <h1 class="text-xl font-medium text-center">Avaliação Creative</h1>
        </div>
        <NavSide />
      </div>
      <div class="flex-1 p-6">
        <RouterView />
      </div>
    </div>
  </div>
</template>

<style lang="scss">

</style>
