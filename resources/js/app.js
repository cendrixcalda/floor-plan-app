require("./bootstrap");

window.Vue = require("vue");

Vue.component("login", require("./components/Login.vue").default);
Vue.component("nav-bar", require("./components/Navbar.vue").default);
Vue.component("floor-plans", require("./components/FloorPlans.vue").default);
Vue.component("users", require("./components/Users.vue").default);

const app = new Vue({
    el: "#app"
});
