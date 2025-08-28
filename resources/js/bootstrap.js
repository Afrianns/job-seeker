import axios from "axios";
import Alpine from "alpinejs";
import Tagify from "@yaireo/tagify";
import "@yaireo/tagify/dist/tagify.css";

window.axios = axios;
window.Alpine = Alpine;
window.Tagify = Tagify;

Alpine.start();
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
