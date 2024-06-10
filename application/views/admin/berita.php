<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
                        <?= $this->session->flashdata('pesan'); ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <a href="<?= base_url('admin/tambahberita') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"></i> Tambah berita</a></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>User</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>User</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $i=1; ?>
                                        <?php foreach($berita as $brt) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= character_limiter($brt['judul'],25 );  ?></td>
                                            <td><?= $brt['tanggal']; ?></td>
                                            <td>
                                                <?php $cek = 'draff' ?>
                                                <?php if($brt['status'] == $cek ) : ?>
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                    draff
                                               <?php else: ?>
                                                <i class="fas fa-check-circle text-success"></i>
                                                    publish
                                                <?php endif; ?>
                                            
                                            </td>
                                            <td><?= $brt['user']; ?></td>
                                            <td>
                                            <a href="<?= base_url('admin/viewberita/'); ?><?= $brt['id'];?>" class="badge badge-primary">
                                            <i class="far fa-eye"></i>
                                                view</a>
                                            <a href="<?= base_url('admin/editberita/'); ?><?= $brt['id'];?>" class="badge badge-success">
                                                <i class="fas fa-edit"></i>
                                                edit</a>
                                            <a href="<?= base_url('admin/deleteberita/'); ?><?= $brt['id'];?>/<?= $brt['gambar'];?>" class="badge badge-danger" onclick="return confirm('Apakah Anda Yakin Akan Menghapus Data Berita?');">
                                                <i class="far fa-trash-alt"></i>
                                                delete</a>
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