 <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
                    </div>

                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Earnings (Monthly)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Annual) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Earnings (Annual)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Requests</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- BATAS  -->
                        <div class="col-lg-12">
                            <!-- Dropdown Card Example -->
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('user/produk') ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-arrow-alt-circle-left"></i> Back</a>
                                    </h6>
                                    
                                </div>

                                <center><img src="<?= base_url('assets/img/produk/' . $produk['gambar']); ?>" class="card-img-top w-50 rounded mt-2 img-fluid" alt="..." width="700px"></center>
                                  <div class="card-body">

                                    <h5 class="card-title font-weight-bold">
                                        <?= $produk['name']; ?>
                                    </h5>
                                    <p class="card-text"><?= $produk['deskripsi']; ?>.</p>
                                  </div>
                                <!-- Card Body -->
                                <ul class="list-group list-group-flush"> 
                                <li class="list-group-item">
                                    <img width="30" height="30" src="https://img.icons8.com/external-ios-line-2px-amoghdesign/30/external-forex-currency-minima-30px-ios-line-2px-amoghdesign-2.png" alt="external-forex-currency-minima-30px-ios-line-2px-amoghdesign-2"/>.<?= $produk['harga']; ?>
                                </li>
                              </ul>
                              <ul class="list-group list-group-flush"> 
                                <li class="list-group-item">
                                    <img width="20" height="20" src="https://img.icons8.com/pulsar-gradient/20/stocks.png" alt="stocks"/> <?= $produk['stock']; ?> 
                                </li>
                              </ul>
                              <ul class="list-group list-group-flush"> 
                                <li class="list-group-item">
                                    <img width="20" height="20" src="https://img.icons8.com/3d-fluency/20/calendar--v2.png" alt="calendar--v2"/> <?= format_indo(date($produk['tanggal'])); ?>
                                </li>
                              </ul>
                                <div class="card-body">
                                     <a href="#" class="card-link text-success">
                                        <i class="fas fa-check-circle text-success"></i>
                                         <?= $produk['status'] ?>
                                     </a>
                                     <a href="#" class="card-link">
                                         <i class="fas fa-times-circle text-danger"></i>
                                    <?= $produk['kategori'] ?>
                                     </a>
                                </div>
                            </div>

                            <!-- BATAS  -->

                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


