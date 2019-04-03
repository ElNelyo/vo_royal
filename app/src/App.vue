<template>
  <div id="app">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
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
