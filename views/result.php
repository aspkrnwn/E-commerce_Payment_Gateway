<?php $baseUrl = "'" . base_url("admin/pages/") . "'"; ?>
<div class="container-fluid  dashboard-content">
	<div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('alert') ?>"></div>
	<!-- ============================================================== -->
	<!-- pagehader  -->
	<!-- ============================================================== -->
	<!-- ALL ORDERS TABLE -->
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">Result Report</h2>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Data</a></li>
							<li class="breadcrumb-item" aria-current="page">Report</li>
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
									<th>Note</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; foreach($report as $row): ?>
								<tr>
									<th><?= $no++ ?></th>
									<th><?= $row->full_name ?></th>
									<th><?= date('d M Y H:i', strtotime($row->created_at)) . " WIB";  ?></th>
									<th><?= checkStatus($row->status_order) ?></th>
									<th><?= rupiah($row->total_pay + $row->shipping_cost) ?></th>
									<th><?= ucwords($row->delivery_service) ?></th>
									<th><?= $row->receipt_number ?></th>
									<th><?= $row->note ?></th>
									<th>
										<a href="<?= base_url("admin/pages/details/".$row->order_id) ?>" class="btn btn-sm btn-info">Details</a>
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
								<th>Note</th>
								<th>Action</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
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
		<button class="btn btn-success btn-sm" onclick="updateStatusOrder(<?= "'" . $id . "'"?>, 'accept', <?= $baseUrl ?>)">Accept</button>
	<?php elseif ($status_order == "on delivery"): ?>
		<a class="btn btn-danger btn-sm" target="_blank" href="<?= base_url("admin/pages/download_pdf/".$id."/"."orders"."/".$customer_id) ?>">Download</a>
	<?php else: ?>
		<span class="badge badge-pill badge-light">No Action</span>
	<?php endif; 

}

function rupiah($angka){

	$hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
	return $hasil_rupiah;

}
?>

