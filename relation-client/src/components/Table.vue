<template>
  <v-data-table-server
      v-model:items-per-page="pagination.perPage"
      :headers="columns"
      :items="items"
      :loading="isLoading"
      :items-length="pagination.totalCount"
      item-value="name"
      @update:options="fetchData"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title :text="toolbarTitle"></v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
    </template>
  </v-data-table-server>
</template>

<script setup lang="ts">
import type {Relation} from '@/models';
import type {Pagination} from '@/services/Pagination';

const props = defineProps<{
  toolbarTitle?: string;
  columns: { title: string; key: string }[];
  items: Relation[];
  isLoading?: boolean;
  pagination?: Pagination;
  fetchData: (options: { page: number; itemsPerPage: number; sortBy: string[] }) => Promise<void>;
}>();
</script>