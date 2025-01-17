<template>
    <v-row>
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
            <PostList v-if="relation" :items="relation.postsPublished"/>
          </v-window-item>
          <v-window-item>
            <PostList v-if="relation" :items="relation.postsUnpublished"/>
          </v-window-item>
        </v-window>
      </v-col>
    </v-row>
</template>

<script setup lang="ts">
import {reactive, onMounted, ref} from 'vue';
import PostForm from '@/components/Relation/PostForm.vue';
import {useRoute} from 'vue-router';
import {PostService} from '@/services/PostService.ts';
import {RelationService} from '@/services/RelationService.ts';
import {Relation} from "@/models/index.ts";
import PostList from "@/components/Relation/PostList.vue";
import { Post } from '../../models';

const route = useRoute();
const relationId = route.params.id;

const tab = ref(0);
const relation = ref<Relation | null>(null)
const isLoading = ref(true)

const fetchRelation = async () => {
    isLoading.value = true
    try {
        const response = await RelationService.getRelation(route.params.id as string)
        relation.value = response.data
    } catch (error) {
      console.error('Error:', error);
    } finally {
        isLoading.value = false
    }
}

onMounted(() => {
    fetchRelation()
})

const addPost = async (isPublished: boolean, post: { content: string }) => {
  try {
    const newPost = {
      relationId,
      content: post.content,
      isPublished,
    }
    await PostService.create(newPost);
    fetchRelation()
  } catch (error) {
    console.error('Error:', error);
  }
};

const publishPost = async (post: Post, index: number) => {
  try {
    await PostService.update(post.id, { ...post, isPublished: true });
    fetchRelation()
  } catch (error) {
    console.error('Error publishing post:', error);
  }
};
</script>
