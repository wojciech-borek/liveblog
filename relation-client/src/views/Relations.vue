<template>
  <v-container class="d-flex justify-center align-center" fluid>
    <v-progress-circular
        v-if="isLoading"
        indeterminate
        color="primary"
        size="64"
    ></v-progress-circular>

    <Table v-else
           :options.sync="options"
           :pagination="pagination"
           :columns="columns"
           :items="relations"
           @update:options="handleOptionsUpdate"
    />
  </v-container>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from 'vue';
import Table from '../components/Table.vue';
import { Relation } from '../models';
import { getStatusTranslation } from '../enum/RelationStatusTranslation';
import { useLoadingStore } from '../store/loadingStore.ts';
import { RelationService } from '../services/RelationService';
import { Pagination } from '../services/Pagination.ts';

export default defineComponent({
  name: 'RelationView',
  components: {
    Table,
  },

  setup() {
    const columns = ref<{ title: string, key: string, value?: (item: any) => string }[]>([
      { title: 'Nazwa', key: 'title' },
      { title: 'Status', key: 'status', value: item => getStatusTranslation(item.status) },
    ]);

    const loadingStore = useLoadingStore();
    const relations = ref<Relation[]>([]);
    const pagination = ref<Pagination | null>(null);
    const isLoading = computed(() => loadingStore.isLoading);
    const options = ref({
      page: 1,
      itemsPerPage: 10,
      sortBy: [],
      sortDesc: [],
    });

    const fetchData = async () => {
      try {
        // loadingStore.startLoading();
        const result = await RelationService.getRelations(options.value.page, options.value.itemsPerPage);
        relations.value = result.data;
        pagination.value = result.pagination;
      } finally {
        // loadingStore.stopLoading();
      }
    };

    const handleOptionsUpdate = (newOptions: any) => {
      if (JSON.stringify(newOptions) !== JSON.stringify(options.value)) {
        options.value = newOptions;
        fetchData();
      }
    };

    return {
      columns,
      relations,
      pagination,
      isLoading,
      options,
      handleOptionsUpdate,
    };
  },
});
</script>