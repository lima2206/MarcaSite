<template>
  <div v-if="isVisible" class="modal-overlay">
    <div class="modal-content">
      <h2>Alunos do Curso</h2>
      <AlunoTable :inscricoes="inscricoes" />
      <div class="modal-actions">
        <ButtonComponent @click="exportToPDF">Exportar PDF</ButtonComponent>
        <ButtonComponent @click="exportToExcel">Exportar Excel</ButtonComponent>
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

import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import * as XLSX from 'xlsx'
import { saveAs } from 'file-saver'



const props = defineProps({
  isVisible: Boolean,
  curso: Object
})

const inscricoes = ref([])

watch(() => props.isVisible, async (visible) => {
  if (visible && props.curso?.cur_id) {
    try {
      const res = await axios.get(`http://localhost:8000/api/inscricao/curso/${props.curso.cur_id}`)
      inscricoes.value = res.data
    } catch (error) {
      console.error('Erro ao buscar as inscricoes:', error)
    }
  }
})

const exportToPDF = () => {
  const doc = new jsPDF()
  const tableData = inscricoes.value.map(inscricao => ([
    inscricao.aluno.usu_nome,
    formatDate(inscricao.ins_data_inscricao),
    inscricao.aluno.usu_tipo,
    inscricao.aluno.usu_cpf,
    inscricao.aluno.usu_email,
    inscricao.ins_status,
    `R$ ${Number(inscricao.valor_pago).toFixed(2)}`,
    `R$ ${Number(props.curso.cur_valor).toFixed(2)}`
  ]))

  autoTable(doc, {
    head: [['Nome', 'Data de Inscrição', 'Categoria', 'CPF', 'Email', 'Status', 'Valor Pago', 'Total']],
    body: tableData
  })

  doc.save('alunos-curso.pdf')
}

const exportToExcel = () => {
  const worksheetData = inscricoes.value.map(inscricao => ({
    Nome: inscricao.aluno.usu_nome,
    'Data de Inscrição': formatDate(inscricao.ins_data_inscricao),
    Email: inscricao.aluno.usu_email,
    Status: inscricao.ins_status,
    'Valor Pago': `R$ ${Number(inscricao.valor_pago).toFixed(2)}`
  }))

  const worksheet = XLSX.utils.json_to_sheet(worksheetData)
  const workbook = XLSX.utils.book_new()
  XLSX.utils.book_append_sheet(workbook, worksheet, 'Alunos')

  const excelBuffer = XLSX.write(workbook, {
    bookType: 'xlsx',
    type: 'array'
  })

  const blob = new Blob([excelBuffer], { type: 'application/octet-stream' })
  saveAs(blob, 'alunos-curso.xlsx')
}

function formatDate(date) {
  if (!date) return '—'
  try {
    return format(new Date(date), 'dd/MM/yyyy')
  } catch {
    return date
  }
}
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
  display: flex;
  justify-content: space-around;
  text-align: right;
  margin-top: 20px;
}
</style>
