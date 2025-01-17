<template>
  <v-row>
    <v-col cols="12">
      <v-btn @click="navigateToCreate">Create</v-btn>
    </v-col>
  </v-row>
  <v-row>
    <v-col cols="12">
      <Table
          :pagination="pagination"
          :columns="columns"
          :items="relations"
          :isLoading="isLoading"
          :fetchData="fetchData"
          :toolbarTitle="'Relations'"
          :actions="{ view: true, edit: true, delete: true }"
          @handleEdit="navigateToEdit"
          @handleView="navigateToView"
          @handleDelete="deleteRelation"
      />
    </v-col>
  </v-row>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Table from '@/components/Table.vue';
import { RelationService } from '@/services/RelationService';
import type { Relation } from '@/models';
import type { DataTableOptions } from '@/services/DataTableOptions';
import type { Pagination } from '@/services/Pagination';

const router = useRouter();
const relations = ref<Relation[]>([]);
const isLoading = ref(false);
const error = ref<string | null>(null);

const pagination = ref<Pagination>({
  totalCount: 0,
  totalPages: 0,
  currentPage: 1,
  perPage: 10,
});

const columns = ref([
  { title: 'Title', key: 'title', sortable: true },
  { title: 'Status', key: 'status', sortable: false },
  { title: 'Actions', key: 'actions', sortable: false },
]);

const fetchData = async (options: DataTableOptions) => {
  isLoading.value = true;
  try {
    const response = await RelationService.getRelations(
      options.page,
      options.itemsPerPage,
      options.sortBy?.[0] || {}
    );
    relations.value = response.data;
    pagination.value = {
      totalCount: response.pagination.totalCount,
      totalPages: response.pagination.totalPages,
      currentPage: options.page,
      perPage: options.itemsPerPage,
    };
  } catch (err) {
    error.value = 'Failed to fetch relations';
    console.error('Error fetching relations:', err);
  } finally {
    isLoading.value = false;
  }
};

const deleteRelation = async (id: string) => {
  isLoading.value = true;
  try {
    await RelationService.delete(id);
    await fetchData({
      page: pagination.value.currentPage,
      itemsPerPage: pagination.value.perPage,
      sortBy: []
    });
  } catch (err) {
    error.value = 'Failed to delete relation';
    console.error('Error deleting relation:', err);
  } finally {
    isLoading.value = false;
  }
};

const navigateToCreate = () => {
  router.push({ name: 'relation-create' });
};

const navigateToEdit = (id: string) => {
  router.push({ name: 'relation-edit', params: { id } });
};

const navigateToView = (id: string) => {
  router.push({ name: 'relation-view', params: { id } });
};

onMounted(() => {
  fetchData({
    page: 1,
    itemsPerPage: 10,
    sortBy: []
  });
});
</script>