<template>
    <v-row>
      <!-- Lewa kolumna z formularzem -->
      <v-col cols="12" md="6">
        <PostForm @add-post="addPost"/>
      </v-col>
      <v-col cols="12" md="6">
        <v-tabs v-model="tab" background-color="indigo" dark>
          <v-tab>Published Posts</v-tab>
          <v-tab>Unpublished Posts</v-tab>
        </v-tabs>
        <v-window v-model="tab">
          <v-window-item>
            <PostList :items="relationData.postsPublished"/>
          </v-window-item>
          <v-window-item>
            <PostList :items="relationData.postsUnpublished"/>
          </v-window-item>
        </v-window>
      </v-col>
    </v-row>
</template>

<script setup lang="ts">
import {reactive, ref} from 'vue';
import PostForm from '@/components/Relation/PostForm.vue';
import {useRoute} from 'vue-router';
import {PostService} from '@/services/PostService.ts';
import {Relation} from "@/models/index.ts";
import PostList from "@/components/Relation/PostList.vue";

const route = useRoute();
const relationId = route.params.id;
const initialData = route.meta.relationData as Relation

const relationData = reactive({
  postsUnpublished: initialData.postsUnpublished || [],
  postsPublished: initialData.postsPublished || []
});
const tab = ref(0);

const addPost = async (isPublished: true, post: { content: string }) => {
  try {
    const newPost = {
      relationId,
      content: post.content,
      isPublished: isPublished,
    }
    await PostService.create(newPost);
    isPublished ? relationData.postsPublished.push(newPost) : relationData.postsUnpublished.push(newPost);
  } catch (error) {
    console.error('Error:', error);
  }
};

const publishPost = (index: number) => {
  const postToPublish = relationData.postsUnpublished.splice(index, 1)[0];
  relationData.postsPublished.push(postToPublish);
};
</script>
