<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <PostForm @add-post="addPost"/>
        <v-divider class="my-4"></v-divider>
        <v-list two-line>
          <v-list-item-group v-if="relationData.postsUnpublished.length">
            <v-list-item
                v-for="(post, index) in relationData.postsUnpublished"
                :key="index"
            >
              <v-list-item-content>
                <v-list-item-subtitle>{{ post.content }}</v-list-item-subtitle>
              </v-list-item-content>
              <v-list-item-action>
<!--                <v-btn @click="publishPost(index)" color="green" icon>-->
<!--                  <v-icon-->
<!--                      size="small"-->
<!--                      class="me-2"-->
<!--                      color="primary"-->
<!--                  >-->
<!--                    mdi-check-->
<!--                  </v-icon>-->
<!--                </v-btn>-->
              </v-list-item-action>
            </v-list-item>
          </v-list-item-group>
          <v-list-item v-else>No posts to publish</v-list-item>
        </v-list>
      </v-col>
      <v-col cols="12" md="6">
        <v-divider class="my-4"></v-divider>
        <v-list>
          <v-list-item-group v-if="relationData.postsPublished.length">
            <v-list-item
                v-for="(post, index) in relationData.postsPublished"
                :key="index"
            >
              <v-list-item-content>
                <v-list-item-subtitle>{{ post.content }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
          <v-list-item v-else>No posts published</v-list-item>
        </v-list>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import {reactive} from 'vue';
import PostForm from '@/components/Relation/PostForm.vue';
import {useRoute} from 'vue-router';
import {PostService} from '@/services/PostService.ts';
import {Relation} from "@/models/index.ts";

const route = useRoute();
const relationId = route.params.id;
const initialData = route.meta.relationData as Relation

const relationData = reactive({
  postsUnpublished: initialData.postsUnpublished || [],
  postsPublished: initialData.postsPublished || []
});

const addPost = async (post: { content: string }) => {
  try {
    const newPost = {
      relationId,
      content: post.content,
      isPublished: false,
    }
    await PostService.create(newPost);
    relationData.postsUnpublished.push(newPost);
  } catch (error) {
    console.error('Error:', error);
  }
};

const publishPost = (index: number) => {
  const postToPublish = relationData.postsUnpublished.splice(index, 1)[0];
  relationData.postsPublished.push(postToPublish);
};
</script>
