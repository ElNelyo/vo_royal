<template>
    <div id="tableau">
        <h1>Tableau</h1>
        <table>
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Famille</th>
            </tr>
            </thead>
            <tbody v-model="results">
            <tr v-for="result in results">
                <td>{{result.nom}}</td>
                <td>{{result.prenom}}</td>
                <td>{{result.famille}}</td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: 'tableau',
        data() {
            return {
                results: []
            }
        },
        mounted() {
            axios.get("http://127.0.0.1/CESI/vo_royal/api/personne/read.php").then(response => {
                this.results = response.data.records
            })

        }
    }
</script>

