
        <h2 style="margin-top:0px">Rawat_jalan <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Id Tindakan <?php echo form_error('id_tindakan') ?></label>
            <input type="text" class="form-control" name="id_tindakan" id="id_tindakan" placeholder="Id Tindakan" value="<?php echo $id_tindakan; ?>" readonly />
        </div>
	    <div class="form-group">
            <label for="date">Tgl Periksa <?php echo form_error('tgl_periksa') ?></label>
            <input type="date" class="form-control" name="tgl_periksa" id="tgl_periksa" placeholder="Tgl Periksa" value="<?php echo $tgl_periksa; ?>" />
        </div>
	    <input type="hidden" name="id_rawat_jalan" value="<?php echo $id_rawat_jalan; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('rawat_jalan') ?>" class="btn btn-default">Cancel</a>
	</form>