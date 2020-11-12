<style lang="scss" scoped>
@import "@/_variables.scss";

.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: 0.5s;
}

.slide-fade-leave-to {
  transform: translate(100%, 0);
  opacity: 0;
}

.slide-fade-enter {
  transform: translate(-100%, 0);
  opacity: 1;
}

#notifications {
  animation: fadeElement 0s ease-in 5s forwards;
  @include card;
  display: flex;
  white-space: wrap;
  top: 40px;
  right: 35px;
  width: max-content;
  max-width: 330px;
  min-width: 300px;
  min-height: 80px;
  position: fixed;
  z-index: 999;

  .close:before {
    content: "✕";
  }
  .close {
    position: absolute;
    font-size: 12px;
    top: 4px;
    right: 4px;
    cursor: pointer;
    padding: 3px 4px;
    border-radius: 50%;
    &:hover,
    &:focus {
      background: #666;
    }
  }

  .notif-head {
    display: inline-block;
    min-height: 100%;
    width: 35px;
  }

  .notif-body {
    @include flexCenteredX;
    flex-direction: column;
    background: $secColor;
    color: $terColor;
    padding: 15px 30px;
    width: calc(100% - 35px);

    .body-type {
      text-transform: uppercase;
      font-weight: bold;
      font-stretch: condensed;
      font-size: 17px;
    }
  }
}

.success {
  background: $successColor;
}

.warning {
  background: $warningColor;
}

.error {
  background: $errorColor;
}

@media (max-width: 675px) {
  #notifications {
    font-size: 14px;
    max-width: 270px;
    min-width: 270px;
    min-height: 50px;
    right: 15px;

    .notif-head {
      width: 30px;
    }

    .notif-body {
      width: calc(100% - 30px);
      padding: 10px 20px;

      .body-type {
        font-size: 16px;
      }
    }
  }
}

@media (max-width: 400px) {
  #notifications {
    font-size: 14px;
    max-width: 240px;
    min-width: 240px;
    min-height: 60px;
    right: 15px;

    .notif-head {
      width: 25px;
    }

    .notif-body {
      width: calc(100% - 25px);

      .body-type {
        font-size: 15px;
      }
    }
  }
}
</style>

<template>
  <transition name="slide-fade">
    <section id="notifications" @click="notifMessageClone = null" v-if="notifMessageClone">
      <span class="notif-body">
        <span class="body-type">{{ notifType }}</span>
        <span>{{ notifMessageClone }}</span>
      </span>
      <span class="notif-head" :class="notifType"></span>
      <span class="close"></span>
    </section>
  </transition>
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