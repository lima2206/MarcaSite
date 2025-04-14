<template>
  <div class="input-container">
    <label :for="id" class="input-label">{{ label }}</label>
    <input
      :type="type"
      :id="id"
      :placeholder="placeholder"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="input-field"
    />
  </div>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    required: true,
  },
  type: {
    type: String,
    default: 'text',
  },
  placeholder: {
    type: String,
    default: '',
  },
  id: {
    type: String,
    required: true,
  },
  modelValue: {
    type: [String, Number], // ✅ aceita String e Number
    default: '',
  },
});
</script>

<style scoped>
.input-container {
  margin: 1rem 0;
}

.input-label {
  display: block;
}

.input-field {
  width: 100%;
  padding: 8px;
  border: 1px solid #5f5f5f;
  border-radius: 4px;
  background-color: rgb(221, 221, 221);
}
</style>