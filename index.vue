<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>VO_royal</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <!-- demo root element -->
  <div id="app">

    <table>
      <thead>
      <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Famille</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="result in results">
        <td>{{result.nom}}</td>
        <td>{{result.prenom}}</td>
        <td>{{result.famille}}</td>
      </tr>
      </tbody>
    </table>

  </div>

</body>

<!-- JQuery -->
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <!-- Axio -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!-- Vue JS -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<!-- Main JS -->
<script src="assets/js/script.js"></script>

</html>
