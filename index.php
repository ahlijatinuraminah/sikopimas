<?php 
 if (!isset($_SESSION)) {
    session_start();
    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIKOPIMAS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">	
	<link href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css" rel="stylesheet">		
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <link rel="stylesheet" href="//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css" type="text/css">	
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>	
    <script src = "https://code.highcharts.com/highcharts.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/layout.css">
 
</head>
<body>

<div class="wrapper">
<?php
    if (isset($_SESSION['role_id'])){
?>
        <!-- Sidebar Holder -->
        <nav id="sidebar" style="margin-top:80px">             
            <?php
                if($_SESSION['role_id'] == 1){
                    if(isset($_GET['p']) && $_GET['p'] != "" && $_GET['p'] == "homeuser")
                        include "pages/sidebarfilter.php";
                    else
                        include "pages/sidebaradmin.php";
                }
                else {//if user role == level 1 or level 2
                    if(isset($_GET['p']) && $_GET['p'] != "" && $_GET['p'] == "profile")
                        include "pages/sidebaruser.php";
                    else
                        include "pages/sidebarfilter.php";
                }
            ?>
        </nav>
<?php
    }
?>

            <!-- Page Content Holder -->
            <div id="content" style="margin-top:80px">             
                <?php                

                    if (isset($_SESSION['role_id'])){
                        include "pages/navbar.php";        
                    } 
                
                //to be removed jika sudah implement autentikasi user
                $pages_dir = 'pages';
                    if(!empty($_GET['p'])){
                        $pages = scandir($pages_dir, 0);
                        unset($pages[0], $pages[1]);					
                        $p = $_GET['p'];
                        if(in_array($p.'.php', $pages)){
                            include($pages_dir.'/'.$p.'.php');
                        } else {
                            echo 'Halaman tidak ditemukan! :(';
                        }
                    } 
                    else {                                  
                        if (isset($_SESSION['role_id'])){
                            if($_SESSION['role_id'] == 1)
                                include "pages/homeadmin.php";
                            else//if user role == level 1 or level 2
                                include "pages/homeuser.php";                            // 
                        } 
                        else {//else tidak punya role(belum login)                        
                            include('pages/login.php');     
                        }
                    }


                ?>               
            </div>    
</div>


		<!-- Start print Section -->
		
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>   
	<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>   	
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
  <script src="//unpkg.com/leaflet-gesture-handling"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="js/custom.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script>

        <script type="text/javascript">
        var userRole = <?php  

            if (isset($_SESSION['role_id'])){
                echo $_SESSION['role_id'];
            }
            else {
                echo 0;
            }
            ?>;
            

            $(document).ready(function () {
                
                $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });
                

                $('#sidebarCollapse').on('click', function () {
                    
                    $('#sidebar, #content').toggleClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');

                    if($('#sidebar').hasClass('active')){
                        $('#spanStatus').html('Show Filter');                                               
                        $('#stnavbar').removeClass('lefthide');   
                        $('#stnavbar').addClass('leftshow');
                    }
                    else{
                        $('#spanStatus').html('Hide Filter');
                        $('#stnavbar').removeClass('leftshow');   
                        $('#stnavbar').addClass('lefthide');   
                    }
                });
            });
        </script>
	
</body>

</html>