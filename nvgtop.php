  <!-- ======= Header ======= -->
  <?php
  function startsWith($string, $startString)
  {
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
  }
  ?>
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <img src="img/logo.png" alt="">
        <span class="d-none d-lg-block">e-Complaint</span>
      </a>
      <i class="fa-solid fa-bars toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="fa-regular fa-bell"></i>
          </a><!-- End Notification Icon -->
        </li><!-- End Notification Nav -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?php echo $image_ ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block ps-2">
              <?php
              if (isset($username_)) {
                echo $username_;
              }
              ?>
            </span>
          </a><!-- End Profile Iamge Icon -->
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link <?php echo startsWith(basename($_SERVER["PHP_SELF"]), "dashboard") ? "" : "collapsed" ?>" href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link <?php echo startsWith(basename($_SERVER["PHP_SELF"]), "complain_form") ? "" : "collapsed" ?><?php echo startsWith(basename($_SERVER["PHP_SELF"]), "list_complain") ? "show" : "" ?>" data-bs-target="#forms" data-bs-toggle="collapse" href="#" >
          <i class="fa-regular fa-file-lines"></i><span>Complaint Forms</span><i class="fa-solid fa-chevron-down ms-auto"></i>
        </a>
        <ul id="forms" class="nav-content collapse <?php echo startsWith(basename($_SERVER["PHP_SELF"]), "complain_form") ? "show" : "" ?><?php echo startsWith(basename($_SERVER["PHP_SELF"]), "list_complain") ? "show" : "" ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a href="complain_form.php">
              <span>○ Add New</span>
            </a>
          </li>
          <li>
            <a href="list_complain.php">
              <span>○ Sent</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <?php
      if ($role == 'helpdesk' || $role == 'admin') {
        echo "<li class='nav-heading'>Helpdesk</li>

                <li class='nav-item'>
                  <a class='nav-link ".(startsWith(basename($_SERVER['PHP_SELF']), 'helpdesk_complaint_management') ? '' : 'collapsed')."' href='helpdesk_complaint_management.php'>
                  <i class='fa-solid fa-box-archive'></i>    
                    <span>Complaint Inbox</span>
                  </a>
                </li>

                <li class='nav-item'>
                  <a class='nav-link ".(startsWith(basename($_SERVER['PHP_SELF']), 'helpdesk_group') ? '' : 'collapsed')."' href='helpdesk_group.php'>
                  <i class='fa-regular fa-folder'></i>    
                    <span>Group</span>
                  </a>
                </li>";
      }
      ?>
      <!-- End Group Nav -->
      <?php
      if ($role == 'executive' || $role == 'admin') {
        echo "<li class='nav-heading'>Executive</li>
            
                <li class='nav-item'>
                  <a class='nav-link ".(startsWith(basename($_SERVER['PHP_SELF']), 'executive_complaint_management') ? '' : 'collapsed')."' href='executive_complaint_management.php'>
                  <i class='fa-solid fa-box-archive'></i> 
                    <span>Complaint Inbox</span>
                  </a>
                </li>

                ";
      }

      ?>
      <!-- End executive Nav -->

      <?php
      if ($role == 'admin') {
        echo "<li class='nav-heading'>Admin</li>
          
                <li class='nav-item'>
                  <a class='nav-link ".(startsWith(basename($_SERVER['PHP_SELF']), 'adminAddUser') ? '' : 'collapsed')."".(startsWith(basename($_SERVER['PHP_SELF']), 'admin_user_list') ? 'show' : '')."' data-bs-target='#admin' data-bs-toggle='collapse' href='#' >
                  <i class='fa-solid fa-user-group'></i></i><span>Manage User</span><i class='fa-solid fa-chevron-down ms-auto'></i>
                  </a>
                  <ul id='admin' class='nav-content collapse ".(startsWith(basename($_SERVER['PHP_SELF']), 'adminAddUser') ? 'show' : '')."".(startsWith(basename($_SERVER['PHP_SELF']), 'admin_user_list') ? 'show' : '')."' data-bs-parent='#sidebar-nav'>
                    <li>
                      <a href='adminAddUser.php'>
                        <span>○ Add New</span>
                        <!-- bi bi-person-plus-fill -->
                      </a>
                    </li>
                    <li>
                      <a href='admin_user_list.php'>
                        <span>○ User List</span>
                      </a>
                    </li>
                  </ul>
                </li>";
      }
      ?>
      <!-- End admin Nav -->

      <li class="nav-heading">Settings</li>

      <li class="nav-item">
        <a class="nav-link <?php echo startsWith(basename($_SERVER["PHP_SELF"]), "profile") ? "" : "collapsed" ?>" href="profile.php">
          <i class="fa-regular fa-user"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="fa-solid fa-right-to-bracket"></i>
          <span>Log Out</span>
        </a>
      </li><!-- End Log Out Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->