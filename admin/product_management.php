<?php 
include 'header.php';
?>


<div class="container">
	<h2 style=" width: 100%; border-bottom: 4px solid gray"><b>Product Master</b></h2>
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">Product Code</th>
					<th scope="col">Product Name</th>
					<th scope="col">Image</th>
					<th scope="col">Price</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$result = mysqli_query($conn, "SELECT * FROM produk");
				$no =1;
				while ($row = mysqli_fetch_assoc($result)) {
				?>
					<tr>
						<td ><?= $no; ?></td>
						<td><?= $row['kode_produk']; ?></td>
						<td><?= $row['nama'];  ?></td>
						<td><img src="../image/produk/<?= $row['image']; ?>" width="100"></td>
						<td>
							<?php 
							if(strpos($row['harga'], ",") == false){
								echo "Rp.".$row['harga']."";
							}else{
								$a = explode(",", $row['harga']);
								echo "Rp".$a[0]." - ".end($a);  

							}
							 ?>
								

							</td>
						<td><a href="edit_produk.php?kode=<?= $row['kode_produk']; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> </a> <a href="proses/del_produk.php?kode=<?= $row['kode_produk']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this data?')"><i class="glyphicon glyphicon-trash"></i> </a>
					</tr>
				<?php
					$no++; 
					}
				 ?>

				</tbody>
			</table>
		<a href="tm_produk.php" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Product</a>
	</div>
	<!-- Button trigger modal -->

	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>

	<?php 
	include 'footer.php';
	?>