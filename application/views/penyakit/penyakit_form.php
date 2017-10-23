
        <h2 style="margin-top:0px">Penyakit <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Penyakit <?php echo form_error('penyakit') ?></label>
            <input type="text" class="form-control" name="penyakit" id="penyakit" placeholder="Penyakit" value="<?php echo $penyakit; ?>" />
        </div>
	    <input type="hidden" name="id_penyakit" value="<?php echo $id_penyakit; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('penyakit') ?>" class="btn btn-default">Cancel</a>
	</form>