<script src="<?= base_url("plugins/chart.js/Chart.min.js") ?>"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@0.5.7/src/index.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@0.5.7/chartjs-plugin-annotation.min.js"></script>
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
            var generateChart = (el, title, labels, datasets, type) => {
                //Cek type parameter
                let baku_mutu = 0;
                let is_line_active = true;
                switch (type) {
                    case 'NOx':
                    case 'SO2':
                        baku_mutu = 550;
                        break;
                    case 'PM':
                        baku_mutu = 100;
                        break;
                    default:
                        is_line_active = false
                        break;
                }
                console.log((is_line_active ? 'afterDatasetsDraw' : null))
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
                            },
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        annotation: {
                            annotations: [{
                                type: 'line',
                                mode: 'horizontal',
                                scaleID: 'y-axis-0',
                                value: baku_mutu,
                                borderColor: '#EF4444',
                                borderWidth: 2,
                                label: {
                                    enabled: true,
                                    content: `Ambang Baku Mutu ${type}`
                                }
                            }],
                            drawTime: (is_line_active ? 'afterDatasetsDraw' : null)
                        }
                    }

                });
                return myChart;
            }
            var requestGraphic = (data = {}) => {
                $.ajax({
                    url: `<?= base_url('graphic/api/' . $id . (@$parameter->id != null ? "/" . @$parameter->id : "")) ?>`,
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
                        let type = `<?= @explode(" ", $parameter->name)[1] ?>`;
                        values.map((value_correction, index) => {
                            let rawData = [];
                            let data = value_correction?.data;
                            type = value_correction?.label?.split(" ")[1];
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
                                date_master.map((value_correction, index) => {
                                    if (date_master[index] != date) {
                                        date_master.push(date);
                                    }
                                })
                                rawData.push(parseFloat(val.value_correction));
                            });
                            let dataset = {
                                label: value_correction?.label,
                                data: rawData,
                                backgroundColor: randomColor(`rgba`),
                                borderColor: randomColor(),
                                borderWidth: 1
                            };
                            datasets.push(dataset);
                        });
                        generateChart($('#disGraph'), "DIS Data", labels, datasets, type);
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
                requestGraphic(data);
            })
        } catch (err) {
            console.error(err);
        }
    });
</script>