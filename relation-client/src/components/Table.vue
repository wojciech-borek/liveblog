<template>
  <v-container>
    <v-data-table
        :headers="columns"
        :items="items"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Relacje</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
      </template>
    </v-data-table>
  </v-container>
</template>
<script setup lang="ts">
import {ref} from "vue";
import {Relation} from "../models";

const props = defineProps<{
  columns: ref<{ title: string, key: string }[]>,
  items: Array<Relation>
}>()
</script>