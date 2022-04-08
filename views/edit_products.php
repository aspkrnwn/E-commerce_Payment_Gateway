
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
					<form method="post" action="<?= base_url("admin/pages/update_product") ?>" class="dropzone"
						id="fileupload">
						<?php foreach($products as $row): ?>
							<div class="form-group">
								<label for="input-select">Category</label>
								<select class="form-control" id="category_id" name="category_id" required>
									<?php foreach($categories as $c): ?>
										<option <?php if($c->id==$row->category_id){echo "selected";} ?> value="<?= $c->id ?>"><?= $c->name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="name" class="col-form-label">Name</label>
								<input type="hidden" name="id" value="<?= $row->id ?>">
								<input id="name" name="name" type="text" class="form-control" value="<?= $row->name ?>" required>
							</div>
							<div class="form-group">
								<label for="purchase_price" class="col-form-label">Purchase Price</label>
								<input id="purchase_price" name="purchase_price" value="<?= $row->purchase_price ?>" type="number" min="0" class="form-control" required>
							</div>

							<div class="form-group">
								<label for="selling_price" class="col-form-label">Selling Price</label>
								<input id="selling_price" value="<?= $row->selling_price ?>" name="selling_price" type="number" min="0" class="form-control" required>
							</div>

							<div class="form-group">
								<label for="stock" class="col-form-label">Stock</label>
								<input id="stock" value="<?= $row->stock ?>" name="stock" type="number" min="0" class="form-control" required>
							</div>

							<div class="form-group">
								<label for="image" class="col-form-label">Image</label><br>
								<img src="<?= base_url('upload/images/products/'.$row->image) ?>" alt="Something wrong, can't load the image" class="img-fluid rounded" width=150 height=100>
							</div>

							<div class="form-group" style="margin-bottom: -15px;">
								<label class="col-form-label">Upload new image</label>
							</div>
						<?php endforeach; ?>
						<button class="btn btn-primary btn-sm float-right" style="margin-top: 9%;" type="submit">Update</button>
						<a class="btn btn-warning btn-sm float-right mr-3" href="<?= base_url("admin/pages/products") ?>"  style="margin-top: 9%;">Cancel</a>
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
