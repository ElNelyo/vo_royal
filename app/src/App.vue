<template>
  <div id="app">
    <img alt="Vue logo" src="./assets/logo.png">
    <Tableau></Tableau>
  </div>
</template>

<script>
    import Tableau from './components/Tableau.vue'

export default {
  name: 'app',
  components: {
      Tableau
  },

}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
