        <footer class="main-footer text-sm">
            <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.0.2-pre
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/moment/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="<?= base_url() ?>assets/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/blockui/blockui.js"></script>
    <script src="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/toastr/toastr.min.js"></script>

    <?php 
        $plugin = isset($plugin) ? $plugin : [];
        if ($plugin) {
            foreach ($plugin as $row) {
                foreach ($row as $val) {
                    echo '<script src="'.base_url($val).'"></script>' . PHP_EOL;
                }
            }
        }

    echo '<script src="' . base_url() . 'core.js"></script>' . PHP_EOL;

        echo isset($ext) ? $ext : '';
        $js = isset($js) ? $js : [];
        if ($js) {
            for ($i = 0; $i < count($js); $i++) {
                echo '<script src="'.base_url($js[$i]).'?v='.rand().'"></script>' . PHP_EOL;
            }
        }
    ?>
    
</body>

</html>