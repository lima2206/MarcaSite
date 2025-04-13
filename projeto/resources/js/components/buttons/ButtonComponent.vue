<template>
  <button class="custom-button"  :class="{ light: isLight, dark: !isLight }"  :disabled="disabled" @click="handleClick">
    <slot />
  </button>
</template>

<script setup>
import { defineEmits } from 'vue'

const props = defineProps({
  disabled: Boolean,
  isLight: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['click'])

function handleClick() {
  if (!props.disabled) {
    emit('click')
  }
}
</script>

<style scoped>
.custom-button {
  color: white;
  min-width: 100px;
  min-height: 41px;
  padding: 10px 20px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.2s ease-in-out;
}

.custom-button.dark {
  background-color: #333333;
  color: white;
}

.custom-button.dark:hover {
  background-color: #444444;
}

.custom-button.light {
  background-color: #dddddd;
  color: #222222;
}

.custom-button.light:hover {
  background-color: #cfcfcf;
}

.custom-button:disabled {
  background-color: #999999;
  color: #666666;
  cursor: not-allowed;
}
</style>
