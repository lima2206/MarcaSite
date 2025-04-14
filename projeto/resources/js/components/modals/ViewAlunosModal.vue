<template>
  <div v-if="isVisible" class="modal-overlay">
    <div class="modal-content">
      <h2>Alunos do Curso</h2>
      <AlunoTable :inscricoes="inscricoes" />
      <div class="modal-actions">
        <ButtonComponent @click="$emit('update:isVisible', false)">Fechar</ButtonComponent>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import AlunoTable from '../tables/AlunoTable.vue'
import ButtonComponent from '../buttons/ButtonComponent.vue'

const props = defineProps({
  isVisible: Boolean,
  cursoId: Number
})

const inscricoes = ref([])

watch(() => props.isVisible, async (visible) => {
  if (visible && props.cursoId) {
    try {
      const res = await axios.get(`http://localhost:8000/api/inscricao/curso/${props.cursoId}`)
      inscricoes.value = res.data
      console.log(inscricoes.value)
    } catch (error) {
      console.error('Erro ao buscar as inscricoes:', error)
    }
  }
})
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 70vw;
  max-height: 80vh;
  overflow-y: auto;
}

.modal-actions {
  text-align: right;
  margin-top: 20px;
}
</style>
