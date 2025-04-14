<template>
  <div class="card">
    <img class="card-image" :src="image" alt="Card Image" />
    <div class="card-content">
      <div class="text-content">
        <h2 class="title">{{ title }}</h2>
        <p class="subtitle">R$ {{ formatCurrency(valor) }}</p>
      </div>
      <ButtonComponent class="action-button" @click="onClick"> Comprar </ButtonComponent>
    </div>
  </div>
</template>

<script setup>
import ButtonComponent from '@/components/buttons/ButtonComponent.vue'

defineProps({
  image: String,
  title: String,
  valor: [String, Number],
  onClick: Function
})

function formatCurrency(value) {
  const number = typeof value === 'string' ? parseFloat(value) : value
  return number?.toFixed(2).replace('.', ',') || '0,00'
}
</script>

<style scoped>
.card {
  width: 300px;
  aspect-ratio: 1 / 1;
  border: 1px solid #ccc;
  border-radius: 8px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  background-color: #fff;
}

.card-image {
  width: 100%;
  height: 66.66%;
  object-fit: cover;
}

.card-content {
  height: 33.33%;
  padding: 10px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}

.text-content {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.title {
  font-size: 1.1rem;
  font-weight: bold;
  margin: 0;
}

.subtitle {
  font-size: 0.9rem;
  color: #666;
  margin: 0;
}

.action-button {
  padding: 6px 12px;
  background-color: #007BFF;
  border: none;
  color: white;
  border-radius: 4px;
  cursor: pointer;
}

.action-button:hover {
  background-color: #0056b3;
}
</style>
