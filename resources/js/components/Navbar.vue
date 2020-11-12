<style lang="scss" scoped>
@import "@/_variables.scss";

nav {
  display: flex;
  width: 100%;
  background: $secColor;
  box-shadow: 0 4px 2px -2px $lightGray;
  padding: 0 20px;

  .tab {
    transition: 0.3s;
    cursor: pointer;
    outline: none;
    color: $terColor;
    white-space: nowrap;
    padding: 15px 30px;
    border-bottom: 3px solid $secColor;

    &.active {
      border-color: $priColor;
      color: $priColor;
    }

    &.tab-end {
      margin-left: auto;
    }

    &:hover,
    &:focus {
      border-color: $lightGray;
      color: $lightGray;
    }
  }
}
</style>

<template>
  <nav>
    <a
      href="/home"
      class="tab"
      :class="{ active: activeTab == 'home' }"
      @click="setNewActiveTab('home')"
    >Home</a>
    <a
      href="/user-management"
      class="tab"
      :class="{ active: activeTab == 'user-management' }"
      @click="setNewActiveTab('user-management')"
    >User Management</a>
    <a href="/" class="tab tab-end">{{ logTitle }}</a>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      activeTab: "home",
      logTitle: "Logout",
    };
  },
  mounted() {
    this.setActiveTab();
  },
  methods: {
    setNewActiveTab(tab) {
      this.activeTab = tab;
    },
    setActiveTab() {
      let currentUrl = window.location.pathname;
      currentUrl = currentUrl.substring(1);
      this.activeTab = currentUrl ? currentUrl : "home";
    },
  },
};
</script>
