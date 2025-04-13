<template>
  <div class="drawer-selector-container">
    <label :for="id" class="input-label">{{ label }}</label>
    <select
      :value="modelValue"
      @change="$emit('update:modelValue', $event.target.value)"
      :id="id"
      class="drawer-selector"
    >
      <option v-for="(option, index) in options" :key="index" :value="option">
        {{ option }}
      </option>
    </select>
  </div>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    required: true,
  },
  options: {
    type: Array,
    required: true,
  },
  id: {
    type: String,
    required: true,
  },
  modelValue: {
    type: String,
    required: true,
  },
});
</script>

<style scoped>
.drawer-selector-container {
  margin: 1rem 0;
}

.input-label {
  display: block;
}

.drawer-selector {
  width: 100%;
  padding: 8px;
  border: 1px solid #5f5f5f;
  border-radius: 4px;
  background-color: rgb(221, 221, 221);
}
</style>
