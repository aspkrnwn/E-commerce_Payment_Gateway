
<div class="container-fluid  dashboard-content">
	<!-- ============================================================== -->
	<!-- pageheader -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">Edit Data</h2>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Master</a></li>
							<li class="breadcrumb-item active" aria-current="page">Edit</li>
							<li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- end pageheader -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="section-block" id="basicform">
				<p>Silahkan isi dengan langkap data - data pada form dibawah ini.</p>
			</div>
			<div class="card">
				<h5 class="card-header">Form <?= $title ?></h5>
				<div class="card-body">
					<form method="post" action="<?= base_url("admin/pages/update_category") ?>" class="dropzone"
						id="fileupload">
						<?php foreach($categories as $row): ?>
							<div class="form-group">
								<label for="name" class="col-form-label">Name</label>
								<input type="hidden" name="id" value="<?= $row->id ?>">
								<input id="name" name="name" type="text" class="form-control" value="<?= $row->name ?>" required>
							</div>
							<div class="form-group">
								<label for="input-select">Unit</label>
								<select class="form-control" id="unit" name="unit" required value="<?= $row->unit ?>">
									<option <?php if($row->unit=='pcs'){echo "selected";} ?> value="pcs">Pcs</option>
									<option <?php if($row->unit=='meter'){echo "selected";} ?> value="meter">Meter</option>
									<option <?php if($row->unit=='kg'){echo "selected";} ?> value="kg">Kilogram</option>
								</select>
							</div>
							
							<div class="form-group">
								<label for="image" class="col-form-label">Image</label><br>
								<img src="<?= base_url('upload/images/categories/'.$row->icon) ?>" alt="Something wrong, can't load the image" class="img-fluid rounded" width=150 height=100>
							</div>
						<?php endforeach; ?>
						<button class="btn btn-primary btn-sm float-right" type="submit">Update</button>
						<a class="btn btn-warning btn-sm float-right mr-3" href="<?= base_url("admin/pages/categories") ?>">Cancel</a>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- end data table  -->
	<!-- ============================================================== -->
</div>
</div>
