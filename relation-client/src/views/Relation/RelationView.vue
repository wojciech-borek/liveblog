<template>
  <v-row>
    <v-col cols="12" md="6">
      <PostForm :isLoading="isLoading" @add-post="addPost"/>
    </v-col>
    <v-col cols="12" md="6">
      <v-tabs v-model="tab" background-color="indigo" dark>
        <v-tab>Published Posts</v-tab>
        <v-tab>Unpublished Posts</v-tab>
      </v-tabs>
      <v-window v-model="tab">
        <v-window-item>
          <PostList v-if="!isLoading" :items="postsPublished"/>
        </v-window-item>
        <v-window-item>
          <PostList v-if="!isLoading" :items="postsUnpublished"/>
        </v-window-item>
      </v-window>
    </v-col>
  </v-row>
</template>

<script setup lang="ts">
import {reactive, onMounted, ref, onUnmounted} from 'vue';
import PostForm from '@/components/Relation/PostForm.vue';
import {useRoute} from 'vue-router';
import {PostService} from '@/services/PostService.ts';
import {RelationService} from '@/services/RelationService.ts';
import {Relation} from "@/models/index.ts";
import PostList from "@/components/Relation/PostList.vue";
import {Post} from '../../models';
import {v4 as uuidv4} from 'uuid';
import {subscribeToMercure} from "@/services/Mercure.ts";


const route = useRoute();
const relationId = route.params.id;

const tab = ref(0);
const postsUnpublished = ref<Post[]>([])
const postsPublished = ref<Post[]>([])
const isLoading = ref(true)

const fetchRelation = async () => {
  isLoading.value = true
  try {
    const response = await RelationService.getRelation(route.params.id as string)
    let relation: Relation = response.data
    postsUnpublished.value = sortedPosts(relation.postsUnpublished)
    postsPublished.value = sortedPosts(relation.postsPublished)
  } catch (error) {
    console.error('Error:', error);
  } finally {
    isLoading.value = false
  }
}

const sortedPosts = (posts: Post[]): Post[] => {
  return [...posts].sort((a: Post, b: Post) => (b.position ?? 0) - (a.position ?? 0));
}

let eventSource: EventSource;

const updatePost = (data: any, posts: Post[]) => {
  const index = posts.findIndex((post) => post.temporaryId === data.temporaryId);
  if (index !== -1) {
    const updatedPost = { ...posts[index], ...data };
    updatedPost.status = '';
    posts[index] = updatedPost;
  }
}
const splicePost = (key: string, temporaryId: string, posts: Post[]) => {
  const index = posts.findIndex(post => post[key] === temporaryId);
  if (index !== -1) {
    posts.splice(index, 1);
  }
}

onMounted(() => {
  const topic = '/relation/' + route.params.id;
  eventSource = subscribeToMercure(topic, (message: any) => {
    console.log(message)
    const { data } = message;
    if (data) {
      updatePost(data, postsPublished.value);
      updatePost(data, postsUnpublished.value);
    }
  });
  fetchRelation()
})

onUnmounted(() => {
  if (eventSource) {
    eventSource.close();
  }
});

const addPost = async (isPublished: boolean, post: { content: string }) => {
  const temporaryId = uuidv4();
  const newPost = {
    id: "",
    content: post.content,
    temporaryId: temporaryId,
    status: 'in_sync',
    isPublished: isPublished,
    position: isPublished ? postsPublished.value.length + 1 : postsUnpublished.value.length + 1
  };

  try {
    isPublished ? postsPublished.value.unshift(newPost) : postsUnpublished.value.unshift(newPost);
    await PostService.create(relationId, newPost);
  } catch (error) {
    console.error('Error:', error);
    splicePost('temporaryId', temporaryId, isPublished ? postsPublished.value : postsUnpublished.value)
  }
};


const publishPost = async (post: Post, index: number) => {
  try {
    await PostService.update(post.id, {...post, isPublished: true});
    fetchRelation()
  } catch (error) {
    console.error('Error publishing post:', error);
  }
};
</script>
