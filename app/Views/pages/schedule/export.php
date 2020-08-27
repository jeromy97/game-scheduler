<?php
define('TITLE', 'Scheme export');
include APPPATH . 'Views/header.php';
?>

<div class="row">
	<div class="col-auto">
		<a href="<?= site_url('schedule') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i> Back</a>
	</div>
	<div class="col-auto button-group">
		<button type="button" class="btn btn-outline-primary" onclick="copyToClipboard('export')"><i class="fas fa-copy"></i> Copy to clipboard</button>
	</div>
</div>

<div class="row">
	<div class="col-12 form-group">
		<textarea id="export" class="form-control" rows="25" readonly><?= $export ?></textarea>
	</div>
</div>
		
<?php include APPPATH . '/Views/footer.php'; ?>
