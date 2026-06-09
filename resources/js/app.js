import Alpine from "alpinejs";
import axios from "axios";
import * as bootstrap from "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";

globalThis.axios = axios;
globalThis.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

globalThis.axios.defaults.headers.common["X-CSRF-TOKEN"] = document
  .querySelector('meta[name="csrf-token"]')
  ?.getAttribute("content");

globalThis.Alpine = Alpine;
globalThis.bootstrap = bootstrap;

Alpine.start();
