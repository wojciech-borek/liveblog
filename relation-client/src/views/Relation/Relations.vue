<template>
  <v-row>
    <v-col cols="12">
      <v-btn
          @click="navigateToCreate"
      >Create
      </v-btn>
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
      />
    </v-col>
  </v-row>
</template>

<script lang="ts">
import {defineComponent, ref} from 'vue';

import {getStatusTranslation} from "@/enum/RelationStatusTranslation.ts";
import {Relation} from "@/models/index.ts";
import {Pagination} from "@/services/Pagination.ts";
import {RelationService} from "@/services/RelationService.ts";
import Table from "@/components/Table.vue";
import router from "@/router/index.ts";

export default defineComponent({
  name: 'RelationView',
  components: {
    Table,
  },

  setup() {
    const columns = ref<{ title: string, key: string, sortable: boolean, value?: (item: any) => string }[]>([
      {title: 'Title', key: 'title', sortable: true,},
      {title: 'Status', key: 'status', sortable: false, value: item => getStatusTranslation(item.status)},
    ]);

    const isLoading = ref<Boolean>(false);
    const relations = ref<Relation[]>([]);
    const pagination = ref<Pagination>({
      totalCount: 0,
      totalPages: 0,
      currentPage: 1,
      perPage: 10,
    });

    const fetchData = async (options: {
      page: number;
      itemsPerPage: number;
      sortBy: string[];
    }) => {
      try {
        isLoading.value = true;
        const result = await RelationService.getRelations(options.page, options.itemsPerPage,options.sortBy);
        relations.value = result.data;
        pagination.value = result.pagination;
      } catch (error) {
        console.error('Error:', error);
      }finally {
        isLoading.value = false;
      }
    };

    const navigateToCreate = () => {
      router.push({name: 'relation-create'});
    };

    return {
      columns,
      relations,
      pagination,
      fetchData,
      isLoading,
      navigateToCreate
    };
  },
});
</script>