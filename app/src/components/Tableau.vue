<template>
    <div id="tableau">
        <h1>Tableau {{rows.length }}</h1>
        <input type="text" placeholder="Rechercher..." v-model="recherche"/>
        <button @click="changeShow()">Ajouter une intervention</button>
        <table>
            <thead>
            <tr>
                <th v-for="col in columns" v-bind:key="col" v-on:click="trieTableau(col)">{{col}}
                    <div v-if="col == sortColumn" v-bind:class="[alphabetique ? 'arrow asc' : 'arrow dsc']"></div>
                    <input v-if="col==`titre` " type="text" placeholder="Rechercher par titre..."
                           v-model="recherche_titre"/>
                    <input v-if="col==`personne` " type="text" placeholder="Rechercher par personne..."
                           v-model="recherche_personne"/>
                    <input v-if="col==`id` " type="text" placeholder="Rechercher par id..."
                           v-model="recherche_id"/>
                    <input v-if="col==`priorite` " type="text" placeholder="Rechercher par priorite..."
                           v-model="recherche_priorite"/>

                </th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in filtrage" v-bind:key="row">

                <!--On donne pas la possibilité de modifier un id-->

                <!--<td v-if="editmode && row_to_edit == row && value_to_edit== row[`id`] && column_to_edit==`id`">-->
                <!--<input type="text" v-bind:value="row[`id`]">-->
                <!--</td>-->
                <!--<td v-else v-on:click="edit(row,row[`id`],`id`)">-->
                <!--{{row["id"]}}-->
                <!--</td>-->

                <td>{{row["id"]}}</td>

                <td v-if="editmode && row_to_edit == row && value_to_edit== row[`titre`] && column_to_edit==`titre`">
                    <input type="text" @change="update_titre(row[`id`], row)" v-bind:value="row[`titre`]"
                           name="input_titre">
                </td>
                <td v-else v-on:click="edit(row,row[`titre`],`titre`)">
                    {{row["titre"]}}
                </td>
                <td v-if="editmode && row_to_edit == row && value_to_edit== row[`priorite`]&& column_to_edit==`priorite`">
                    <input type="text" @change="update_priorite(row[`id`], row)" v-bind:value="row[`priorite`]"
                           name="input_priorite">
                </td>
                <td v-else v-on:click="edit(row,row[`priorite`],`priorite`)">
                    {{row["priorite"]}}
                </td>

                <td v-if="editmode && row_to_edit == row && value_to_edit== row[`personne`]&& column_to_edit==`personne`">
                    <select type="text" @change="update_personne(row[`id`], row)" v-bind:value="row[`personne`]"
                            name="select_personne" id="select_personne">

                        <option value="1">Lannister</option>
                        <option value="2">Sansa</option>

                    </select>

                </td>
                <td v-else v-on:click="edit(row,row[`personne`],`personne`)">
                    {{row["personne"]}}
                </td>

                <td>
                    <button @click="displayDetail(row[`detail`])">Voir detail</button>
                    <button @click="changeShowUpdate(row[`id`], row[`detail`],row[`titre`], row[`priorite`], row[`personne`])">
                        Modifier
                    </button>
                    <button @click="deleteIntervention(row[`id`])">Supprimer</button>

                </td>

            </tr>
            </tbody>
        </table>
        <div class="pagination">
            <div class="number"
                 v-for="i in num_pages()"
                 v-bind:class="[i === currentPage ? 'active' : '']"
                 v-on:click="change_page(i)"
                 :key="i"
            >{{i}}
            </div>
        </div>

        <div v-if="display_detail == true">
            <p>{{detail}}</p>
        </div>


        <div v-if="show_add == true">
            <input type="text" placeholder="Titre de l'intervention" id="intervention_titre">
            <textarea id="intervention_detail"></textarea>
            <input type="number" placeholder="Priorité" id="intervention_priorite">
            <select id="intervention_personne">
                <option value="1">Lannister</option>
                <option value="2">Sansa</option>
            </select>
            <button @click="addIntervention()">Valider</button>
        </div>

        <div v-if="show_update == true">
            <input type="text" placeholder="Titre de l'intervention" id="intervention_titre_update"
                   :value="titre_update">
            <textarea id="intervention_detail_update" v-model="detail_update "></textarea>
            <input type="number" placeholder="Priorité" id="intervention_priorite_update" :value="priorite_update">
            <select id="intervention_personne_update">
                <option value="1">Lannister</option>
                <option value="2">Sansa</option>
            </select>
            <button @click="updateIntervention(id_update)">Valider</button>
        </div>


    </div>


</template>
<script>


    import axios from 'axios'

    export default {
        name: 'tableau',
        data() {
            return {

                detail: '',
                display_detail: false,
                show_update: false,
                show_add: false,
                editmode: false,
                row_to_edit: null,
                value_to_edit: null,
                column_to_edit: null,
                currentPage: 1,
                elementsPerPage: 5,
                alphabetique: false,
                sortColumn: '',
                rows: [],
                recherche: '',
                recherche_titre: '',
                recherche_id: '',
                recherche_personne: '',
                recherche_priorite: '',
                titre_update: '',
                personne_update: '',
                detail_update: '',
                priorite_update: '',
                id_update: '',
            }
        },
        mounted() {
            axios.get("http://127.0.0.1/vo_royal/api/intervention/read.php").then(response => {
                this.rows = response.data.records
            })

        }, methods: {
            "updateIntervention": function updateIntervention(id) {
                var personne = document.getElementById("intervention_personne_update").value;
                axios.get("http://127.0.0.1/vo_royal/api/intervention/update.php?id=" + id + "&titre=" + this.titre_update + "&priorite=" + this.priorite_update + "&detail=" + this.detail_update + "&personne=" + personne).then(response => {
                    this.rows = response.data.records;
                    return response;
                });

            },
            "deleteIntervention": function deleteIntervention($id) {
                axios.get("http://127.0.0.1/vo_royal/api/intervention/delete.php?id=" + $id).then(response => {
                    this.rows = response.data.records;
                    return response;
                });

            },
            "displayDetail": function displayDetail($detail) {
                if (this.display_detail == true) {
                    this.detail = '';
                    this.display_detail = false;
                } else {
                    this.detail = $detail;
                    this.display_detail = true;
                }
                return null;

            },

            "addIntervention": function addIntervention() {
                var titre = document.querySelector("input[id=intervention_titre]").value;
                var priorite = document.querySelector("input[id=intervention_priorite]").value;
                var detail = document.querySelector("textarea[id=intervention_detail]").value;
                var personne = document.querySelector("select[id=intervention_personne]").value;
                axios.get("http://127.0.0.1/vo_royal/api/intervention/add.php?titre=" + titre + "&priorite=" + priorite + "&detail=" + detail + "&personne=" + personne).then(response => {
                    axios.get("http://127.0.0.1/vo_royal/api/intervention/read.php").then(response_2 => {
                        this.rows = response_2.data.records
                    })
                    return response;
                })
                return null;
            },
            "changeShowUpdate": function changeShowUpdate(id, detail, titre, priorite, personne) {
                this.priorite_update = priorite;
                this.personne_update = personne;
                this.detail_update = detail;
                this.id_update = id;
                this.titre_update = titre;
                if (this.show_update == true) {
                    this.show_update = false;
                } else {
                    this.show_update = true;
                }
                return null;
            },
            "changeShow": function changeShow() {
                if (this.show_add == true) {
                    this.show_add = false;
                } else {
                    this.show_add = true;
                }
                return null;
            },
            "update_titre": function update_titre(id, row) {
                const field = document.querySelector("input[name=input_titre]").value;
                axios.get("http://127.0.0.1/vo_royal/api/intervention/update.php?id=" + id + "&titre=" + field).then(response => {
                    row["titre"] = field;
                    return response;
                })
                return null;
            },
            "update_priorite": function update_titre(id, row) {
                const field = document.querySelector("input[name=input_priorite]").value;
                axios.get("http://127.0.0.1/vo_royal/api/intervention/update.php?id=" + id + "&priorite=" + field).then(response => {
                    row["priorite"] = field;
                    return response;
                })
                return null;
            },
            "update_personne": function update_personne(id, row) {
                const field = document.querySelector("select[name=select_personne]").value;
                var e = document.getElementById("select_personne");
                const field_display = e.options[e.selectedIndex].text;

                axios.get("http://127.0.0.1/vo_royal/api/intervention/update.php?id=" + id + "&personne=" + field).then(response => {
                    row["personne"] = field_display;
                    return response;
                })

            },
            "change_page": function change_page(page) {
                this.currentPage = page;
            },
            "num_pages": function num_pages() {
                return Math.ceil(this.rows.length / this.elementsPerPage);
            },
            "edit": function edit(row, value, col) {

                this.row_to_edit = row;
                this.value_to_edit = value;
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
                var filtered;

                filtered = this.rows.filter(function (row) {

                    return ((row.titre.toLowerCase().indexOf(self.recherche.toLowerCase()) >= 0) ||
                        (row.personne.toLowerCase().indexOf(self.recherche.toLowerCase()) >= 0) ||
                        (row.priorite.toLowerCase().indexOf(self.recherche.toLowerCase()) >= 0) ||
                        (row.id.toLowerCase().indexOf(self.recherche.toLowerCase()) >= 0)

                    );
                });
                if (this.recherche_id != "") {
                    filtered = this.rows.filter(function (row) {
                        return (row.id.toLowerCase().indexOf(self.recherche_id.toLowerCase()) >= 0)
                    })
                }
                if (this.recherche_titre != "") {
                    filtered = this.rows.filter(function (row) {
                        return (row.titre.toLowerCase().indexOf(self.recherche_titre.toLowerCase()) >= 0)
                    })
                }
                if (this.recherche_priorite != "") {
                    filtered = this.rows.filter(function (row) {
                        return (row.priorite.toLowerCase().indexOf(self.recherche_priorite.toLowerCase()) >= 0)
                    })
                }
                if (this.recherche_personne != "") {
                    filtered = this.rows.filter(function (row) {
                        return (row.personne.toLowerCase().indexOf(self.recherche_personne.toLowerCase()) >= 0)
                    })
                }
                var start = (this.currentPage - 1) * this.elementsPerPage;
                var end = start + this.elementsPerPage;
                return filtered.slice(start, end);

            }
        }
    }
</script>

