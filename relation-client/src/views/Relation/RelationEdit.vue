<template>
  <v-row>
    <v-col cols="12">
      <RelationForm
          :isEdit=true
          :initialData="relationData"
          @submit="handleSubmit"
          @cancel="handleCancel"
      />
    </v-col>
  </v-row>
</template>

<script setup lang="ts">
import RelationForm from "@/components/Relation/RelationForm.vue";
import router from "@/router/index.ts";
import {RelationService} from "@/services/RelationService.ts";
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";

interface RelationFormData {
  title: string;
}

const relationId = router.currentRoute.value.params.id;

const route = useRoute();
const relationData = route.params.relationData;

const handleSubmit = async (data: RelationFormData) => {
  try {
    await RelationService.update(relationId, data);
    await router.push({name: 'relations'});
  } catch (error) {
    console.error('Error:', error);
  }
};

const handleCancel = () => {
  router.push({name: 'relations'});
};

</script>