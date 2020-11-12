<template>
    <component :is="layout">
        <router-view />
    </component>
</template>

<script>
    import MainLayout from "../layouts/MainLayout";
    import AuthLayout from "../layouts/AuthLayout";
  export default {
    name: "App.vue",
    computed: {
      layout() {
          return (this.$route.meta.layout || 'auth') + '-layout'
      }
    },
      components: {MainLayout, AuthLayout}
  }
</script>

<style>
    :root {
        --yellow-color: #FFD64A;
    }
    * {
        padding: 0;
        margin: 0;
    }
    p {
        margin: 0;
    }
    @keyframes opacity {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }
    .invalid {
        border-color: #F44336!important;
    }
    .header__img {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: -1;
    }
    .form-control:focus.invalid {
        box-shadow: none;
        border-color: #F44336!important;
    }
    .auth-container {
        position: relative;
        overflow: hidden;
        min-height: 100vh;
    }
    .auth-img {
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
    }
    .auth-title {
        font-weight: 500;
        font-size: 36px;
        line-height: 41px;
        color: #052137;
        margin: 0;
    }
    .auth-btn {
        width: 250px;
        height: 50px;
        font-weight: 500;
        font-size: 20px;
        line-height: 50px;
        color: #FFFFFF;
        background: #052137;
        border-radius: 30px;
        display: block;
        border: none;
    }
    .header-background {
        background-size: contain;
        background-repeat: no-repeat;
    }
    .form-group {
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        position: relative;
        width: 85%;
        margin: 0 auto;
    }
    .form-group__img {
        position: absolute;
        left: 18px;
    }
    .form-group__input {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        background: #ffffff;
        border: none;
        padding-left: 50px;
    }
    .form-group__input::placeholder {
        font-size: 15px;
        line-height: 40px;
        color: #CACACA;
    }
</style>
