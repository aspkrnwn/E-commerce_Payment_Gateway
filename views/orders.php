<?php $baseUrl = "'" . base_url("admin/pages/") . "'"; ?>
<div class="container-fluid  dashboard-content">
	<div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('alert') ?>"></div>
	<!-- ============================================================== -->
	<!-- pagehader  -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">Data <?= $title ?></h2>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Data Table</a></li>
							<li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- pagehader  -->
	<!-- ============================================================== -->
	<div class="row">
		<!-- metric -->
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="text-muted">All Orders</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1 text-primary"><?= $all_orders ?></h1>
					</div>
					<div class="metric-label d-inline-block float-right text-success">
					</div>
				</div>
				<div id="sparkline-1"></div>
			</div>
		</div>
		<!-- /. metric -->
		<!-- metric -->
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="text-muted">Orders Success</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1 text-primary"><?= $success_orders ?> </h1>
					</div>
					<div class="metric-label d-inline-block float-right text-danger">
					</div>
				</div>
				<div id="sparkline-2"></div>
			</div>
		</div>
		<!-- /. metric -->
		<!-- metric -->
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="text-muted">On Delivery</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1 text-primary"><?= $on_delivery ?></h1>
					</div>
					<div class="metric-label d-inline-block float-right text-danger">
					</div>
				</div>
				<div id="sparkline-3">
				</div>
			</div>
		</div>
		<!-- /. metric -->
		<!-- metric -->
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="text-muted">Waiting Approval</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1 text-primary"><?= $waiting_approval ?></h1>
					</div>
					<div class="metric-label d-inline-block float-right text-success">
					</div>
				</div>
				<div id="sparkline-4"></div>
			</div>
		</div>
		<!-- /. metric -->
	</div>



	<!-- ALL ORDERS TABLE -->
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">All Order</h2>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Data Table</a></li>
							<li class="breadcrumb-item" aria-current="page"><?= $title ?></li>
							<li class="breadcrumb-item active" aria-current="page">Incoming</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="table table-striped table-bordered second" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Customer Name</th>
									<th>Date Order</th>
									<th>Status</th>
									<th>Total Pay</th>
									<th>Delivery Service</th>
									<th>Receipt Number</th>
									<!-- <th>Note</th> -->
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; foreach($orders as $row): ?>
								<tr>
									<th><?= $no++ ?></th>
									<th><?= $row->full_name ?></th>
									<th><?= date('d M Y H:i', strtotime($row->created_at)) . " WIB";  ?></th>
									<th><?= checkStatus($row->status_order) ?></th>
									<th><?= rupiah($row->total_pay + $row->shipping_cost) ?></th>
									<th><?= ucwords($row->delivery_service) ?></th>
									<th><?= $row->receipt_number ?></th>
									<!-- <th><?= $row->note ?></th> -->
									<th>
										<?= checkAction($row->id, $row->status_order, $row->customer_id) ?>
									</th>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<th>No</th>
								<th>Customer Name</th>
								<th>Date Order</th>
								<th>Status</th>
								<th>Total Pay</th>
								<th>Delivery Service</th>
								<th>Receipt Number</th>
								<!-- <th>Note</th> -->
								<th>Action</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Order need to be Processed -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="page-header">
			<h2 class="pageheader-title">Orders need to be processed</h2>
			<div class="page-breadcrumb">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Data Table</a></li>
						<li class="breadcrumb-item" aria-current="page"><?= $title ?></li>
						<li class="breadcrumb-item active" aria-current="page">Need to be processed</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-striped table-bordered second" style="width:100%">
						<thead>
							<tr>
								<th>No</th>
								<th>Customer Name</th>
								<th>Date Order</th>
								<th>Total Pay</th>
								<th>Delivery Service</th>
								<th>Receipt Number</th>
								<!-- <th>Note</th> -->
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1; foreach($orders_to_processed as $row): ?>
							<tr>
								<th><?= $no++ ?></th>
								<th><?= $row->full_name ?></th>
								<th><?= date('d M Y H:i', strtotime($row->created_at)) . " WIB";  ?></th>
								<th><?= rupiah($row->total_pay + $row->shipping_cost) ?></th>
								<th><?= ucwords($row->delivery_service) ?></th>
								<th><?= $row->receipt_number ?></th>
								<!-- <th><?= $row->note ?></th> -->
								<th>
									<a href="<?= base_url("admin/pages/process_order/".$row->id . "/" . $row->customer_id) ?>" style="text-decoration: none;"><span class="badge badge-pill badge-success">Process Order</span></a>
								</th>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Customer Name</th>
							<th>Date Order</th>
							<th>Total Pay</th>
							<th>Delivery Service</th>
							<th>Receipt Number</th>
							<!-- <th>Note</th> -->
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
<!-- End of Order need to be Processed -->
</ul>
</div>
</div>
</div>
</div>
</div>

<?php 
function checkStatus($status_order){
	if($status_order == "success"){
		echo '<span class="badge badge-pill badge-success">'. ucwords($status_order) .'</span>';
	}else if($status_order == "on delivery"){
		echo '<span class="badge badge-pill badge-secondary">'. ucwords($status_order) .'</span>';
	}else if($status_order == "waiting approval"){
		echo '<span class="badge badge-pill badge-warning">'. ucwords($status_order) .'</span>';
	}else if($status_order == "on process"){
		echo '<span class="badge badge-pill badge-info">'. ucwords($status_order) .'</span>';
	}else{
		echo '<span class="badge badge-pill badge-danger">'. ucwords($status_order) .'</span>';
	}
}

function checkAction($id, $status_order, $customer_id){
	$baseUrl = "'" . base_url("admin/pages/") . "'";

	if($status_order == "waiting approval"): ?>
		<a href="<?= base_url("admin/pages/details/".$id) ?>" class="btn btn-sm btn-info">Details</a>
		<button class="btn btn-success btn-sm" onclick="updateStatusOrder(<?= "'" . $id . "'"?>, 'accept', <?= $baseUrl ?>)">Accept</button>
	<?php elseif ($status_order == "on delivery"): ?>
		<a href="<?= base_url("admin/pages/details/".$id) ?>" class="btn btn-sm btn-info">Details</a>
		<a class="btn btn-danger btn-sm" target="_blank" href="<?= base_url("admin/pages/download_pdf/".$id."/"."orders"."/".$customer_id) ?>">Download</a>
		<a href="<?= base_url("admin/pages/terima_barang/".$id) ?>" class="badge badge-pill badge-success">Barang Diterima</a>
	<?php else: ?>
		<a href="<?= base_url("admin/pages/details/".$id) ?>" class="btn btn-sm btn-info">Details</a>
	<?php endif; 

}

function rupiah($angka){

	$hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
	return $hasil_rupiah;

}
?>



<!-- Alert -->
<script src="<?= base_url('properties/admin/') ?>assets/vendor/jquery/jquery-3.3.1.min.js"></script>
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