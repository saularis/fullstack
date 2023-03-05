import { createApp } from "vue";
import { createVuetify } from "Vuetify";
import { createPinia } from "pinia";
import "vuetify/styles";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { aliases, mdi } from "vuetify/iconsets/mdi";
import router from "./router";
import App from "./App.vue";
import "./assets/main.css";

const app = createApp(App);
const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: "mdi",
    aliases,
    sets: {
      mdi,
    },
  },
});

app.use(createPinia());
app.use(router);
app.use(vuetify);
app.mount("#app");
