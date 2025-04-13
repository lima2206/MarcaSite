<template>
  <div>
    
    <h1>Lista de Cursos</h1>
    <CursoTable
      :courses="cursos"
      @edit="editCurso"
      @delete="deleteCurso"
      @view-students="viewAlunos"
    />
  </div>
</template>

<script setup>

import { ref } from 'vue';
import CursoTable from '../components/tables/CursoTable.vue';

const cursos = ref([
  {
    id: 1,
    name: 'Curso de Vue.js',
    price: 199.9,
    active: true,
    registrationPeriodStart: '2025-04-01',
    registrationPeriodEnd: '2025-04-30',
    vagas: 30,
    enrolledStudents: [{ id: 1 }, { id: 2 }]
  },
  
  
]);

const editCurso = (curso) => {
  console.log('Edit', curso);
};

const deleteCurso = (curso) => {
  console.log('Delete', curso);
};

const viewAlunos = (curso) => {
  console.log('Ver alunos', curso);
};
</script>
