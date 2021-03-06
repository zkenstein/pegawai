<?php
    include_once "../../include/koneksi.php";
    session_start();
	
	$state_session=$_SESSION['STATE_ID'];
    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM pinjaman WHERE KODE_PINJAMAN=".$id
    ));

    if($id> 0) { 
	$KODE_PINJAMAN = $data['KODE_PINJAMAN'];
	$NIP_PEGAWAI = $data['KODE_PEGAWAI'];
	$TANGGAL = $data['TANGGAL'];
    $NOMINAL = $data['NOMINAL'];
    $JUMLAH_BLN = $data['JUMLAH_BLN'];
    $KETERANGAN = $data['KETERANGAN'];
    $STATUS = $data['STATUS'];
    } else {
	$KODE_PINJAMAN = "";
	$NIP_PEGAWAI = "";
	$TANGGAL = date("Y-m-d");
        $NOMINAL = "";
        $JUMLAH_BLN = "";
        $KETERANGAN = "";
        $STATUS = "";
    }
?>
	
 <form class="form-horizontal pinjaman2Form" id="pinjaman2Form" action="crud/pinjaman2/pinjaman.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
				</div>
		</div>
        <div class="form-group">
            <label for="NIP_PEGAWAI" class="col-sm-3 control-label"> Nama Pegawai</label>
            <div class="col-sm-9">
                 <?php
                    $result = mysql_query("select * from pegawai where STATE_ID='$state_session'");  
                    echo '<select id="NIP_PEGAWAI" name="NIP_PEGAWAI" style="width: 100%;" class="NIP_PEGAWAI form-control ">';  
                        echo '<option value="">Silahkan Pilih Pegawai</option>';  
			while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['KODE_PEGAWAI'] . '"';if($NIP_PEGAWAI==$row['KODE_PEGAWAI']){echo "selected='selected'";} echo'>'.$row['NIP_PEGAWAI'].' - '.$row['NAMA_PEGAWAI']. '</option>';  
			}  
                    echo '</select>';
		?>
		<input type="hidden" class="form-control" value="<?php echo $id; ?>" id="KODE_PINJAMAN" name="KODE_PINJAMAN"  \>
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
            <label for="JML" class="col-sm-3 control-label">Jumlah Bulan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="JUMLAH_BLN" name="JUMLAH_BLN" value="<?php echo $JUMLAH_BLN; ?>" placeholder="Jumlah Bulan" />
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
	$('#pinjaman2Form')
            .on('success.form.fv', function(e) {
                e.preventDefault();

                var $form = $(e.target),
                    fv    = $form.data('formValidation');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function() {
			$('#dialog-pinjaman2').modal('hide');
                    }
                });
            })
			.on('init.field.fv', function(e, data) {

				var $icon      = data.element.data('fv.icon'),
					options    = data.fv.getOptions(), 
					validators = data.fv.getOptions(data.field).validators; 

				if (validators.notEmpty && options.icon && options.icon.required) {
					$icon.addClass(options.icon.required).show();
				}
			})
            .formValidation({
                message: 'This value is not valid',
                icon: {
					required: 'glyphicon glyphicon-asterisk',
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
					JUMLAH_BLN: {
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
