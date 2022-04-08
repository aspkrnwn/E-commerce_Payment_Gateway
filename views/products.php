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
                    <a class="btn btn-primary btn-sm float-right mb-3" href="<?= base_url("admin/pages/add/".$title) ?>">Add</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered second" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Purchase Price</th>
                                    <th>Selling Price</th>
                                    <th>Stock</th>
                                    <th>Image</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach($products as $row): ?>
                                <tr>
                                    <th><?= $no++ ?></th>
                                    <th><?= $row->name ?></th>
                                    <th><?= rupiah($row->purchase_price)  ?></th>
                                    <th><?= rupiah($row->selling_price) ?></th>
                                    <th><?= number_format($row->stock) ?></th>
                                    <th><img src="<?= base_url("upload/images/products/".$row->image) ?>" alt="Can't load the image" class="img-fluid" style="width: 80px; height: 80px;"></th>
                                    <th><?= $row->updated_at ?></th>
                                    <th>
                                        <a class="btn btn-warning" href="<?= base_url("admin/pages/edit/".$title."/".$row->id) ?>">Edit</a>
                                        <button class="btn btn-danger" onclick="delete_data(<?= $row->id ?>, 'products', <?= $baseUrl ?>)">Delete</button>
                                    </th>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Purchase Price</th>
                                <th>Selling Price</th>
                                <th>Stock</th>
                                <th>Image</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
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

<!-- Alert -->
<script src="<?= base_url('properties/admin/') ?>assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    const flashData = $('.flash-data').data('flashdata');
    console.log(flashData)
    if(flashData){
        Swal.fire({
            text: '' + flashData,
            icon: 'success',
            timer: 5000
        })
    }
</script>

