
<div class="container-fluid  dashboard-content">
	<!-- ============================================================== -->
	<!-- pageheader -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">Details</h2>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Data Table</a></li>
							<li class="breadcrumb-item" aria-current="page">Order</li>
							<li class="breadcrumb-item active" aria-current="page">Details</li>
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




