<script setup lang="ts">
import { ref, onMounted } from "vue";
import WeatherTable from "@/components/WeatherTable.vue";

const apiResponse = ref([]);

const fetchData = async () => {
  const url = "http://localhost";
  const response = await fetch(url);
  const data = await response.json();
  return data;
};

onMounted(() => {
  fetchData().then((data) => {
    apiResponse.value = data;
  });
});
</script>

<template>
  <main>
    <weather-table
      v-if="apiResponse?.users?.length"
      :data="apiResponse"
    ></weather-table>
  </main>
</template>
