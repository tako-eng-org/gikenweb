<template>
  <div class="container">
    <div>
      <!--      <Logo/>-->
<!--      <h1 class="title">-->
<!--        frontend-->
<!--      </h1>-->
      <Bbs></Bbs>
    </div>
    <section class="container">
<!--      <h1 class="h1">Nuxt Bootstrap</h1>-->
      <b-button variant="primary" href="./detail">詳細をみる</b-button>
      <NuxtLink to="./detail">go to detail</NuxtLink>
    </section>
    <!--      <div class="links">-->
    <!--        <a-->
    <!--          href="https://nuxtjs.org/"-->
    <!--          target="_blank"-->
    <!--          rel="noopener noreferrer"-->
    <!--          class="button&#45;&#45;green"-->
    <!--        >-->
    <!--          Documentation-->
    <!--        </a>-->
    <!--        <a-->
    <!--          href="https://github.com/nuxt/nuxt.js"-->
    <!--          target="_blank"-->
    <!--          rel="noopener noreferrer"-->
    <!--          class="button&#45;&#45;grey"-->
    <!--        >-->
    <!--          GitHub-->
    <!--        </a>-->
  </div>
</template>

<script>
import bbs from "../components/Bbs";

export default {
  components: {
    Bbs: bbs,
  }
}
</script>

<style>
/*
.container {
  margin: 0 auto;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.title {
  font-family: 'Quicksand',
  'Source Sans Pro',
  -apple-system,
  BlinkMacSystemFont,
  'Segoe UI',
  Roboto,
  'Helvetica Neue',
  Arial,
  sans-serif;
  display: block;
  font-weight: 300;
  font-size: 100px;
  color: #35495e;
  letter-spacing: 1px;
}

.subtitle {
  font-weight: 300;
  font-size: 42px;
  color: #526488;
  word-spacing: 5px;
  padding-bottom: 15px;
}

.links {
  padding-top: 15px;
}
*/
</style>
