
<div class="container-fluid  dashboard-content">
	<!-- ============================================================== -->
	<!-- pageheader -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">Add Data</h2>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Master</a></li>
							<li class="breadcrumb-item active" aria-current="page">Add</li>
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
					<form method="post" action="<?= base_url("admin/pages/save_category") ?>">
						<div class="form-group">
							<label for="name" class="col-form-label">Name</label>
							<input id="name" name="name" type="text" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="input-select">Unit</label>
							<select class="form-control" id="unit" name="unit" required>
								<option value="pcs">Pcs</option>
								<option value="meter">Meter</option>
								<option value="kg">Kilogram</option>
							</select>
						</div>
						<button class="btn btn-primary btn-sm float-right" type="submit">Save</button>
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
