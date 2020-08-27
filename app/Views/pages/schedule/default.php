<?php
define('TITLE', 'Schemes');
include APPPATH . 'Views/header.php';
?>

<div class="row">
	<div class="col-auto ml-auto">
		<a href="<?= site_url('schedule/create') ?>" class="btn btn-success mb-3"><i class="fas fa-plus"></i> New scheme</a>
	</div>
</div>

<table class="table">
	<thead>
		<tr>
			<th>Scheme name</th>
			<th>Created at</th>
			<th class="text-right">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($schemes as $scheme): ?>
			<tr>
				<td><?= esc($scheme['name']) ?></td>
				<td><?= date('Y-m-d', strtotime($scheme['createdAt'])) ?></td>
				<td class="text-right">
					<div class="btn-group" role="group" aria-label="actions">
						<a href="<?= site_url("schedule/export/{$scheme['id']}/html") ?>" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="Export as HTML"><i class="fas fa-code"></i></a>
					</div>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
