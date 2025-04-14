<template>
  <div v-if="isVisible" class="modal-overlay">
    <div class="modal-content">
      <h2>Editar Curso</h2>
      <form @submit.prevent="submit">
        <InputComponent
          v-for="field in fields"
          :key="field.id"
          v-model="form[field.id]"
          :label="field.label"
          :id="field.id"
        />
        
        <!-- Checkbox para o campo booleano -->
        <div class="checkbox-group">
          <label for="cur_ativo">
            <input
              type="checkbox"
              id="cur_ativo"
              v-model="form.cur_ativo"
            />
            Está Ativo?
          </label>
        </div>

        <div class="modal-actions">
          <ButtonComponent type="submit">Salvar</ButtonComponent>
          <ButtonComponent isLight type="button" @click="close">Cancelar</ButtonComponent>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import InputComponent from '../inputs/InputComponent.vue'
import ButtonComponent from '../buttons/ButtonComponent.vue'
import axios from 'axios'

const props = defineProps({ isVisible: Boolean, curso: Object })
const emit = defineEmits(['update:isVisible', 'updated'])

const form = ref({})
const fields = [
  { id: 'cur_nome', label: 'Nome' },
  { id: 'cur_descricao', label: 'Descrição' },
  { id: 'cur_valor', label: 'Valor' },
  { id: 'cur_data_inscricoes_inicio', label: 'Início das Inscrições' },
  { id: 'cur_data_inscricoes_fim', label: 'Fim das Inscrições' },
  { id: 'cur_vagas', label: 'Vagas' }
]

watch(() => props.isVisible, (visible) => {
  if (visible && props.curso) form.value = { ...props.curso }
})

const submit = async () => {
  await axios.put(`http://localhost:8000/api/curso/${form.value.cur_id}`, form.value)
  emit('updated')
  close()
}

const close = () => emit('update:isVisible', false)
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
  overflow: auto;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 500px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-actions {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.modal-actions button {
  width: 48%;
}

.checkbox-group {
  display: flex;
  justify-content: space-between;
  margin-top: 16px;
}

.checkbox-group label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 500;
}
</style>
