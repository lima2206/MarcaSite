<template>
  <header class="sticky-header">
    <div class="header-left">
      <SearchComponent @search="handleSearch" />
    </div>
    <div class="header-right">
      <ButtonComponent :disabled="buttonDisabled" @click="handleButtonClick">
        {{ buttonText }}
      </ButtonComponent>
    </div>
  </header>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'
import SearchComponent from '@/components/inputs/SearchComponent.vue'
import ButtonComponent from '@/components/buttons/ButtonComponent.vue'

const props = defineProps({
  buttonText: {
    type: String
  },
  buttonDisabled: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['button-click', 'search'])

const handleButtonClick = () => {
  emit('button-click')
}

const handleSearch = (query) => {
  emit('search', query)
}
</script>


<style scoped>
.sticky-header {
  position: sticky;
  top: 0;
  left: 0;
  right: 0;
  padding: 10px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  z-index: 10;
}

.header-left,
.header-right {
  display: flex;
  align-items: center;
}

.header-left {
  gap: 10px;
}

.header-right {
  gap: 10px;
}

/* Smooth scrolling for the content */
body {
  padding-top: 60px; /* Adjust if needed */
}
</style>
