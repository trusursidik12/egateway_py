<script src="<?= base_url("plugins/chart.js/Chart.min.js") ?>"></script>
<script>
    $(document).ready(function() {
        try {
            var randomColor = (type = 'hex') => {
                let color, r, g, b;
                if (type == 'hex') {
                    let hexColor = Math.floor(Math.random() * 16777215).toString(16);
                    color = `#${hexColor}`;
                    return color;
                }
                r = Math.floor(Math.random() * 255);
                g = Math.floor(Math.random() * 255);
                b = Math.floor(Math.random() * 255);
                color = `rgba(${r},${g},${b},0.2)`;
                return color;
            }
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            var generateChart = (el, title, labels, datasets) => {
                var myChart = new Chart(el, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        title: {
                            display: true,
                            text: title
                        },
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
                return myChart;
            }
            var requestGraphic = (data = {}) => {
                $.ajax({
                    url: `<?= base_url('graphic/api/' . $id . ($param_id != null ? "/" . $param_id : "")) ?>`,
                    type: 'post',
                    dataType: 'json',
                    data: data,
                    success: function(response) {

                        if (response?.success === false) {
                            Toast.fire({
                                type: `error`,
                                title: `Error : ${response?.message}`
                            });
                            return;
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
                        let date_master = [];
                        values.map((value, index) => {
                            let rawData = [];
                            let data = value?.data;
                            data.map((val, idx) => {
                                let time_group = val?.time_group;
                                time_group = new Date(time_group);
                                split_time_group = time_group.toLocaleString('id')?.split(" ");
                                let date = split_time_group[0];
                                let time = split_time_group[1];
                                labels[idx] = time;
                                if (date_master.length < 1) {
                                    date_master.push(date);
                                }
                                date_master.map((value, index) => {
                                    if (date_master[index] != date) {
                                        date_master.push(date);
                                    }
                                })
                                rawData.push(parseFloat(val.value));
                            });
                            let dataset = {
                                label: value?.label,
                                data: rawData,
                                backgroundColor: randomColor(`rgba`),
                                borderColor: randomColor(),
                                borderWidth: 1
                            };
                            datasets.push(dataset);
                        });
                        generateChart($('#disGraph'), "DIS Data", labels, datasets);
                        console.log(date_master);
                        let html_date = ``;
                        if (date_master.length > 1) {
                            html_date += `${date_master[0]} - ${date_master[date_master.length -1]}`;
                        } else {
                            html_date += `${date_master[0] != undefined ? date_master[0] : ''}`;
                        }
                        $('#datemaster').html(html_date);


                    }
                })
            }
            requestGraphic();
            $('#filter').submit(function(e) {
                e.preventDefault();
                let data = $(this).serialize();
                console.log(data);
                requestGraphic(data);
            })
        } catch (err) {
            console.error(err);
        }
    });
</script>