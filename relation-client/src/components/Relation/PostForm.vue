<template>
  <v-form v-model="formValid" @submit.prevent="submitForm">
    <v-textarea
        v-model="newPost.content"
        label="Content"
        outlined
        :rules="[v => !!v || 'Content is required']"
    ></v-textarea>
    <v-btn :disabled="!formValid" color="primary" type="submit">Add post</v-btn>
  </v-form>
</template>

<script setup lang="ts">
import { ref, defineEmits } from 'vue';

const emit = defineEmits<{
  (e: 'add-post', post: { title: string; content: string }): void;
}>();

const formValid = ref(false);
const newPost = ref({
  content: ''
});

const submitForm = () => {
  if (newPost.value.content) {
    emit('add-post', { ...newPost.value });
    newPost.value.content = '';
  }
};
</script>

