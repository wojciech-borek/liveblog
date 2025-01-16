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
          @handleEdit="editItem"
          @handleView="viewItem"
          @handleDelete="deleteItem"
      />
    </v-col>
  </v-row>
</template>

<script setup lang="ts">
import {onMounted, ref} from 'vue';
import router from '@/router';
import Table from '@/components/Table.vue';
import {useRelationStore} from '@/store/useRelationStore';
import {DataTableOptions} from '@/services/DataTableOptions';
import {storeToRefs} from "pinia";

const relationStore = useRelationStore();
const {relations, pagination, isLoading} = storeToRefs(relationStore);

const columns = ref([
  {title: 'Title', key: 'title', sortable: true},
  {title: 'Status', key: 'status', sortable: false},
  {title: 'Actions', key: 'actions', sortable: false},
]);

const editItem = (id: string) => {
  router.push({name: 'relation-edit', params: {id}});
};

const viewItem = (id: string) => {
  router.push({name: 'relation-view', params: {id}});
};

const deleteItem = async (id: string) => {
  try {
    await relationStore.deleteRelation(id);
    await fetchData(pagination.value);
  } catch (error) {
    console.error('Failed to delete relation:', error);
  }
};

const fetchData = async (options: DataTableOptions) => {
  try {
    await relationStore.fetchRelations(options);
  } catch (error) {
    console.error('Failed to fetch relations:', error);
  }
};

const navigateToCreate = () => {
  router.push({name: 'relation-create'});
};
</script>
