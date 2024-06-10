<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
                        <?= $this->session->flashdata('pesan'); ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <a href="<?= base_url('user/tambahproduk') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"></i> Tambah produk</a></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>User</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>User</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $i=1; ?>
                                        <?php foreach($produk as $brt) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= character_limiter($brt['name'],25 );  ?></td>
                                            <td><?= $brt['stock']; ?> <span><?= $brt['netto'] ?></span></td>
                                            <td>
                                                <?php $cek = 'Habis' ?>
                                                <?php if($brt['status'] == $cek ) : ?>
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                    Habis
                                               <?php else: ?>
                                                <i class="fas fa-check-circle text-success"></i>
                                                    Ada
                                                <?php endif; ?>
                                            
                                            </td>
                                            <td><?= $brt['user']; ?></td>
                                            <td>
                                            <a href="<?= base_url('user/viewproduk/'); ?><?= $brt['id'];?>" class="badge badge-primary">
                                            <i class="far fa-eye"></i>
                                                view</a>
                                            <a href="<?= base_url('user/editproduk/'); ?><?= $brt['id'];?>" class="badge badge-success">
                                                <i class="fas fa-edit"></i>
                                                edit</a>
                                            <a href="<?= base_url('user/deleteproduk/'); ?><?= $brt['id'];?>/<?= $brt['gambar'];?>" class="badge badge-danger" onclick="return confirm('Apakah Anda Yakin Akan Menghapus Data Berita?');">
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




