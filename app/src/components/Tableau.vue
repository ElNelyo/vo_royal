<template>
    <div id="tableau">
        <h1>Tableau</h1>
        <input type="text" placeholder="Rechercher..." v-model="recherche"/>
        <table>
            <thead>
            <tr>
                <th v-for="col in columns" v-on:click="trieTableau(col)">{{col}}
                    <div  v-if="col == sortColumn" v-bind:class="[alphabetique ? 'arrow asc' : 'arrow dsc']"></div>
                </th>
            </tr>
            </thead>
            <tbody >
            <tr v-for="row in filtrage">
                <td>{{row["id"]}}</td>
                <td>{{row["titre"]}}</td>
                <td>{{row["priorite"]}}</td>
                <td>{{row["personne"]}}</td>

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
                currentPage: 1,
                elementsPerPage: 3,
                alphabetique: false,
                sortColumn: '',
                rows: [],
                recherche: '',
            }
        },
        mounted() {
            axios.get("http://127.0.0.1/vo_royal/api/intervention/read.php").then(response => {
                this.rows = response.data.records
            })

        },
        methods: {
            "trieTableau": function sortTable(col) {
                if (this.sortColumn === col) {
                    this.alphabetique = !this.alphabetique;
                } else {
                    this.alphabetique = true;
                    this.sortColumn = col;
                }

                var alphabetique = this.alphabetique;

                this.rows.sort(function (a, b) {
                    if (a[col] > b[col]) {
                        if (alphabetique) {
                            return 1
                        } else {
                            return -1
                        }
                    } else if (a[col] < b[col]) {
                        if (alphabetique) {
                            return -1
                        } else {
                            return 1
                        }
                    }
                    return 0;
                })
            }
        },
        computed: {
            "columns": function columns() {
                if (this.rows.length === 0) {
                    return [];
                }
                var colonnes = Object.keys(this.rows[0]);
                colonnes.splice(2, 1);
                return colonnes;
            },
            'filtrage' : function (){
                var self=this;
                return this.rows.filter(function(row){
                    return ((row.titre.toLowerCase().indexOf(self.recherche.toLowerCase())>=0) ||
                            (row.personne.toLowerCase().indexOf(self.recherche.toLowerCase())>=0)||
                            (row.priorite.toLowerCase().indexOf(self.recherche.toLowerCase())>=0)||
                            (row.id.toLowerCase().indexOf(self.recherche.toLowerCase())>=0)

                    );
                });
            }
        }
    }
</script>

