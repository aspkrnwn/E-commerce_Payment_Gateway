<div class="influence-profile">
    <div class="container-fluid dashboard-content ">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h3 class="mb-2">Admin Profile </h3>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Admin Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- content -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- profile -->
            <!-- ============================================================== -->
            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-12 col-12">
                <!-- ============================================================== -->
                <!-- card profile -->
                <!-- ============================================================== -->
                <div class="card">
                    <div class="card-body">
                        <div class="img-profile">
                            <div class="card card-figure">
                                <figure class="figure">
                                    <div class="figure-img">
                                        <img style="width: 100%; height: 150px" class="img-fluid" src="<?= base_url("upload/images/admin/".$user->image) ?>" alt="Card image cap">
                                        <div class="figure-action">
                                            <a href="#" class="btn btn-block btn-sm btn-primary btn-update-profile">Change</a>
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        </div>
                        <div class="update-profile">
                            <form method="post" action="<?= base_url("admin/pages/change_profile_image") ?>" class="dropzone" id="updateProfile">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary btn-sm btn-danger btn-close">Close</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="text-center">
                            <h2 class="font-24 mb-0"><?= ucwords($user->username) ?></h2>
                            <p>Administrator STP</p>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h3 class="font-16">Contact Information</h3>
                        <div class="">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-fw fa-envelope mr-2"></i><?= $user->email ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end card profile -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- end profile -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- campaign data -->
            <!-- ============================================================== -->
            <div class="col-xl-9 col-lg-9 col-md-7 col-sm-12 col-12">
                <!-- ============================================================== -->
                <!-- campaign tab one -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- sales  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <h5 class="text-muted">Customers</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1"><?= $customers ?></h1>
                                </div>
                                <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                    <span class="icon-circle-small icon-box-xs text-success bg-primary-light">
                                        <i class="fas fa-child"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end sales  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- new customer  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <h5 class="text-muted">Products</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1"><?= $products ?></h1>
                                </div>
                                <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                    <span class="icon-circle-small icon-box-xs text-primary bg-primary-light">
                                        <i class="fas fa-boxes"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end new customer  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- visitor  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <h5 class="text-muted">Categories</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1"><?= $categories ?></h1>
                                </div>
                                <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                    <span class="icon-circle-small icon-box-xs text-info bg-primary-light">
                                        <i class="fas fa-th-list"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end visitor  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- total orders  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <h5 class="text-muted">New Orders</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1"><?= $count_incoming ?></h1>
                                </div>
                                <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                    <span class="icon-circle-small icon-box-xs text-warning bg-primary-light">
                                        <i class="fas fa-shopping-cart"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end total orders  -->
                    <!-- ============================================================== -->
                </div>

                <div class="influence-profile-content pills-regular">
                 <div class="card">
                    <h5 class="card-header">Recent Orders</h5>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">Image</th>
                                        <th class="border-0">Product Name</th>
                                        <th class="border-0">Order Id</th>
                                        <th class="border-0">Quantity</th>
                                        <th class="border-0">Price</th>
                                        <th class="border-0">Order Time</th>
                                        <th class="border-0">Customer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($incoming) > 0): ?>
                                        <?php $no=1; foreach($incoming as $row): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <div class="m-r-10"><img src="<?= base_url("upload/images/products/".$row->image) ?>" alt="Failed load" class="rounded" width="45"></div>
                                            </td>
                                            <td><?= $row->name ?></td>
                                            <td><?= $row->order_id ?></td>
                                            <td><?= number_format($row->quantity) ?></td>
                                            <td><?= rupiah($row->selling_price) ?></td>
                                            <td><?= date("d-m-Y H:s", strtotime($row->transaction_time)) . " WIB"; ?></td>
                                            <td><?= ucwords($row->full_name) ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="9"><a href="<?= base_url("admin/pages/orders/") ?>" class="btn btn-outline-light float-right">View Details</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center;">No new orders</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end campaign tab one -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end campaign data -->
    <!-- ============================================================== -->
    <div class="alert_success_login" data-flashdata="<?php echo $this->session->flashdata('alert_success_login') ?>"></div>
</div>
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
    const alert_success_login = $('.alert_success_login').data('flashdata');
    console.log(alert_success_login)
    if(alert_success_login){
        Swal.fire({
            text: '' + alert_success_login,
            icon: 'success',
            timer: 5000
        })
    }
</script>
