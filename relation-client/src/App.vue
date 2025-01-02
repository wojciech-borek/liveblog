<script setup lang="ts">
import {RouterView} from 'vue-router'
import Navbar from './components/Navbar.vue'

</script>
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