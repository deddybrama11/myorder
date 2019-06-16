


        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="container">
            <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
            <div class="row">
              <div class="col-md-4">

                <!-- FORM -->
                <form class="user" action="<?= base_url('manajer'); ?>" method="post" enctype="multipart/form-data">


          <!-- username  -->
          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
          </div>
          <input type="text" name="name" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
          </div>

          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Email &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
          </div>
          <input type="text" name="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
          <?= form_error('email','<small class="text-danger pl-3">','</small>'); ?>
          </div>

          <div class="form-group">
            <select class="form-control" id="exampleSelect1" name="jabatan">
              <option value="2">Kasir</option>
              <option value="3">Dapur</option>
              <option value="1">Manager</option>
            </select>
          </div>

          <!-- password  -->
          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Password &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
          </div>
          <input type="password" name="password1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
          <?= form_error('password1','<small class="text-danger pl-3">','</small>'); ?>
          </div>

          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">konfirmasi Password</span>
          </div>
          <input type="password" name="password2" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
          <?= form_error('password2','<small class="text-danger pl-3">','</small>'); ?>
          </div>
          <label for="gambar">GAMBAR :  </label>


          <input type="file" name="gambar" id="gambar" >
          <hr>

          <br>
            <button type="submit" id='regis' name="regis" value="upload" class="btn btn-danger btn-lg">UPLOAD</button>

          </form>
              </div>

              <div class="col-md-8">
                <div class="card shadow border-warning mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Karyawan</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive"style="height:17rem">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Email</th>
                    <th>Foto</th>
                    <th>Edit</th>


                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>
                  <?php foreach ($karyawan as $k): ?>
                    <tr>
                      <td><?= $i; ?></td>
                      <td><?= $k['name']; ?></td>
                      <td><?= $k['role']; ?></td>
                      <td><?= $k['email']; ?></td>
                      <td><img src="<?php echo base_url('assets/img/profile/'. $k['image']);?>" width='50' height='50'/></td>
                      <td><a href="#" class="badge badge-success" data-toggle="modal" data-target="#newEdit<?= $k['id']; ?>">Edit</a>
                      <a href="?hapusid=<?= $k['id']; ?>" class="badge badge-danger">Delete</a></td>
                    </tr>
                    <?php $i++;?>
                  <?php endforeach; ?>




                </tbody>
              </table>
            </div>
          </div>
        </div>
              </div>

            </div>

          </div>

          <!-- Page Heading -->


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <!-- Modal -->

      <?php foreach ($karyawan as $k): ?>
      <div class="modal fade" id="newEdit<?=$k['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="newEdit">Edit Karyawan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="<?= base_url('manajer'); ?>" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                 <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?= $k['name']; ?>">
               </div>
               <input type="hidden" class="form-control" id="nama" name="id" placeholder="Nama" value="<?= $k['id']; ?>">
               <div class="form-group">
                  <select name="menu_id" class="form-control" id="exampleSelect1">
                    <?php foreach($jabatan as $m): ?>
                      <option value="<?= $m['id']; ?>"><?= $m['role']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                   <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= $k['email']; ?>">
                 </div>
                 <div class="form-group">
                    <input type="file" name="jjk" id="jjk">
                  </div>



                   <label for="gambar">GAMBAR :  </label>
                   <img src="<?php echo base_url('assets/img/profile/'. $k['image']);?>" width='50' height='50'/>
                   <input type="hidden" name="gambar2" value="<?= $k['image']; ?>">
                   <!-- <input type="file" name="iniGambar" id="gambarModal"> -->


                 <div class="form-group">
                   <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="is_active" id="is_active" value="1" checked>
                    <label class="custom-control-label" for="is_active">Active?</label>
                  </div>
                 </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" name="ubah" class="btn btn-primary" value="ubah">Ubah</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
