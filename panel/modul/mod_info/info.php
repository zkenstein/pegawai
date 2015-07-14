<?php
    include_once "../../include/koneksi.php";
    session_start();
?>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "sDom": '<"top"Cflt<"clear">>rt<"bottom"ip<"clear">>',
        });
    });
</script>

<ol class="breadcrumb">
  <li><a href="#" id="beranda" class="beranda"><span class="glyphicon glyphicon-home"> Beranda</a></li>
  <li class="active"><span class="glyphicon glyphicon-user"> info</li>
</ol>

<div class="page-header" style="margin-top:5px;">
    <h3>Kelola Data info</h3>
</div>

<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">Data info</h3>
    </div>
    <div class="panel-body">
	
	<div class="well">
            <div id="data-info"></div>
	</div>
    </div>
</div>

<div class="modal fade" id="dialog-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 id="myModalLabel">Tambah Data info</h3>
      </div>
      <div id="isiForm" class="isiForm"></div>
    </div>
  </div>
</div>

<script src="crud/info/aplikasi.js"></script>

           