<?php
define('TITLE', 'Scheme export');
include APPPATH . 'Views/header.php';
?>

<div class="row">
	<div class="col-auto">
		<a href="<?= site_url('schedule') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i> Back</a>
	</div>
</div>

<div class="row">
	<div class="col-12 form-group">
		<textarea class="form-control" readonly><?= $export ?></textarea>
	</div>
</div>
		
<?php include APPPATH . '/Views/footer.php'; ?>
