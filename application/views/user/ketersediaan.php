

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
          <div class="row">
            <div class="col">

              <div class="card shadow border-warning mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DAFTAR MENU</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Ketersediaan</th>


                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($tbl as $key): ?>

                        <?php $noid = intval($key->noid);?>

                          <tr>
                            <td><?= $key->namaMakanan ?></td>
                            <?php if($noid==0): ?>
                            <td> <a href="?kode=<?= $key->kodeMakanan ?>&noid=<?= $key->noid ?>" class="btn btn-danger btn-sm"> Kosong</a></td>
                          <?php endif; ?>
                          <?php if($noid==1): ?>
                          <td> <a href="?kode=<?= $key->kodeMakanan ?>&noid=<?= $key->noid ?>" class="btn btn-success btn-sm"> Tersedia</a></td>
                        <?php endif; ?>
                          </tr>

                      <?php endforeach; ?>



                    </tbody>

                  </table>
                  <?php echo $this->pagination->create_links();?>
                </div>
              </div>
            </div>

            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
