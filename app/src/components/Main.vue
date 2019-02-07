<template>
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
</template>
