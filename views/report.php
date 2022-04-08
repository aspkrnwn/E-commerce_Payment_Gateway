
<div class="container-fluid  dashboard-content">
	<!-- ============================================================== -->
	<!-- pageheader -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">Report Product</h2>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Data</a></li>
							<li class="breadcrumb-item active" aria-current="page">Report</li>
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
				<p>Filter tanggal untuk menampilkan laporan</p>
			</div>
			<div class="card">
				<div class="card-body">
					<form method="post" action="<?= base_url("admin/pages/result/range") ?>">
						<div class="form-group">
							<label for="start_date" class="col-form-label">Tanggal Awal</label>
							<input id="start_date" name="start_date" type="date" class="form-control" required>
						</div>

						<div class="form-group">
							<label for="end_date" class="col-form-label">Tanggal Akhir</label>
							<input id="end_date" name="end_date" type="date" class="form-control" required>
						</div>
						<button class="btn btn-primary btn-sm float-right" type="submit">Check</button>
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

