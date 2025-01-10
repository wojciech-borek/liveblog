<template>
  <v-row>
    <v-col cols="12">
      <RelationForm
          @submit="handleSubmit"
          @cancel="handleCancel"
      />
    </v-col>
  </v-row>
</template>

<script lang="ts">
import {computed, defineComponent} from 'vue';
import RelationForm from "@/components/Relation/RelationForm.vue";
import router from "@/router/index.ts";
import {RelationService} from "@/services/RelationService.ts";

interface RelationFormData {
  title: string;
}

export default defineComponent({
  name: 'RelationCreate',

  components: {
    RelationForm,
  },

  setup() {
    const handleSubmit = async (data: RelationFormData) => {
      try {
        await RelationService.create(data);
        await router.push({name: 'relations'});
      } catch (error) {
        console.error('Error:', error);
      }
    };

    const handleCancel = () => {
      router.push({name: 'relations'});
    };

    return {
      handleSubmit,
      handleCancel,
    };
  },
});
</script>