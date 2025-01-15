<template>
  <v-form v-model="formValid">
    <v-textarea
        v-model="newPost.content"
        label="Content"
        outlined
        :rules="[v => !!v || 'Content is required']"
    ></v-textarea>
    <v-btn @click="submitForm(true)" :disabled="!formValid" color="primary" type="submit">Add post</v-btn>
    <v-btn @click="submitForm(false)" :disabled="!formValid" color="default" type="submit">Add draft</v-btn>
  </v-form>
</template>

<script setup lang="ts">
import {ref, defineEmits} from 'vue';

const emit = defineEmits<{
  (e: 'add-post', post: { title: string; content: string }): void;
}>();

const formValid = ref(false);
const newPost = ref({
  content: ''
});

const submitForm = (isPublished: boolean) => {
  if (newPost.value.content) {
    emit('add-post', isPublished, {...newPost.value});
    newPost.value.content = '';
  }
};
</script>

