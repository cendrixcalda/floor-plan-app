<style lang="scss" scoped>
@import "@/_variables.scss";

#notifications {
  animation-fill-mode: forwards;
  @include flexCenteredXY;
  width: 100%;
  padding: 10px;
  margin: 20px 0;
  cursor: pointer;
  color: $secColor;
}

.success {
  background: $successColor;
  animation: fadeElement 0s ease-in 5s forwards;
}

.warning {
  background: $warningColor;
  animation: fadeElement 0s ease-in 20s forwards;
}

.error {
  background: $errorColor;
  animation: fadeElement 0s ease-in 20s forwards;
}
</style>

<template>
  <section
    id="notifications"
    :class="notifType"
    @click="notifMessageClone = null"
    v-if="notifMessageClone"
  >{{ notifMessageClone }}</section>
</template>

<script>
export default {
  props: {
    notifMessage: String,
    notifType: String,
  },
  data() {
    return {
      notifMessageClone: this.notifMessage,
    };
  },
};
</script>