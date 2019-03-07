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
      Tableau,
  },

}
</script>
