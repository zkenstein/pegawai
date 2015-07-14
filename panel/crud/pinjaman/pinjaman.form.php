<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM kasbon_pegawai WHERE KODE_KASBON=".$id
    ));

    if($id> 0) { 
	$KODE_KASBON = $data['KODE_KASBON'];
	$NIP_PEGAWAI = $data['NIP_PEGAWAI'];
	$TANGGAL = $data['TANGGAL'];
        $NOMINAL = $data['NOMINAL'];
        $KETERANGAN = $data['KETERANGAN'];
        $STATUS = $data['STATUS'];
    } else {
	$KODE_KASBON = "";
	$NIP_PEGAWAI = "";
	$TANGGAL = date("Y-m-d");
        $NOMINAL = "";
        $KETERANGAN = "";
        $STATUS = "";
    }
?>
	
 <form class="form-horizontal pinjamanForm" id="pinjamanForm" action="crud/pinjaman/pinjaman.input.php" type="POST">
    <div class="modal-body">
        <div class="form-group">
            <label for="NIP_PEGAWAI" class="col-sm-3 control-label"> Nama Pegawai</label>
            <div class="col-sm-9">
                 <?php
                    $result = mysql_query("select * from pegawai");  
                    echo '<select id="NIP_PEGAWAI" name="NIP_PEGAWAI" style="width: 100%;" class="NIP_PEGAWAI form-control ">';  
                        echo '<option value="">Silahkan Pilih Pegawai</option>';  
			while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['NIP_PEGAWAI'] . '"';if($NIP_PEGAWAI==$row['NIP_PEGAWAI']){echo "selected='selected'";} echo'>'.$row['NIP_PEGAWAI'].' - '.$row['NAMA_PEGAWAI']. '</option>';  
			}  
                    echo '</select>';
		?>
		<input type="hidden" class="form-control" value="<?php echo $id; ?>" id="KODE_KASBON" name="KODE_KASBON"  \>
                <input type="hidden" class="form-control" value="<?php echo $STATUS; ?>" id="STATUS" name="STATUS"  \>
            </div>
	</div>
        <div class="form-group">
            <label for="TANGGAL" class="col-sm-3 control-label">Tanggal</label>
            <div class="col-sm-9">
                <div class="input-group date" id="datePicker">
                    <input type="text" class="form-control" id="TANGGAL" name="TANGGAL" value="<?php echo $TANGGAL; ?>" placeholder="Tanggal" readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
	</div>
        <div class="form-group">
            <label for="NOMINAL" class="col-sm-3 control-label">Nominal</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="NOMINAL" name="NOMINAL" value="<?php echo $NOMINAL; ?>" placeholder="Nominal" />
            </div>
	</div>
        <div class="form-group">
            <label for="KETERANGAN" class="col-sm-3 control-label">Keterangan</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="KETERANGAN" name="KETERANGAN" placeholder="Keterangan"><?php echo $KETERANGAN; ?></textarea>
            </div>
	</div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal Simpan</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).ready(function() {
            $(".NIP_PEGAWAI").select2();
        });
        $('#datePicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
	});
	$('#pinjamanForm')
            .on('success.form.fv', function(e) {
                e.preventDefault();

                var $form = $(e.target),
                    fv    = $form.data('formValidation');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function() {
			$('#dialog-pinjaman').modal('hide');
                    }
                });
            })
            .formValidation({
                message: 'This value is not valid',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    NIP_PEGAWAI: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                    TANGGAL: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                    NOMINAL: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            },
                            numeric: {
                                message: 'The is numeric'
                            }
                        }
                    },
                    KETERANGAN: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                }
            });
    });
</script>