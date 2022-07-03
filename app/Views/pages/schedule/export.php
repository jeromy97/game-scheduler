<?php
define('TITLE', 'Scheme export');
include APPPATH . 'Views/header.php';
?>

<div class="export">
	<div class="row">
		<div class="col-auto">
			<a href="<?= site_url('schedule') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i> Back</a>
		</div>
		<div class="col">
			<div class="input-group">
				<input type="text" id="name" class="form-control" value="<?= esc($scheme['name']) ?>" readonly>
				<div class="input-group-append">
					<button
						class="btn btn-outline-primary"
						type="button"
						onclick="copyToClipboard('name')"
						title="Copy to clipboard">
						<i class="fas fa-copy"></i>
					</button>
				</div>
			</div>
		</div>
		<div class="col-auto button-group">
			<button type="button" class="btn btn-outline-primary" onclick="copyToClipboard('export')">
				<i class="fas fa-copy"></i> Copy to clipboard
			</button>
		</div>
		<div class="col-12 form-group">
			<textarea id="export" class="form-control" rows="25" readonly><?= $export ?></textarea>
		</div>
		<div class="col-12">Example:</div>
		<div class="col-12">
			<div class="example border rounded"><?= $export ?></div>
		</div>
	</div>
</div>
		
<?php include APPPATH . '/Views/footer.php'; ?>
