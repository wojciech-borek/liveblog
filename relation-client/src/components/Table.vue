<template>
  <v-data-table
      :headers="columns"
      :items="items"
      :server-items-length="pagination?.totalCount || 0"
      :options="localOptions"
      @update:options="updateOptions"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Relacje</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
    </template>
  </v-data-table>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, ref, watch } from 'vue';
import { Relation } from '../models';
import { Pagination } from '@/services/Pagination.ts';

const props = defineProps<{
  columns: { title: string; key: string }[];
  items: Relation[];
  pagination: Pagination | null;
  options: {
    page: number;
    itemsPerPage: number;
    sortBy: string[];
    sortDesc: boolean[];
  };
}>();

const emit = defineEmits(['update:options']);

const localOptions = ref({ ...props.options });

watch(
    () => props.options,
    (newOptions) => {
      localOptions.value = { ...newOptions };
    },
    { deep: true }
);

const updateOptions = (newOptions: any) => {
  if (JSON.stringify(newOptions) !== JSON.stringify(localOptions.value)) {
    localOptions.value = { ...newOptions };
    emit('update:options', newOptions);
  }
};
</script>