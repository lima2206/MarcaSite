<template>
  <div>
    <h1>Dashboard</h1>
    <p>Welcome to the dashboard page!</p>

    <p>Here is your data:</p>
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
