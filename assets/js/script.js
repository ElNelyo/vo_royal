const vm = new Vue({
    el: '#app',
    data: {
        results: []
    },
    mounted() {
        axios.get("http://127.0.0.1/CESI/vo_royal/api/personne/read.php").then(response => {
            this.results = response.data.records
    })
    }
});