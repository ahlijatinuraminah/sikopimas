<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="index.php"><img src="img/logo.jpeg" width="180" height="90" style="float:left"></a>
          <button type="button" id="sidebarCollapse" class="btn btn-md navbar-btn">
               <i class="fas fa-angle-double-left"></i>
        </button>
        
          <a style class="navbar-brand contentnava" href="index.php">Sistem Informasi Kontra Spionase Ormas Asing</a>         
        
        </div>
        <div id="navbar" class="navbar-collapse collapse">           
          <ul class="nav navbar-nav navbar-right contentnav" >
          <?php
                if(isset($_SESSION['role_id'])){ 
            ?>
            <li><a href="index.php">Home</a></li>
             <!--   
             <li><a href="index.php?p=login">Login</a></li>
              -->
              <?php
                if($_SESSION['role_id'] == 1){
              ?>
                <li><a href="index.php?p=homeuser">View Map</a></li>
              <?php
                }
              ?>
             <li><a href="index.php?p=profile">Profile</a></li>
             <li><a href="index.php?p=logout">Logout</a></li>
            <?php 
              } 
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>