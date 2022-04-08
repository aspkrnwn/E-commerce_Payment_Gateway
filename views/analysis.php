<?php $baseUrl = "'" . base_url("admin/pages/") . "'"; ?>
<div class="container-fluid  dashboard-content">
	<div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('alert') ?>"></div>
	<!-- ============================================================== -->
	<!-- pageheader -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">Data <?= $title ?></h2>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Master</a></li>
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
		<!-- ============================================================== -->
		<!--area chart  -->
		<!-- ============================================================== -->
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">Penjualan Bulan Ini</h5>
				<div class="card-body">
					<canvas id="transactions_this_month"></canvas>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!--end area chart  -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!--line chart  -->
		<!-- ============================================================== -->
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">Penjualan Keseluruhan</h5>
				<div class="card-body">
					<canvas id="product_sale"></canvas>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!--end line chart  -->
		<!-- ============================================================== -->
	</div>
	<div class="row">
		<!-- ============================================================== -->
		<!--bar chart  -->
		<!-- ============================================================== -->
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">Penjualan Per Bulan</h5>
				<div class="card-body">
					<canvas id="transactions_this_year_by_month"></canvas>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!--end bar chart  -->
		<!-- ============================================================== -->
	</div>
	<div class="row">
		<!-- ============================================================== -->
		<!-- upadating chart  -->
		<!-- ============================================================== -->
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">Product By Category </h5>
				<div class="card-body">
					<canvas id="product_by_category"></canvas>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- end upadating chart  -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- donut chart  -->
		<!-- ============================================================== -->
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">Tabel Jumlah Penjualan Produk</h5>
				<div class="card-body p-0">
					<ul class="country-sales list-group list-group-flush">
						<?php if(count($count_product_sale) > 0): ?>
							<?php foreach($count_product_sale as $row): ?>
								<li class="country-sales-content list-group-item"><span class="mr-2">
									<img class="img-fluid" src="<?= base_url("upload/images/admin/".$row->image) ?>" alt="">
								</span>
								<span class=""><?= $row->name ?></span><span class="float-right text-dark"><?= $row->jumlah ?></span>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<div class="card-footer text-center">
				<!-- <a href="#" class="btn-primary-link">View Details</a> -->
			</div>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- end donut chart  -->
	<!-- ============================================================== -->
</div>
</div>


<!-- Alert -->
<script src="<?= base_url('properties/admin/') ?>assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<!-- Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');

	if(flashData){
		Swal.fire({
			text: '' + flashData,
			icon: 'success',
			timer: 5000
		})
	}

</script>

<!-- PRODUCT SALE -->
<script type="text/javascript">
	var ctx = document.getElementById("product_sale");
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: [<?php 
				if(count($product_sale) > 0){
					foreach($product_sale as $data){
						echo '"'.$data->name.'"' . ", ";
					}
				}
				?>],
				datasets: [{
					label: 'Penjualan Produk Keseluruhan',
					data: [<?php 
						if(count($product_sale) > 0){
							foreach($product_sale as $data){
								echo '"'.$data->total.'"' . ", ";
							}
						}
						?>],
						borderColor: [
						'rgba(52, 168, 254, 0.8)'
						],
						backgroundColor: [
						'rgba(196, 229, 254, 0.8)'
						],
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						y: {
							min: 0,
							max: 100,
						},
						x: {
							display: false
						}
					}

				}
			});
		</script>

		<!-- TRANSACTION THIS MONTH -->
		<script type="text/javascript">
			var ctx = document.getElementById("transactions_this_month");
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: [<?php 
						if(count($transactions_this_month) > 0){
							foreach($transactions_this_month as $data){
								echo '"'.$data->name.'"' . ", ";
							}
						}
						?>],
						datasets: [{
							label: 'Penjualan Bulan Ini',
							data: [<?php 
								if(count($transactions_this_month) > 0){
									foreach($transactions_this_month as $data){
										echo '"'.$data->total.'"' . ", ";
									}
								}
								?>],
								borderColor: [
								'rgba(52, 168, 254, 0.8)'
								],
								backgroundColor: [
								'rgba(196, 229, 254, 0.8)'
								],
								borderWidth: 1
							}]
						},
						options: {
							scales: {
								y: {
									min: 0,
									max: 100,
								},
								x: {
									display: false
								}
							}

						}
					});
				</script>

				<!-- TRANSACTION THIS YEAR GROUP BY MONTH -->
				<script type="text/javascript">
					var ctx = document.getElementById("transactions_this_year_by_month");
					var myChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: ["Jan" , "Feb" , "Mar" , "Apr" , "Mei" , "Juni", "Ags" , "Sep" , "Okt" , "Nov", "Des"],
							datasets: [{
								label: 'Penjualan Per Bulan',
								fill: false,
								data: [<?php 
									if(count($transactions_this_year_by_month) > 0){
										foreach($transactions_this_year_by_month as $data){
											echo '"'.$data->TOTAL.'"' . ", ";
										}
									}
									?>],
									backgroundColor: [
									'rgba(255, 99, 132, 0.2)',
									'rgba(255, 159, 64, 0.2)',
									'rgba(255, 205, 86, 0.2)',
									'rgba(75, 192, 192, 0.2)',
									'rgba(54, 162, 235, 0.2)',
									'rgba(153, 102, 255, 0.2)',
									'rgba(201, 203, 207, 0.2)'
									],
									borderColor: [
									'rgb(255, 99, 132)',
									'rgb(255, 159, 64)',
									'rgb(255, 205, 86)',
									'rgb(75, 192, 192)',
									'rgb(54, 162, 235)',
									'rgb(153, 102, 255)',
									'rgb(201, 203, 207)'
									],
									borderWidth: 1
								}]
							},
							options: {
								indexAxis: 'y',
								scales: {
									x: {
										min: 0,
										max: 100,
									}
								}
							}
						});
					</script>

					<!-- PRODUCT BY CATEGORY -->
					<script type="text/javascript">
						var ctx = document.getElementById("product_by_category");
						var myChart = new Chart(ctx, {
							type: 'doughnut',
							data: {
								labels: [<?php 
									if(count($product_by_category) > 0){
										foreach($product_by_category as $data){
											echo '"'.$data->name.'"' . ", ";
										}
									}
									?>],
									datasets: [{
										label: 'Penjualan Per Bulan',
										fill: false,
										data: [<?php 
											if(count($product_by_category) > 0){
												foreach($product_by_category as $data){
													echo '"'.$data->jumlah.'"' . ", ";
												}
											}
											?>],
											backgroundColor: [
											'rgba(255, 99, 132, 0.2)',
											'rgba(255, 159, 64, 0.2)',
											'rgba(255, 205, 86, 0.2)',
											'rgba(75, 192, 192, 0.2)',
											'rgba(54, 162, 235, 0.2)',
											'rgba(153, 102, 255, 0.2)',
											'rgba(201, 203, 207, 0.2)'
											],
											borderColor: [
											'rgb(255, 99, 132)',
											'rgb(255, 159, 64)',
											'rgb(255, 205, 86)',
											'rgb(75, 192, 192)',
											'rgb(54, 162, 235)',
											'rgb(153, 102, 255)',
											'rgb(201, 203, 207)'
											],
											borderWidth: 1
										}]
									},
									options: {
									}
								});
							</script>