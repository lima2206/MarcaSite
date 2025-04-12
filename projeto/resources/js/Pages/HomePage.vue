<template>
  <div class="page-container">
    <header class="app-header">
      <div class="header-content">
        <h1 class="app-title">My Vue App</h1>
        <nav class="app-nav">
          <router-link to="/" class="nav-link">Home</router-link>
          <router-link to="/test" class="nav-link">Test Page</router-link>
        </nav>
      </div>
    </header>

    <main class="app-main">
      <section class="hero-section">
        <h2 class="hero-title">Welcome to the Home Page</h2>
        <p class="hero-text">
          This is a simple Vue.js application with CSS styling.
          Click the "Test Page" link in the navigation to see the other view.
        </p>
        <button 
          @click="goToTestPage"
          class="action-button"
        >
          Go to Test Page
        </button>
      </section>
    </main>

    <footer class="app-footer">
      <p>&copy; 2023 My Vue App. All rights reserved.</p>
    </footer>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const goToTestPage = () => {
  router.push('/test')
}
</script>

<style scoped>
.page-container {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background-color: #f8f9fa;
}

.app-header {
  background-color: #2563eb;
  color: white;
  padding: 1rem;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.header-content {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.app-title {
  font-size: 1.5rem;
  font-weight: bold;
}

.app-nav {
  display: flex;
  gap: 1rem;
}

.nav-link {
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  color: white;
  text-decoration: none;
}

.nav-link:hover {
  background-color: #1d4ed8;
}

.app-main {
  flex: 1;
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 1rem;
}

.hero-section {
  text-align: center;
  padding: 3rem 0;
}

.hero-title {
  font-size: 2.25rem;
  font-weight: bold;
  color: #1e293b;
  margin-bottom: 1rem;
}

.hero-text {
  font-size: 1.25rem;
  color: #475569;
  max-width: 42rem;
  margin: 0 auto 2rem;
}

.action-button {
  background-color: #2563eb;
  color: white;
  font-weight: bold;
  padding: 0.5rem 1.5rem;
  border-radius: 0.5rem;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s;
}

.action-button:hover {
  background-color: #1d4ed8;
}

.app-footer {
  background-color: #1e293b;
  color: white;
  padding: 1rem;
  text-align: center;
}
</style>