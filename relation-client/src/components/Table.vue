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

<script lang="ts">
import {defineComponent} from 'vue';
import type {Relation} from '@/models';
import type {Pagination} from '@/services/Pagination';

export default defineComponent({
  name: 'RelationsTable',
  props: {
    toolbarTitle: {
      type: String,
      default: ''
    },
    columns: {
      type: Array as () => { title: string; key: string }[],
      required: true
    },
    items: {
      type: Array as () => Relation[],
      required: true
    },
    isLoading: {
      type: Boolean,
    },
    pagination: {
      type: Object as () => Pagination,
      default: () => ({
        totalCount: 0,
        totalPages: 0,
        currentPage: 1,
        perPage: 10,
      })
    },
    fetchData: {
      type: Promise<void>,
      required: true
    },
  },

  setup() {
  }
});
</script>