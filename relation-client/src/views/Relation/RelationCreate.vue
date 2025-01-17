<template>
  <v-row>
    <v-col cols="12">
      <RelationForm
          :isEdit=false
          :isLoading=isLoading
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

interface RelationFormData {
  title: string;
}
const isLoading = ref(false)

const handleSubmit = async (data: RelationFormData) => {
  isLoading.value = true;
  try {
    await RelationService.create(data);
    await router.push({name: 'relations'});
  } catch (error) {
    console.error('Error:', error);
  } finally{
    isLoading.value = false;
  }
};

const handleCancel = () => {
  router.push({name: 'relations'});
};

</script>