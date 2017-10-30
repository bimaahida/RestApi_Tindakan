
        <h2 style="margin-top:0px">Rawat_inap <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Id Tindakan <?php echo form_error('id_tindakan') ?></label>
            <input type="text" class="form-control" name="id_tindakan" id="id_tindakan" placeholder="Id Tindakan" value="<?php echo $id_tindakan; ?>" readonly />
        </div>
	    <div class="form-group">
            <label for="int">Id Ruangan <?php echo form_error('id_ruangan') ?></label>
            <input type="text" class="form-control" name="id_ruangan" id="id_ruangan" placeholder="Id Ruangan" value="<?php echo $id_ruangan; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Ruangan <?php echo form_error('ruangan') ?></label>
            <input type="text" class="form-control" name="ruangan" id="ruangan" placeholder="Ruangan" value="<?php echo $ruangan; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Tgl Masuk <?php echo form_error('tgl_masuk') ?></label>
            <input type="text" class="form-control" name="tgl_masuk" id="tgl_masuk" placeholder="Tgl Masuk" value="<?php echo $tgl_masuk; ?>" readonly/>
        </div>
	    <div class="form-group">
            <label for="date">Tgl Keluar <?php echo form_error('tgl_keluar') ?></label>
            <input type="date" class="form-control" name="tgl_keluar" id="tgl_keluar" placeholder="Tgl Keluar" value="<?php echo $tgl_keluar; ?>" />
        </div>
	    <input type="hidden" name="id_rawat_inap" value="<?php echo $id_rawat_inap; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('rawat_inap') ?>" class="btn btn-default">Cancel</a>
	</form>