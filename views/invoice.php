<!DOCTYPE html>
<html><head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Download PDF</title>
	<style type="text/css">
		*{
			font-family: arial, sans-serif;
		}

		table {
			border-collapse: collapse;
			width: 100%;
		}

		td, th {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even) {
			background-color: #dddddd;
		}

	</style>
</head><body>

	<?php 

	function rupiah($angka){

		$hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
		return $hasil_rupiah;

	}
	?>

	<h4>Detail Customer</h4>
	<table style="margin-bottom: 50px">
		<tr>
			<th>Nama Pemesan</th>
			<th>Nomor HP</th>
			<th>Email</th>
			<th>Ekspedisi</th>
			<th>Alamat</th>
			<th>Total Bayar</th>
		</tr>

		<tr>
			<?php foreach($detail_order as $row): ?>
				<td><?= ucwords($row->full_name) ?></td>
				<td><?= $row->no_hp ?></td>
				<td><?= $row->email ?></td>
				<td><?= ucwords($row->delivery_service) ?></td>
				<td><?= $row->shipping_address ?></td>
				<td><?= rupiah($row->total_pay) ?></td>
			<?php endforeach; ?>
		</tr>
	</table>

	<h4>Detail Items</h4>
	<table>
		<?php foreach($detail_products as $row): ?>
			<tr>
				<td><img src="<?= "https://stpjogja.store/upload/images/products/" . $row->image ?>" class="img-fluid" width="100" height="100"></td>

				<td><?= ucwords($row->name) ?></td>
				<td><?= rupiah($row->selling_price) ?></td>

				<td><?= number_format($row->quantity) . " pcs"; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>

</body></html>