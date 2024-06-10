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
                                    <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('user/clients') ?>" class="btn btn-primary btn-sm"><i class="fas fa-arrow-alt-circle-left"></i> Back</a></h6>
                                    
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                     <form action="<?php base_url('user/tambahclients'); ?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= $clients['id'];?>">
                                        <input type="hidden" name="tanggal" value="<?= $clients['tanggal'];?>">
                                        <input type="hidden" name="user" value="<?= $clients['user'];?>">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Nama clients</label>
                                                <input type="text" class="form-control" name="name" id="name" value="<?= $clients['name'] ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="form-group">
                                                <label for="status">Status Hubungan</label>
                                                <select name="status" class="custom-select">
                                                    <option value="" selected>Select :</option>
                                                    <?php foreach($status as $st ) : ?>
                                                    <?php if($st == $clients['status']): ?>
                                                    <option value="<?= $st; ?>" selected><?= $st; ?></option>
                                                    <?php else : ?>
                                                    <option value="<?= $st; ?>"><?= $st; ?></option>
                                                    <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?= form_error('status', '<small class="text-danger pl-3">', '</small>'); ?> 
                                            </div>
                                            </div>
                                            <div class="form-row mb-2">
                                                 <div class="col-md-6">
                                                     <img src="<?= base_url('./assets/img/clients/' . $clients['gambar']); ?>" class="img-thumbnail text-center" style="width: 400px; height: 150px;"><br>
                                                </div>
                                           </div>
                                            <div class="custom-file mb-4">
                                                <input type="file" class="custom-file-input" name="image" id="image">
                                                <label class="custom-file-label" for="image">Images</label>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary btn-sm" name="upload"><i class="fas fa-check-circle"></i> Simpan</button>
                                        </form>
                                </div>
                            </div>

                            <!-- BATAS  -->

                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


