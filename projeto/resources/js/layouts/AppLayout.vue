<template>
  <div class="app-container">
    <SideBar />
    <div class="content-container">
      <router-view />
    </div>
  </div>
</template>

<script setup>
import SideBar from '@/components/fixed/SideBar.vue'
</script>

<style scoped>
.app-container {
  display: flex;
  min-height: 100vh;
}

.content-container {
  flex: 1;
  margin-left: 250px;
  display: flex;
  flex-direction: column;
}
</style>
