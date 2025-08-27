import axios from "axios";
import Alpine from "alpinejs";
import Tagify from "@yaireo/tagify";
import "@yaireo/tagify/dist/tagify.css";

window.axios = axios;
window.Alpine = Alpine;
window.Tagify = Tagify;

Alpine.start();
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
