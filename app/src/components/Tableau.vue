<template>
    <div id="tableau">
        <h1>Tableau</h1>
        <table>
            <thead>
            <tr>
                <th v-for="col in columns" v-on:click="trieTableau(col)">{{col}}
                </th>
            </tr>
            </thead>
            <tbody >
            <tr v-for="row in rows">
                <td v-for="col in columns">{{row[col]}}</td>

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
                rows: []
            }
        },
        mounted() {
            axios.get("http://127.0.0.1/vo_royal/api/intervention/read.php").then(response => {
                this.rows = response.data.records
            })

        },
        methods:{
            "trieTableau": function sortTable(col) {
                if (this.sortColumn === col) {
                    this.alphabetique = !this.alphabetique;
                } else {
                    this.alphabetique = true;
                    this.sortColumn = col;
                }

                var alphabetique = this.alphabetique;

                this.rows.sort(function(a, b) {
                    if (a[col] > b[col]) {
                        return alphabetique ? 1 : -1
                    } else if (a[col] < b[col]) {
                        return alphabetique ? -1 : 1
                    }
                    return 0;
                })
            },
        },
        computed: {
            "columns": function columns() {
                if (this.rows.length == 0) {
                    return [];
                }
                var colonnes = Object.keys(this.rows[0]);
                delete colonnes[2];
                console.log(colonnes);
                return colonnes;
            }
        }
    }
</script>

