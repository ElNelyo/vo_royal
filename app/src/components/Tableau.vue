<template>
    <div id="tableau">
        <h1>Tableau</h1>
        <input type="text" placeholder="Rechercher..." v-model="recherche"/>
        <table>
            <thead>
            <tr>
                <th v-for="col in columns" v-on:click="trieTableau(col)">{{col}}
                    <div v-if="col == sortColumn" v-bind:class="[alphabetique ? 'arrow asc' : 'arrow dsc']"></div>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in filtrage">

                <td v-if="editmode && row_to_edit == row && value_to_edit== row[`id`] && column_to_edit==`id`">
                    <input type="text" v-bind:value="row[`id`]" >
                </td>
                <td v-else  v-on:click="edit(row,row[`id`],`id`)">
                    {{row["id"]}}
                </td>
                <td v-if="editmode && row_to_edit == row && value_to_edit== row[`titre`] && column_to_edit==`titre`">
                    <input type="text" :value="row[`titre`]">
                </td>
                <td v-else  v-on:click="edit(row,row[`titre`],`titre`)">
                    {{row["titre"]}}
                </td>
                <td v-if="editmode && row_to_edit == row && value_to_edit== row[`priorite`]&& column_to_edit==`priorite`">
                    <input type="text" :value="row[`priorite`]">
                </td>
                <td v-else  v-on:click="edit(row,row[`priorite`],`priorite`)">
                    {{row["priorite"]}}
                </td>

                <td >
                    {{row["personne"]}}
                </td>




            </tr>
            </tbody>
        </table>
        <div class="pagination">
            <div class="number"
                 v-for="i in num_pages()"
                 v-bind:class="[i === currentPage ? 'active' : '']"
                 v-on:click="change_page(i)">{{i}}
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: 'tableau',
        data() {
            return {
                editmode: false,
                row_to_edit: null,
                value_to_edit: null,
                column_to_edit : null,
                currentPage: 1,
                elementsPerPage: 2,
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
        watch: {
            'mon_id': function(newVal, oldVal) {
                console.log('value changed from ' + oldVal + ' to ' + newVal);
            }
        },

        methods: {
            "change_page": function change_page(page) {
                this.currentPage = page;
            },
            "num_pages": function num_pages() {
                return Math.ceil(this.rows.length / this.elementsPerPage);
            },
            "edit": function edit(row,value,col) {
                this.row_to_edit = row;
                this.value_to_edit= value;
                this.column_to_edit = col;
                if (this.editmode) {
                    this.editmode = false;
                } else {
                    this.editmode = true;
                }

            },
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
            'filtrage': function () {
                var self = this;
                var filtered = this.rows.filter(function (row) {
                    return ((row.titre.toLowerCase().indexOf(self.recherche.toLowerCase()) >= 0) ||
                        (row.personne.toLowerCase().indexOf(self.recherche.toLowerCase()) >= 0) ||
                        (row.priorite.toLowerCase().indexOf(self.recherche.toLowerCase()) >= 0) ||
                        (row.id.toLowerCase().indexOf(self.recherche.toLowerCase()) >= 0)

                    );
                });
                var start = (this.currentPage - 1) * this.elementsPerPage;
                var end = start + this.elementsPerPage;
                return filtered.slice(start, end);

            }
        },
        'watch': {
            'id': function(newVal, oldVal) {
                console.log('value changed from ' + oldVal + ' to ' + newVal);
            }
        }
    }
</script>

