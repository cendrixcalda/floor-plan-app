<style lang="scss" scoped>
@import "@/_variables.scss";

main {
  @include flexCenteredXY();
  width: 100vw;
  height: 100vh;
  padding: 20px;
}

.login-form {
  @include flexCenteredXY();
  @include card();
  flex-direction: column;
  border: 1px solid $lightGray;
  padding: 20px 40px;
  background: $secColor;
  width: 360px;

  span {
    width: 100%;
  }

  .title {
    @include flexCenteredXY();
    font-size: 25px;
    font-weight: bolder;
    margin: 10px 0 20px;
  }

  input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    outline: none;
    border: 1px solid $lightGray;
    border-radius: 3px;
    overflow: hidden;

    &:focus {
      border-color: $priColor;
    }
  }

  .input-password-container {
    width: 100%;
    position: relative;
    
    .input-password {
      padding: 10px 33px 10px 10px;
    }

    button {
      position: absolute;
      top: 26px;
      right: 10px;
      outline: none;
      border: none;
      background: transparent;
    }
  }

  .submit {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    outline: none;
    border: 1px solid $priColor;
    background: $priColor;
    color: $secColor;
    text-transform: uppercase;
    border-radius: 3px;
    overflow: hidden;
    font-weight: bold;

    &:hover, &:focus {
      background: $secColor;
      color: $priColor;
    }
  }
}

.errors {
  color: $errorColor;
  font-size: 14px;
}

.error-field {
  border-color: $errorColor !important;
}
</style>

<template>
  <main>
    <notifications-overlay
      :notif-message="notifMessage"
      :notif-type="notifType"
      :key="notifCounter"
    ></notifications-overlay>
    <form class="login-form" method="POST" @submit="validateLogin" action="login/submit">
        <div class="title">Welcome</div>
        <input 
          type="text" 
          name="username" 
          id="username" 
          :class="{ 'error-field': userError }"
          placeholder="username" 
          v-model.trim="username">
        <span class="errors" v-show="userError">{{ userError }}</span>
        <div class="input-password-container">
          <input 
            :type="passwordInputType" 
            name="password" 
            id="password"
            class="input-password"
            :class="{ 'error-field': passError }"
            placeholder="password" 
            v-model.trim="password">
          <button type="button" class="fas" :class="passwordInputType == 'password' ? 'fa-eye' : 'fa-eye-slash'" @click="showPassword()"></button>
        </div>
        <span class="errors" v-show="passError">{{ passError }}</span>
        <input class="submit" type="submit" value="Log In"/>
        <input type="hidden" name="_token" :value="csrf">
      </form>
    <!-- <section class="login-form">
      <div class="title">Welcome</div>
      <input 
        type="text" 
        name="username" 
        id="username" 
        :class="{ 'error-field': userError }"
        placeholder="username" 
        v-model.trim="username">
      <span class="errors" v-show="userError">{{ userError }}</span>
      <div class="input-password-container">
        <input 
          :type="passwordInputType" 
          name="password" 
          id="password"
          class="input-password"
          :class="{ 'error-field': passError }"
          placeholder="password" 
          v-model.trim="password">
        <button class="fas" :class="passwordInputType == 'password' ? 'fa-eye' : 'fa-eye-slash'" @click="showPassword()"></button>
      </div>
      <span class="errors" v-show="passError">{{ passError }}</span>
      <button @click="login()">Log in</button>
    </section> -->
  </main>
</template>

<script>
import NotificationsOverlay from "./Notifications-Overlay";

export default {
  components: {
    "notifications-overlay": NotificationsOverlay,
  },
  props: {
    notifMessageProp: String,
    notifTypeProp: String,
  },
  data() {
    return {
      notifMessage: "",
      notifType: "",
      notifCounter: 0,
      username: null,
      password: null,
      userError: null,
      passError: null,
      passwordInputType: 'password',
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    };
  },
  mounted() {
    if(this.notifMessageProp && this.notifTypeProp) {
      this.notifMessage = this.notifMessageProp;
      this.notifType = this.notifTypeProp;
      this.notifCounter++;
    }
  },
  methods: {
    validateLogin(e) {
      // this.preventSubmit = false;

      // let username = this.username;
      // let password = this.password;

      // //validations
      // this.userError = !username ? "Username is required." : null;
      // this.passError = !password ? "Password is required." : null;

      // if(this.userError || this.passError) {
      //   this.preventSubmit = true;
      //   e.preventDefault();
      // }

      // if(!this.preventSubmit) {

      // }

      if (this.username && this.password) {
        return true;
      }

      //validations
      this.userError = !this.username ? "Username is required." : null;
      this.passError = !this.password ? "Password is required." : null;

      e.preventDefault();
    },
    // login(url = "/login/submit") {
    //   let username = this.username;
    //   let password = this.password;

    //   //validations
    //   this.userError = !username ? "Username is required." : null;
    //   this.passError = !password ? "Password is required." : null;

    //   if(!this.userError && !this.passError) {
    //     axios
    //       .post(url, { username: username, password: password })
    //       .then((response) => {
    //         let data = response.data;

    //         this.notifMessage = data.notifMessage;
    //         this.notifType = data.notifType;
    //         this.notifCounter++;
    //       })
    //       .catch((errors) => {
    //         this.notifMessage = 
    //           "Error encountered while trying to log in.";
    //         this.notifType = "error";
    //         this.notifCounter++;
    //       });
    //   }
    // },
    showPassword() {
      this.passwordInputType = this.passwordInputType === 'password' ? 'text' : 'password';
    }
  }
};
</script>