<template>
  <v-container>
    <Table :columns="columns" :items="relations"/>
  </v-container>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from 'vue';
import Table from '../components/Table.vue';
import {RelationService} from "../services/RelationService";
import {Relation} from "../models";
import {getStatusTranslation} from "../enum/RelationStatusTranslation";

export default defineComponent({
  name: "RelationView",
  components: {
    Table,
  },

  setup() {
    const columns = ref<{ title: string, key: string, value?: (item: any) => string }[]>([
      {title: 'Nazwa', key: 'title'},
      {title: 'Status', key: 'status', value: item => getStatusTranslation(item.status)},
    ]);

    const relations = ref<Relation[]>([]);

    const fetchData = async () => {
      try {
        relations.value = await RelationService.getRelations(1, 10);
      } catch (error) {
        console.error('Błąd podczas pobierania danych:', error);
      }
    };

    onMounted(() => {
      fetchData();
    });

    return {
      columns,
      relations,
    };
  },
});
</script>
