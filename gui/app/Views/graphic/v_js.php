<script src="<?= base_url("plugins/chart.js/Chart.min.js") ?>"></script>
<script>
    $(document).ready(function() {
        try {
            $.ajax({
                url: `<?= base_url('graphic/api/' . $id) ?>`,
                dataType: 'json',
                success: function(response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    if (response?.success === false) {
                        Toast.fire({
                            type: `error`,
                            title: `Error : ${response?.message}`
                        });
                        return;
                    }
                    var randomColor = () => {
                        let hexColor = Math.floor(Math.random() * 16777215).toString(16);
                        return `#${hexColor}`;
                    }
                    let values = response?.data;
                    if (values.length === 0) {
                        Toast.fire({
                            type: `error`,
                            title: `No data available`
                        });
                    }
                    let datasets = [];
                    let labels = [];
                    values.map((value, index) => {
                        let rawData = [];
                        let data = value?.data;
                        data.map((val, idx) => {
                            labels[idx] = val?.time_group;
                            rawData.push(parseFloat(val.value));
                        });
                        let dataset = {
                            label: value?.label,
                            data: rawData,
                            backgroundColor: 'rgba(255,255,255,0)',
                            borderColor: randomColor(),
                            borderWidth: 1
                        };
                        datasets.push(dataset);

                    });
                    var ctx = $('#graph');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            stacked: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            })
        } catch (err) {
            console.error(err);
        }
    });
</script>