
<div class="container-fluid  dashboard-content">
	<!-- ============================================================== -->
	<!-- pageheader -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">Processed Order</h2>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Data Table</a></li>
							<li class="breadcrumb-item" aria-current="page">Order</li>
							<li class="breadcrumb-item active" aria-current="page">Processed Order</li>
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
			</div>
			<div class="card">
				<h5 class="card-header">Form Update Resi Order</h5>
				<div class="card-body">
					<form method="post" action="<?= base_url("admin/pages/save_processed_order") ?>">
						<?php foreach($detail_order as $row): ?>
							<div class="form-group">
								<label for="receipt_number" class="col-form-label">Nomor Resi</label>
								<input type="hidden" name="id" value="<?= $row->order_id ?>">

								<input type="hidden" name="email" value="<?= $row->email ?>">
								<input type="hidden" name="full_name" value="<?= $row->full_name ?>">
								<input type="hidden" name="total" value="<?= $row->total_pay + $row->shipping_cost ?>">
								<input type="hidden" name="delivery_service" value="<?= $row->delivery_service ?>">


								<input id="receipt_number" name="receipt_number" type="text" class="form-control" required pattern="^\S+$">
							</div>
							<button class="btn btn-primary btn-sm float-right" type="submit">Save</button>
							<a class="btn btn-warning btn-sm float-right mr-3" href="<?= base_url("admin/pages/orders") ?>">Cancel</a>
						<?php endforeach; ?>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="section-block" id="basicform">
			</div>
			<div class="card">
				<h5 class="card-header">Detail Order</h5>
				<div class="card-body">
					<div class="card">
						<div class="card-body">
							<table class="table" style="border: none;">
								<tr class="bg-light">
									<th>Nama Pemesan</th>
									<th>Nomor HP</th>
									<th>Email</th>
									<th>Alamat</th>
									<th>Ekspedisi</th>
									<th>Ongkir</th>
									<th>Total Harga</th>
									<th>Total Bayar</th>
									<th>Status Order</th>
								</tr>

								<tr>
									<?php foreach($detail_order as $row): ?>
										<td><?= ucwords($row->full_name) ?></td>
										<td><?= $row->no_hp ?></td>
										<td><?= $row->email ?></td>
										<td><?= $row->shipping_address ?></td>
										<td><?= ucwords($row->delivery_service) ?></td>
										<td><?= rupiah($row->shipping_cost) ?></td>
										<td><?= rupiah($row->total_pay) ?></td>
										<td style="font-weight: bold;"><?= rupiah($row->total_pay+$row->shipping_cost) ?></td>
										<td><?= ucwords($row->status_order) ?></td>
									<?php endforeach; ?>
								</tr>
							</table>
						</div>
					</div>

					<div class="card">
						<h6 class="card-header">Detail Items</h6>
						<div class="card-body">
							<table class="table" style="border: none;">
								<?php foreach($detail_products as $row): ?>
									<tr>
										<td><img src="<?= base_url("upload/images/products/".$row->image) ?>" class="img-fluid" width="100" height="100"></td>

										<td><?= ucwords($row->name) ?></td>

										<td><?= rupiah($row->selling_price*$row->quantity) ?></td>

										<td><?= number_format($row->quantity) . " pcs"; ?></td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- end data table  -->
	<!-- ============================================================== -->
</div>
</div>

<?php 

function rupiah($angka){

	$hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
	return $hasil_rupiah;

}
?>




