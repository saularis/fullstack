<script setup>
// use attribute from parent component
import { ref, useAttrs } from "vue";
const attrs = useAttrs();
const users = attrs?.data?.users;
let alertMessage = ref("");

const handleUpdateRequest = (userId) => {
  // use fetch to call the api
  fetch(`/api/users/${userId}/update`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((data) => {
      if (data.status == 200) {
        alertMessage.value = "Weather data updated request received";
        setTimeout(() => {
          alertMessage.value = "";
        }, 3000);
      }
    })
    .catch((error) => {
      alertMessage.value = "Something went wrong. Please contact support";
      setTimeout(() => {
        alertMessage.value = "";
      }, 3000);
    });
};
</script>
<template>
  <div>
    <v-alert
      v-if="alertMessage"
      color="green"
      theme="dark"
      icon="mdi-firework"
      density="compact"
    >
      {{ alertMessage }}
    </v-alert>
    <v-table>
      <thead>
        <tr>
          <th class="text-left">Name</th>
          <th class="text-left">latitude</th>
          <th class="text-left">longitude</th>
          <th class="text-left">temperature</th>
          <th class="text-left">Last checked</th>
          <th class="text-left">Details</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.latitude }}</td>
          <td>{{ user.longitude }}</td>
          <td>{{ user.weather.temperature }}</td>
          <td>{{ user.weather.updated_at }}</td>
          <td>
            <v-dialog v-model="user.dialog" width="auto">
              <template v-slot:activator="{ props }">
                <v-btn color="primary" v-bind="props"> Open Dialog </v-btn>
              </template>

              <v-card>
                <v-card-text>
                  <v-row>
                    <v-col
                      cols="4"
                      v-for="(value, heading) in user.weather"
                      :key="value.id"
                    >
                      <v-card
                        color="primary"
                        height="100px"
                        width="100%"
                        class="float-left"
                      >
                        <v-card-title class="white--text">
                          <div>
                            <h3 class="headline mb-0">
                              {{ heading.replace("_", " ").toUpperCase() }}
                            </h3>
                            <div>{{ value }}</div>
                          </div>
                        </v-card-title>
                      </v-card>
                    </v-col>
                  </v-row>
                </v-card-text>
                <v-card-actions>
                  <v-btn color="primary" block @click="user.dialog = false"
                    >Close Dialog</v-btn
                  >
                </v-card-actions>
              </v-card>
            </v-dialog>
          </td>
          <td>
            <!-- Reload -->
            <v-btn
              color="primary"
              @click.stop="handleUpdateRequest(user.id)"
              :loading="attrs?.data?.loading"
            >
              Refresh
            </v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>
  </div>
</template>
