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
    <template v-slot:item.actions="{ item }">
      <v-icon
          v-if="actions.view"
          size="small"
          class="me-2"
          @click="handleView(item.id)"
          color="primary"
      >
        mdi-eye
      </v-icon>
      <v-icon
          v-if="actions.edit"
          size="small"
          class="me-2"
          @click="handleEdit(item.id)"
          color="primary"
      >
        mdi-pencil
      </v-icon>
      <v-icon
          v-if="actions.delete"
          size="small"
          @click="openDeleteDialog(item.id)"
          color="error"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title :text="toolbarTitle"></v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
    </template>
  </v-data-table-server>

  <v-dialog v-model="isDialogOpen" persistent max-width="400px">
    <v-card>
      <v-card-title class="headline">Confirm Deletion</v-card-title>
      <v-card-text>
        Are you sure you want to delete this item?
      </v-card-text>
      <v-card-actions>
        <v-btn color="grey" @click="isDialogOpen = false">Cancel</v-btn>
        <v-btn color="red" @click="handleDeleteConfirmed">Delete</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import {ref} from 'vue';
import type {Relation} from '@/models';
import type {Pagination} from '@/services/Pagination';

const props = defineProps<{
  toolbarTitle?: string;
  columns: { title: string; key: string }[];
  actions: { edit: boolean; delete: boolean, view: boolean };
  items: Relation[];
  isLoading?: boolean;
  pagination?: Pagination;
  fetchData: (options: { page: number; itemsPerPage: number; sortBy: string[] }) => Promise<void>;
}>();

const emit = defineEmits<{
  (e: 'handleEdit', id: string): void;
  (e: 'handleView', id: string): void;
  (e: 'handleDelete', id: string): void;
}>();

const isDialogOpen = ref(false);
const itemIdToDelete = ref<string | null>(null);

const openDeleteDialog = (id: string) => {
  itemIdToDelete.value = id;
  isDialogOpen.value = true;
};

const handleDeleteConfirmed = () => {
  if (itemIdToDelete.value) {
    emit('handleDelete', itemIdToDelete.value);
    isDialogOpen.value = false;
  }
};

const handleEdit = (id: string) => {
  emit('handleEdit', id);
};

const handleView = (id: string) => {
  emit('handleView', id);
};
</script>
