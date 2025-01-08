<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="dasbor" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="https://wa.link/9t4mu0" class="nav-link">Kontak</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-black-610"><?= $user['name']; ?></span>
            <img class="img-profile rounded-circle"
              src="<?= base_url('assets/img/profile/') . $user['image']; ?>" style="width: 40px; height: 40px;">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?= base_url('profilsaya'); ?>">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profil Saya
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Keluar
            </a>
          </div>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <a class="nav-link mt-1" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link mt-1">
        <!-- <img src="<?= base_url('assets/admin/') ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
        <span class="brand-text font-weight-light ml-4">SIMAGANG</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Query Menu -->
            <?php
            $role_id = $this->session->userdata('role_id');
            $queryMenu = "SELECT `user_menu`.`id`, `menu`
                            FROM `user_menu` JOIN `user_access_menu`
                            ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                            WHERE `user_access_menu`.`role_id` = $role_id
                            ORDER BY `user_access_menu`.`menu_id` ASC
              ";
            $menu = $this->db->query($queryMenu)->result_array();
            ?>

            <!-- Looping Menu -->
            <?php foreach ($menu as $m) : ?>
              <li class="nav-header" style="color: rgb(200, 200, 200) !important;">
                <?= $m['menu']; ?>
              </li>

              <!-- Siapkan Submenu Sesuai Menu -->
              <?php
              $menuId = $m['id'];
              $querySubMenu = " SELECT *
                              FROM `user_sub_menu` JOIN `user_menu`
                              ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                              WHERE `user_sub_menu`.`menu_id` = $menuId
                              AND `user_sub_menu`.`is_active` = 1
                              ";
              $subMenu = $this->db->query($querySubMenu)->result_array();
              ?>
              <?php foreach ($subMenu as $sm) : ?>
                <?php if ($title == $sm['title']) : ?>
                  <li class="nav-item active">
                  <?php else : ?>
                  <li class="nav-item"></li>
                <?php endif; ?>
                <a class="nav-link" href="<?= base_url($sm['url']); ?>">
                  <i class="<?= $sm['icon']; ?>"></i>
                  <p>
                    <?= $sm['title']; ?>
                  </p>
                </a>
                </li>
              <?php endforeach; ?>
              <hr style="border: 1px solid rgb(154, 154, 154); margin: 10px 0;">
            <?php endforeach; ?>

            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('auth/logout') ?>">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Keluar</p>
              </a>
            </li>
            <hr style="border: 1px solid rgb(154, 154, 154); margin: 10px 0;">
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?= $title ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active"><?= $title ?></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Logout Modal-->
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Siap untuk pergi?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Pilih "Keluar" di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
              <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Keluar</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">

          <!-- Tambahkan CSS untuk memastikan warna teks putih pada sidebar -->
          <style>
            /* Warna teks sidebar, termasuk ikon, nama brand, dan link */
            .main-sidebar .nav-link,
            .main-sidebar .brand-text,
            .main-sidebar .user-panel .info a,
            .main-sidebar .nav-icon {
              color: rgb(219, 219, 219) !important;
              /* Menambahkan !important untuk meng-override default */
            }

            /* Atur warna teks saat di-hover (juga tetap putih) */
            .main-sidebar .nav-link:hover {
              color: white !important;
            }

            .main-sidebar {
              background-color: #05347e;
            }

            .nav-header {
              font-size: 7px;
              color: rgb(253, 254, 255) !important;
              padding: 10px 15px;
            }
          </style>