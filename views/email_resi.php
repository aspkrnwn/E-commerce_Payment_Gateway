<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<p>Berikut adalah nomor resi Anda : </p>
	<table style="border-collapse: collapse;">
		<tr>
			<td>Order ID</td>
			<td>:</td>
			<td><?= $d['order_id'] ?></td>
		</tr>
		<tr>
			<td>Nomor Resi</td>
			<td>:</td>
			<td><?= $d['receipt_number'] ?></td>
		</tr>
	</table>

</body>
</html>