</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; nadea <?= date('Y') ?></strong> | All rights reserved.
</footer>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Chart.js UMD -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Plugin CDN Datalabels -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
<!-- Custom Chart Code -->
<script>
    $('.alert').alert().delay(3000).slideUp('slow');
</script>
<script>
    const baseUrl = "<?php echo base_url(); ?>";
    // Bar Chart
    const myChart = (chartType) => {
        $.ajax({
            url: baseUrl + 'dasbor/chart_data',
            dataType: 'json',
            method: 'get',
            success: data => {
                let chartX = [];
                let chartY = [];
                data.map(entry => {
                    chartX.push(entry.tahun);
                    chartY.push(entry.total_peserta_magang);
                });
                const chartData = {
                    labels: chartX,
                    datasets: [{
                        label: 'Total Peserta Magang',
                        data: chartY,
                        backgroundColor: ['lightblue', 'lightgreen', 'lightcoral'],
                        borderColor: ['blue', 'green', 'red'],
                        borderWidth: 1
                    }]
                };
                const ctx = document.getElementById('chartType').getContext('2d');
                const config = {
                    type: chartType,
                    data: chartData,
                    options: {
                        plugins: {
                            legend: {
                                labels: {
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    },
                                    color: '#000'
                                }
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                color: '#000',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                formatter: value => value
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    },
                                    color: '#000'
                                }
                            },
                            y: {
                                ticks: {
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    },
                                    color: '#000'
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels],
                };
                new Chart(ctx, config);
            }
        });
    };

    // Pie Chart
    const myPieChart = () => {
        $.ajax({
            url: baseUrl + 'dasbor/get_pie_chart_data',
            dataType: 'json',
            method: 'get',
            success: data => {
                let labels = [];
                let values = [];
                data.map(entry => {
                    labels.push(entry.asal_kampus_sekolah);
                    values.push(entry.jumlah);
                });
                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Asal Kampus/Sekolah',
                        data: values,
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                            '#FF9F40', '#E7E9ED', '#B39DDB', '#8D6E63', '#7986CB',
                            '#81C784', '#F06292', '#FFD54F', '#90CAF9', '#A1887F'
                        ],
                        borderColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                            '#FF9F40', '#E7E9ED', '#B39DDB', '#8D6E63', '#7986CB',
                            '#81C784', '#F06292', '#FFD54F', '#90CAF9', '#A1887F'
                        ],
                        borderWidth: 1
                    }]
                };
                const ctx = document.getElementById('pieChartType').getContext('2d');
                const config = {
                    type: 'pie',
                    data: chartData,
                    options: {
                        plugins: {
                            legend: {
                                labels: {
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    },
                                    color: '#000'
                                }
                            }
                        }
                    }
                };

                new Chart(ctx, config);
            }
        });
    };
    // Panggil Kedua Fungsi
    myChart('bar');
    myPieChart();
</script>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
<!-- jQuery -->
<script src="<?= base_url('assets/admin') ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/admin') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/admin') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/admin') ?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('assets/admin') ?>/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('admin/changeaccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
            }
        });
    });
</script>
</body>

</html>