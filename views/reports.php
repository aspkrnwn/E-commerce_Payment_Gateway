<?php error_reporting(0); ?>
<div class="container-fluid  dashboard-content">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
		<div class="section-block">
			<h5 class="section-title">Form Report</h5>
			<p>Silahkan pilih jenis laporan yang akan ditampilkan.</p>
		</div>
		<div class="tab-regular">
			<ul class="nav nav-tabs nav-fill" id="myTab7" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="home-tab-justify" data-toggle="tab" href="#home-justify" role="tab" aria-controls="home" aria-selected="true"><i class="far fa-calendar-alt"></i> Rentang Tanggal</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="profile-tab-justify" data-toggle="tab" href="#profile-justify" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-info-circle"></i> Berdasarkan Status</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="contact-tab-justify" data-toggle="tab" href="#contact-justify" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-cubes"></i> Stok Product</a>
				</li>
			</ul>

			<!-- RENTANG TANGGAL -->
			<div class="tab-content" id="myTabContent7">
				<div class="tab-pane fade show active" id="home-justify" role="tabpanel" aria-labelledby="home-tab-justify">
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
				</div>

				<!-- BERDASARKAN STATUS -->
				<div class="tab-pane fade" id="profile-justify" role="tabpanel" aria-labelledby="profile-tab-justify">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="section-block" id="basicform">
								<p>Silahkan pilih status order untuk menampilkan laporan</p>
							</div>
							<div class="card">
								<div class="card-body">
									<form method="post" action="<?= base_url("admin/pages/result/status_order") ?>">
										<div class="form-group">
											<label for="status" class="col-form-label">Status Order : </label>
											<select class="form-control" name="status_order" required>
												<option value="on delivery">On Delivery</option>
												<option value="on process">On Process</option>
												<option value="delivered">Success / Delivered</option>
											</select>
										</div>
										<button class="btn btn-primary btn-sm float-right" type="submit">Check</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- LAPORAN PRODUCT -->
				<div class="tab-pane fade" id="contact-justify" role="tabpanel" aria-labelledby="contact-tab-justify">
					<div class="table-responsive">
						<table id="example" class="table table-striped table-bordered second" style="width:100%">
							<thead class="text-center">
								<tr>
									<th rowspan="2">No</th>
									<th rowspan="2">Image</th>
									<th rowspan="2">Name</th>
									<th rowspan="2">Purchase Price</th>
									<th rowspan="2">Selling Price</th>
									<th rowspan="2">Stock</th>
									<th colspan="3">Penjualan</th>
									<!-- <th rowspan="2">Kenaikan</th> -->
								</tr>

								<tr>
									<th>Keseluruhan</th>
									<th>Bulan Lalu</th>
									<th>Bulan Ini</th>
								</tr>
							</thead>
							<tbody>
								<?php  foreach($products as $row): ?>
									<?php $awal=0; $akhir=0; $no = 1; ?>
									<tr>
										<th><?= $no ?></th>
										<th><img src="<?= base_url("upload/images/products/".$row->image) ?>" alt="Can't load the image" class="img-fluid" style="width: 80px; height: 80px;"></th>
										<th><?= $row->name ?></th>
										<th><?= rupiah($row->purchase_price)  ?></th>
										<th><?= rupiah($row->selling_price) ?></th>
										<th><?= number_format($row->stock) ?></th>

										<th><?= $row->jumlah ?></th>
										<?php if(count($penjualan_bulan_lalu) > 0 || $penjualan_bulan_lalu != NULL): ?>
											<?php $no = 1; foreach($penjualan_bulan_lalu as $last): ?>
											<?php if($last->id == $row->product_id): ?>
												<?php $awal += $last->jumlah_bulan_lalu ?>
												<th><?= $last->jumlah_bulan_lalu ?></th>
											<?php else: ?>
												<!-- <th>0</th> -->
											<?php endif; ?>
										<?php endforeach; ?>
									<?php else: ?>
										<th>0</th>
									<?php endif; ?>

									<?php if(count($penjualan_bulan_ini) > 0 || $penjualan_bulan_ini != NULL): ?>
										<?php $no = 1; foreach($penjualan_bulan_ini as $bulan_ini): ?>
										<?php if($bulan_ini->id == $row->product_id): ?>
											<?php $akhir += $bulan_ini->jumlah_bulan_lalu ?>
											<th><?= $bulan_ini->jumlah_bulan_lalu ?></th>
										<?php else: ?>
											<!-- <th>0</th> -->
										<?php endif; ?>
									<?php endforeach; ?>
								<?php else: ?>
									<th>0</th>
								<?php endif; ?>

								<?php $res_kenaikan = ($akhir-$awal)/$awal*100; ?>
								<!-- 								<th><?php if($awal == 0){echo "Infinity %";}else{echo $res_kenaikan;} ?></th> -->
							</tr>

							<?php $no++; endforeach; ?>
						</tbody>
						<tfoot class="text-center">
							<tr>
								<th rowspan="2">No</th>
								<th rowspan="2">Image</th>
								<th rowspan="2">Name</th>
								<th rowspan="2">Purchase Price</th>
								<th rowspan="2">Selling Price</th>
								<th rowspan="2">Stock</th>
								<th colspan="3">Penjualan</th>
							</tr>
							<tr>
								<th>Keseluruhan</th>
								<th>Bulan Lalu</th>
								<th>Bulan Ini</th>
							</tr>

						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>

<?php 
function rupiah($angka){

	$hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
	return $hasil_rupiah;

}
?>

