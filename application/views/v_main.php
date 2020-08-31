<style>
    .dashboard-row {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .dashboard-title {
        margin-top: 5px;
        margin-left: 40px;
    }

</style>

<body>
    <div class="container container-fluid">
        <br><br>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4>Total Pengisian Air Kapal</h4>
                    </div>
                    <div class="panel-content">
                        <div class="row dashboard-row">
                            <div class="col-sm-10">
                                <h4 class="dashboard-title">
                                    <?php #echo ($event) ? $event->nama : '-'; ?>
                                    <?php echo "Periode : ".date_format(date_create($period), 'F Y') ?>
                                </h4>
                                <h4 class="dashboard-title">
                                    <?php #echo ($event) ? date_format(date_create($event->tanggal_berakhir), 'd F Y') : '-'; ?>
                                    <?php if($air_kapal==0) echo "0 Ton"; else echo $air_kapal." Ton"; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4>Total Penggunaan Air Ruko</h4>
                    </div>
                    <div class="panel-content white-text x">
                        <div class="row dashboard-row">
                            <div class="col-sm-10">
                                <h4 class="dashboard-title">
                                    <?php #echo ($loker) ? $loker->nama_perusahaan : '-'; ?>
                                    <?php echo "Periode : ".date_format(date_create($period), 'F Y') ?>
                                </h4>
                                <h4 class="dashboard-title">
                                    <?php #echo ($loker) ? date_format(date_create($loker->tanggal_berakhir), 'd F Y') : '-'; ?>
                                    <?php if($air_ruko==0) echo "0 m3"; else echo $air_ruko." m3"; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>Total Pengantaran Air Darat</h4>
                    </div>
                    <div class="panel-content white-text x">
                        <div class="row dashboard-row">
                            <div class="col-sm-10">
                                <h4 class="dashboard-title">
                                    <?php #echo ($loker) ? $loker->nama_perusahaan : '-'; ?>
                                    <?php echo "Periode : ".date_format(date_create($period), 'F Y') ?>
                                </h4>
                                <h4 class="dashboard-title">
                                    <?php #echo ($loker) ? date_format(date_create($loker->tanggal_berakhir), 'd F Y') : '-'; ?>
                                    <?php if($air_darat==0) echo "0 Ton"; else echo $air_darat." Ton"; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>Realisasi Air Kapal Berdasarkan Agen</h4>
                    </div>
                    <div class="panel-content white-text x">
                        <div class="row dashboard-row">
                            <div class="col-sm-12">
                                <h4 class="dashboard-title">
                                    <?php echo "Periode : ".date_format(date_create($period), 'F Y') ?>
                                </h4>
                                <h4 class="dashboard-title">
                                    <canvas id="chartKapalContainer"></canvas>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>Realisasi Air Darat Berdasarkan Pengguna Jasa</h4>
                    </div>
                    <div class="panel-content white-text x">
                        <div class="row dashboard-row">
                            <div class="col-sm-12">
                                <h4 class="dashboard-title">
                                    <?php echo "Periode : ".date_format(date_create($period), 'F Y') ?>
                                </h4>
                                <h4 class="dashboard-title">
                                    <canvas id="chartDaratContainer"></canvas>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    Chart.defaults.global.plugins.datalabels.anchor = 'end';
    Chart.defaults.global.plugins.datalabels.align = 'end';

    var dynamicColors = function() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    };
    var dataKapal = <?php echo json_encode($tabelKapal)?>;
    var dataDarat = <?php echo json_encode($tabelDarat)?>;
    var colorKapal = [];
    var colorDarat = [];

    for(var i in dataKapal){
        colorKapal.push(dynamicColors());
    }

    for(var i in dataDarat){
        colorDarat.push(dynamicColors());
    }

    var ctxKapal = document.getElementById('chartKapalContainer').getContext('2d');
    var chartKapal = new Chart(ctxKapal, {
        type: 'bar',
        data: {
            labels: [
            <?php
                if (count($tabelKapal)>0) {
                    foreach ($tabelKapal as $data) {
                        echo "'" .$data['label'] ."',";
                    }
                }
            ?>
            ],
            datasets: [{
                label: 'Realisasi Air Kapal',
                backgroundColor: colorKapal,
                borderColor: '#36a2eb',
                data: [
                <?php
                    if (count($tabelKapal)>0) {
                    foreach ($tabelKapal as $data) {
                        echo $data['y'] . ", ";
                    }
                    }
                ?>
                ],
            }],
            options: {
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 15,
                        bottom: 0
                    }
                },
                legend: {
                    display: false
                },
                animation: {
                    duration: 1,
                    onProgress: function(animation) {
                        progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
                    },
                },
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                        beginAtZero: true,
                        display: false
                        }
                    }]
                },
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: Math.round,
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
        },
    });

    var ctxDarat = document.getElementById('chartDaratContainer').getContext('2d');
    var chartDarat = new Chart(ctxDarat, {
        type: 'bar',
        data: {
            labels: [
            <?php
                if (count($tabelDarat)>0) {
                    foreach ($tabelDarat as $data) {
                        echo "'" .$data['label'] ."',";
                    }
                }
            ?>
            ],
            datasets: [{
                label: 'Permintaan Air Darat',
                backgroundColor: colorDarat,
                borderColor: '#36a2eb',
                data: [
                <?php
                    if (count($tabelDarat)>0) {
                    foreach ($tabelDarat as $data) {
                        echo $data['y'] . ", ";
                    }
                    }
                ?>
                ]
            }],
            options: {
                animation: {
                    duration: 1,
                    onProgress: function(animation) {
                        progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
                    },
                },
                responsive: true,
                scales: {
                yAxes: [{
                    ticks: {
                    beginAtZero: true,
                    }
                }]
                },
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: Math.round,
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
        },
    });
</script>