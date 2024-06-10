<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
                        <?= $this->session->flashdata('pesan'); ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <a href="<?= base_url('user/tambahtestimonials') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"></i> Tambah testimonials</a></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>testimonials</th>
                                            <th>Status Perkawinan</th>
                                            <th>Pekerjaan</th>
                                            <th>User</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>testimonials</th>
                                            <th>Pekerjaan</th>
                                            <th>Status Perkawinan</th>
                                            <th>User</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $i=1; ?>
                                        <?php foreach($testimonials as $brt) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= character_limiter($brt['name'],25 );  ?></td>
                                            <td><?= $brt['isi']; ?></td>
                                            <td><?= $brt['status_perkawinan']?></td>
                                            <td><?= $brt['pekerjaan']?></td>
                                            <td><?= $brt['user']; ?></td>
                                            <td>
                                            <a href="<?= base_url('user/viewtestimonials/'); ?><?= $brt['id'];?>" class="badge badge-primary">
                                            <i class="far fa-eye"></i>
                                                </a>
                                            <a href="<?= base_url('user/edittestimonials/'); ?><?= $brt['id'];?>" class="badge badge-success">
                                                <i class="fas fa-edit"></i>
                                                </a>
                                            <a href="<?= base_url('user/deletetestimonials/'); ?><?= $brt['id'];?>/<?= $brt['gambar'];?>" class="badge badge-danger" onclick="return confirm('Apakah Anda Yakin Akan Menghapus Data Berita?');">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                            </td>
                                            
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->





  <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('public/_temp/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('public/_temp/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('public/_temp/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <!-- <script src="<?= base_url('public/_temp/') ?>js/sb-admin-2.min.js"></script> -->

    <!-- Page level plugins -->
    <script src="<?= base_url('public/_temp/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('public/_temp/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('public/_temp/') ?>js/demo/datatables-demo.js"></script>