<template>
  <v-row>
    <v-col cols="12">
      <RelationForm
          :isEdit=true
          :isLoading="isLoading"
          :initialData="relation"
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

const route = useRoute();
const relation = ref<Relation | null>(null)
const isLoading = ref(true)
const error = ref<string | null>(null)


const fetchRelation = async () => {
    isLoading.value = true
    try {
        const response = await RelationService.getRelation(route.params.id as string)
        relation.value = response.data
    } catch (err) {
        error.value = 'Failed to fetch relation'
    } finally {
        isLoading.value = false
    }
}

onMounted(() => {
    fetchRelation()
})

const handleSubmit = async (data: RelationFormData) => {
  isLoading.value = true
  try {
    await RelationService.update(route.params.id as string, data);
    await router.push({name: 'relations'});
  } catch (error) {
    console.error('Error:', error);
  } finally {
        isLoading.value = false
  }
};


const handleCancel = () => {
  router.push({name: 'relations'});
};

</script>