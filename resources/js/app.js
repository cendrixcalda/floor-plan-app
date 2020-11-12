require("./bootstrap");

window.Vue = require("vue");

Vue.component("nav-bar", require("./components/Navbar.vue").default);
Vue.component("floor-plans", require("./components/FloorPlans.vue").default);

const app = new Vue({
    el: "#app"
});
