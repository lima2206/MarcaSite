<template>
  <div>
    <h1>Dashboard</h1>
    <p>Dados do usuario logado para Debug:</p>
    <ul>
      <li v-for="[key, value] in Object.entries(userStore.user || {})">
        {{ key }} : {{ value === null ? 'null' : value }}
      </li>
    </ul>


  </div>
</template>

<script setup>
  import { useUserStore } from '../stores/user';

  const userStore = useUserStore()
</script>
