
        <h2 style="margin-top:0px">Tindakan <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Status <?php echo form_error('status') ?></label>
            <select name="status" id="status" class="form-control">
                <option value="0" <?php if($status == '0') echo'selected';?>>Rawat Jalan</option>
                <option value="1" <?php if($status == '1') echo'selected';?>>Rawat Inap</option>
            </select>
            
        </div>
	    <div class="form-group">
            <label for="varchar">Keluhan <?php echo form_error('keluhan') ?></label>
            <textarea class="form-control" rows="3" name="keluhan" id="keluhan" placeholder="Keluhan"><?php echo $keluhan; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="int">Id Dokter <?php echo form_error('id_dokter') ?></label>
            <input type="text" class="form-control" name="id_dokter" id="id_dokter" placeholder="Id Dokter" value="<?php echo $id_dokter; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Dokter <?php echo form_error('nama_dokter') ?></label>
            <input type="text" class="form-control" name="nama_dokter" id="nama_dokter" placeholder="Nama Dokter" value="<?php echo $nama_dokter; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Pasien <?php echo form_error('id_pasien') ?></label>
            <input type="text" class="form-control" name="id_pasien" id="id_pasien" placeholder="Id Pasien" value="<?php echo $id_pasien; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Pasien <?php echo form_error('nama_pasien') ?></label>
            <input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Nama Pasien" value="<?php echo $nama_pasien; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Tgl Tindakan <?php echo form_error('tgl_tindakan') ?></label>
            <input type="date" class="form-control" name="tgl_tindakan" id="tgl_tindakan" placeholder="Tgl Tindakan" value="<?php echo $tgl_tindakan; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Jenis Tindakan <?php echo form_error('id_jenis_tindakan') ?></label>
            <input type="text" class="form-control" name="id_jenis_tindakan" id="id_jenis_tindakan" placeholder="Id Jenis Tindakan" value="<?php echo $id_jenis_tindakan; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Jenis Tindakan <?php echo form_error('jenis_tindakan') ?></label>
            <input type="text" class="form-control" name="jenis_tindakan" id="jenis_tindakan" placeholder="Jenis Tindakan" value="<?php echo $jenis_tindakan; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Penyakit <?php echo form_error('id_penyakit') ?></label>
            <select name="id_penyakit" id="id_penyakit" class="form-control">
            <?php foreach ($data_list as $key) { ?>
                <option value="<?= $key->id_penyakit?>" <?php if($id_penyakit == $key->id_penyakit) echo'selected';?>><?= $key->penyakit ?></option>
            <?php } ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="resep">Resep <?php echo form_error('resep') ?></label>
            <textarea class="form-control" rows="3" name="resep" id="resep" placeholder="Resep"><?php echo $resep; ?></textarea>
        </div>
	    <input type="hidden" name="id_tindakan" value="<?php echo $id_tindakan; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tindakan') ?>" class="btn btn-default">Cancel</a>
	</form>