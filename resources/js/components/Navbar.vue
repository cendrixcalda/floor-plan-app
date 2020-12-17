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
        padding: 15px 20px;
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
            href="/floorplans"
            class="tab"
            :class="{ active: activeTab == 'floorplans' }"
            @click="setNewActiveTab('floorplans')"
            >Floor Plans</a
        >
        <a
            href="/users"
            class="tab"
            :class="{ active: activeTab == 'users' }"
            @click="setNewActiveTab('users')"
            v-if="userType && userType == 'Admin'"
            >Users</a
        >
        <a href="/logout" class="tab tab-end">Logout</a>
    </nav>
</template>

<script>
export default {
    props: {
        userAuth: Object,
    },
    data() {
        return {
            activeTab: "floorplans",
            userType: null,
        };
    },
    created() {
        if(this.userAuth) {
            this.userType = this.userAuth.user_type;
        }
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
            this.activeTab = currentUrl ? currentUrl : "floorplans";
        }
    }
};
</script>
