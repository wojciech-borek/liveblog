<template>
  <v-app>
    <v-main>
      <v-container>
        <RouterView/>
        <Navbar/>
      </v-container>
    </v-main>
  </v-app>
</template>

<script lang="ts">

import {RouterView} from 'vue-router'
import Navbar from './components/Navbar.vue'
import { defineComponent} from 'vue';

export default defineComponent({
  setup() {},
});
</script>
