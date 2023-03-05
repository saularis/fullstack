<script setup lang="ts">
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <v-app>
    <header>
      <div class="wrapper">
        <v-app-bar>
          <v-toolbar-title>My Weather App</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn router to="/">Home</v-btn>
        </v-app-bar>
      </div>
    </header>
    <v-container>
      <v-col col="8" class="mt-15">
        <RouterView />
      </v-col>
    </v-container>
  </v-app>
</template>
