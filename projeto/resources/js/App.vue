<template>
  <div class="app-container">
    <div class="content-container">
      <router-view />
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
.app-container {
  display: flex;
  min-height: 100vh;
}

.content-container {
  flex: 1;
  display: flex;
  flex-direction: column;
}

</style>
