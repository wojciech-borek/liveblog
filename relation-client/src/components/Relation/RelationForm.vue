<template>
  <v-form @submit.prevent="handleSubmit" v-model="isFormValid">
    <v-card variant="flat">
      <v-card-title>
        <span v-if="isEdit">Edit Relation</span>
        <span v-else>Create Relation</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12">
              <v-text-field
                  v-model="formData.title"
                  :rules="titleRules"
                  label="Title"
                  required
                  variant="outlined"
                  :error-messages="errors.title"
                  @input="clearError('title')"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
            color="grey-darken-1"
            variant="text"
            @click="handleCancel"
        >
          Cancel
        </v-btn>
        <v-btn
            color="primary"
            variant="elevated"
            type="submit"
            :disabled="!isFormValid"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-form>
</template>

<script setup lang="ts">
import {reactive, ref, watch} from 'vue';

interface FormData {
  title: string;
}

interface FormErrors {
  title: string[];
}

const props = defineProps<{
  isEdit: boolean,
  initialData?: { title: string }
}>();

const emit = defineEmits<{
  (e: 'submit', data: FormData): void;
  (e: 'cancel'): void;
}>();

const isFormValid = ref(false);

const formData = ref<{ title: string }>({
  title: props.initialData?.title || ''
});

const errors = reactive<FormErrors>({
  title: [],
});

watch(
  () => props.initialData,
  (newValue) => {
    if (newValue) {
      formData.value.title = newValue.title;
    }
  },
  { immediate: true }
);

const titleRules = [
  (v: string) => !!v || 'Relation title cannot be empty.',
  (v: string) => (v && v.length <= 255) || 'Relation title cannot exceed 255 characters.',
];
const clearError = (field: keyof FormErrors) => {
  errors[field] = [];
};

const resetForm = () => {
  formData.value.title = '';
  Object.keys(errors).forEach((key) => {
    errors[key as keyof FormErrors] = [];
  });
};

const handleSubmit = async () => {
  try {
    emit('submit', {...formData.value});
    resetForm();
  } catch (error) {
    if (error instanceof Error) {
      errors.title = [error.message];
    }
  }
};

const handleCancel = () => {
  resetForm();
  emit('cancel');
};

</script>