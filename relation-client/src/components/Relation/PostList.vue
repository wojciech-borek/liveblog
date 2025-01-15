<template>
  <v-list-item-group v-if="items.length">
    <v-list>
      <v-card
          v-for="(post, index) in items"
          :key="index"
          class="mx-auto my-3"
          :variant="'outlined'"
      >
        <v-card-text class="text-h5 py-2">
          {{ post.content }}
        </v-card-text>
        <v-card-actions>
          <div class="d-flex justify-end">
            <v-icon class="me-2" color="error" icon="mdi-delete" v-tooltip="'delete'" size="small"></v-icon>
            <v-icon class="me-2" icon="mdi-share-variant" v-tooltip="'publish'" size="small"></v-icon>
          </div>
        </v-card-actions>
      </v-card>
    </v-list>
  </v-list-item-group>
  <v-list-item v-else>No posts</v-list-item>
</template>

<script setup lang="ts">
import type {Post} from "@/models/index.ts";

const props = defineProps<{
  items: Post[];
}>();

</script>