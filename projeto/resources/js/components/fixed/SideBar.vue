<template>
  <aside class="sidebar">
    <header class="header">
      <h1>MarcaSite!</h1>
    </header>
    <div class="sidebar-items">
      <router-link to="/dashboard" class="sidebar-item">
        <HomeIcon class="icon" />
        <span>Dashboard</span>
      </router-link>
      <router-link to="/cursos" class="sidebar-item">
        <CalendarIcon class="icon" />
        <span>Cursos</span>
      </router-link>
      <router-link to="/usuarios" class="sidebar-item">
        <UsersIcon class="icon" />
        <span>Usuários</span>
      </router-link>
      <router-link to="/configuracoes" class="sidebar-item">
        <CogIcon class="icon" />
        <span>Configurações</span>
      </router-link>
    </div>
  </aside>
</template>

<script setup>
import { HomeIcon, CalendarIcon, UsersIcon, CogIcon } from '@heroicons/vue/outline';
</script>

<style scoped>
.sidebar {
  width: 250px;
  height: 100vh;
  background-color: lightgray;
  position: fixed;
  left: 0;
  top: 0;
  display: flex;
  flex-direction: column;
  padding: 20px 0;
}

.header {
  display: flex;
  justify-content: center;
  align-items: center; 
  height: 50px; 
  color: rgb(0, 0, 0);
}

.sidebar-items {
  display: flex;
  flex-direction: column;
  gap: 30px;
  justify-content: center;  /* Center vertically */
  align-items: center;      /* Center horizontally */
  flex-grow: 1;             /* Allow sidebar items to take available vertical space */
}

.sidebar-item {
  display: flex;
  align-items: center;      /* Align the items (icon and text) horizontally */
  text-decoration: none;
  color: #333;
  font-weight: 500;
  transition: all 0.3s ease;
  width: 100%;              /* Take up the full width of the sidebar */
  padding: 10px 20px;       /* Adjust padding for more space around the content */
  box-sizing: border-box;   /* Ensure padding doesn't add extra width */
}

.sidebar-item:hover {
  background-color: rgba(0, 0, 0, 0.1);  /* Apply background on hover */
}

.sidebar-item .icon {
  width: 24px;
  height: 24px;
  color: gray; /* Gray color for icons */
  margin-right: 10px; /* Space between icon and text */
}

.router-link-exact-active {
  background-color: rgba(0, 0, 0, 0.1);
  color: var(--primary-color);
}

</style>  
