<?php
    include "authorizationuser.php";
?>
<!-- Wrapper -->
	<!-- Sidebar -->
	
	<ul class="list-unstyled components">
            <li>
				<a> 
					<!-- <label>Nama Organisasi</label> -->
					<input id="namaorg" class="form-control" name="search" type="text" value="" placeholder="Nama Organisasi">
				</a>
			</li>
			<!--
			<li>
				<a> 
					<label>Representasi</label>
					<input id="namarep"  class="form-control" name="search" type="text" value="">
				</a>
			</li>       
			<li>
				<a> 
					<label>Tahun Beroperasi</label>
					<input id="thnoperasi" class="form-control" name="search" type="text" value="">
				</a>
			</li>   
-->
			<li>
				<a> 
					<!-- <label>Negara Asal</label> -->
                    <select id="ddlNegara" class="form-control"> 				
					</select>
				</a>
			</li>    
            <li>
				<a> 
					<!-- <label>Bidang Kerja</label> -->
                    <select id="ddlBidangKerja" class="form-control"> 
					</select>
				</a>
			</li>
			<li>
				<a> 
					<!-- <label>Lokasi Kerja</label> -->
					<select id="ddlProvinsi" class="form-control">		  
					</select>
				</a> 
			</li>
            
            <li>
				<a> 
					<!-- <label>Tingkat Kerawanan</label> -->
                    <select id="ddlKerawanan" class="form-control">
						<option value="">Semua Tingkat Kerawanan</option>
						<option value="AMAN">AMAN</option>
						<option value="SEDANG">SEDANG</option>
						<option value="RAWAN">RAWAN</option>
					</select>
				</a>
			</li>
			<?php
			  if($_SESSION['role_id'] == 3 || $_SESSION['role_id'] == 1) {
			?>
			<li>
				<a> 
					<!-- <label>Mitra</label> -->
                    <select id="ddlMitra" class="form-control">						
					</select>
				</a>
			</li>
			<li>
				<a> 
					<!-- <label>Status Perizinan</label> -->
                    <select id="ddlStatusPerizinan" class="form-control">						
					</select>
				</a>
			</li>
			<li>
				<a> 
					<!-- <label>Isu</label> -->
                    <select id="ddlIsu" class="form-control">						
					</select>
				</a>
			</li>
			<li>
				<a> 
					<!-- <label>Mitra Lokal</label> -->
                    <select id="ddlMitraLokal" class="form-control">						
					</select>
				</a>
			</li>


			<?php
			}
			?>
			<li>
               <div style="margin: 10px 0">
				<button id="btnSearch" class="btn btn-primary"><i class="fas fa-search" aria-hidden="true"></i> Search</button>
				<button id="btnReset" class="btn btn-warning"><i class="fas fa-undo" aria-hidden="true"></i> Reset</button>                						
			</div>
            </li>
        </ul>
	
    	

        
  