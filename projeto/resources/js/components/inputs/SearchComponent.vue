<template>
  <div class="search-container">
    <div class="search-input-wrapper">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search..."
        class="search-input"
        @keyup.enter="handleSearch"
      />
      <button class="search-button" @click="handleSearch">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <circle cx="11" cy="11" r="8" />
          <line x1="21" y1="21" x2="16.65" y2="16.65" />
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const searchQuery = ref('')

const emit = defineEmits(['search'])

const handleSearch = () => {
  emit('search', searchQuery.value)
}
</script>

<style scoped>
.search-container {
  margin: 1rem 0;
}

.search-input-wrapper {
  position: relative;
  display: inline-flex;
  align-items: center;
  width: 100%;
  max-width: 400px;
}

.search-input {
  width: 100%;
  padding: 0.5rem 2.5rem 0.5rem 1rem;
  border: 1px solid #5f5f5f;
  border-radius: 4px;
  background-color: rgb(221, 221, 221);
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.search-input:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 2px rgba(74, 111, 165, 0.2);
}

.search-button {
  position: absolute;
  right: 0.5rem;
  background: none;
  border: none;
  cursor: pointer;
  color: #666;
  padding: 0.25rem;
  transition: color 0.3s ease;
}

.search-button:hover {
  color: var(--primary-color);
}

.search-button svg {
  display: block;
}
</style>
