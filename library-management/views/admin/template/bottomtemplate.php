            <!-- start of bottom content -->
            </div>
            </body>
            <script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.bundle.min.js"></script>
            <script src="<?php echo $env_basepath ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
            <script src="<?php echo $env_basepath ?>assets/jsdelivr/popper.min.js"></script>
            <script src="<?php echo $env_basepath ?>assets/jsdelivr/bootstrap.min.js"></script>
            <script src="<?php echo $env_basepath ?>assets/jsdelivr/sweetalert2.all.min.js"></script>
            <script src="<?php echo $env_basepath ?>assets/jquery/jquery-3.6.4.min.js"></script>
            <script src="<?php echo $env_basepath; ?>assets/datatable/jquery.dataTables.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#data_table').DataTable();
                });
            </script>
            <script>
                function confirmLogout() {
                    Swal.fire({
                        title: 'Are you sure you want to logout?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, logout!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // User clicked "Yes, logout!" - Redirect to logout.php
                            window.location.href = '../../logout.php';
                        }
                    });
                }
            </script>

            </html>