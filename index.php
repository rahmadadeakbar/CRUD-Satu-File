<!DOCTYPE html>
<html>

<head>
	<title>CRUD 1 File Kodingasyik</title>
	<link rel="icon" href="https://i1.wp.com/kodingasyik.com/wp-content/uploads/2019/07/cropped-koding-asyik-1.png?fit=32%2C32" />
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="judul">
		<h2>CRUD SATU FILE KODINGASYIK</h2>
	</div>

	<?php

	// --- koneksi ke database
	$koneksi = mysqli_connect("localhost", "root", "", "crudsatufile") or die(mysqli_error());

	// --- Fngsi tambah data (Create)
	function tambah($koneksi)
	{

		if (isset($_POST['tambah'])) {
			$id = time();
			$nama_mobil = $_POST['nama_mobil'];
			$stnk = $_POST['no_stnk'];
			$plat = $_POST['plat'];
			$pajak = $_POST['pajak'];
			$warna = $_POST['warna'];

			if (!empty($nama_mobil) && !empty($stnk) && !empty($plat) && !empty($pajak) && !empty($warna)) {
				$sql = "INSERT INTO mobil (id_mobil,nama_mobil,no_stnk,plat,pajak,warna) VALUES('$id','$nama_mobil','$stnk','$plat','$pajak','$warna')";
				$simpan = mysqli_query($koneksi, $sql);
				if ($simpan && isset($_GET['aksi'])) {
					if ($_GET['aksi'] == 'create') {
						echo '<script>alert("data berhasil di input")
								window.location.href="index.php";
								window.history.back();
							
							</script>';
					}
				}
			} else {
				$pesan = "Tidak dapat menyimpan, data belum lengkap!";
			}
		}

	?>
		<form action="" method="POST">
			<fieldset style="background: #af9517bf;">
				<legend>
					<h2>Tambah Data Mobil</h2>
				</legend>
				<table cellpadding="3" cellspacing="0">
					<tr>
						<td>Nama Mobil</td>
						<td>:</td>
						<td><input type="text" name="nama_mobil" size="30" required></td>
					</tr>
					<tr>
						<td>Nomor STNK</td>
						<td>:</td>
						<td><input type="number" name="no_stnk" size="30" required></td>
					</tr>
					<tr>
						<td>Plat Mobil</td>
						<td>:</td>
						<td><input type="text" name="plat" size="30" required></td>
					</tr>
					<tr>
						<td>Tanggal Akhir Pajak</td>
						<td>:</td>
						<td><input type="date" name="pajak" size="30" required></td>
					</tr>
					<tr>
						<td>Warna Mobil</td>
						<td>:</td>
						<td><input type="color" name="warna" size="30" required></td>
					</tr>

					<tr>
						<td>&nbsp;</td>
						<td></td>
						<td>
							<button type="submit" name="tambah">Tambah</button>
							<button type="reset">Reset</button>
						</td>
					</tr>
				</table>
				<p><?php echo isset($pesan) ? $pesan : "" ?></p>
			</fieldset>
		</form>
	<?php

	} ?>
	<!-- Tutup Fngsi tambah data


	Fungsi Baca Data (Read) -->
	<?php
	function tampil_data($koneksi)
	{
		$sql = "SELECT * FROM mobil";
		$query = mysqli_query($koneksi, $sql);
	?>

		<fieldset>
			<legend>
				<h2>Data Panen</h2>
			</legend>

			<table border='1' cellpadding='10'>
				<tr>
					<th>No</th>
					<th>Nama Mobil</th>
					<th>Nomor STNK</th>
					<th>Plat Mobil</th>
					<th>Masa Berlaku Pajak</th>
					<th>Warna Mobil</th>
					<th>Tindakan</th>
				</tr>
				<?php
				$no = 1;
				while ($data = mysqli_fetch_array($query)) {
				?>
					<tr>
						<td><?php echo $no ?></td>
						<td><?php echo $data['nama_mobil']; ?></td>
						<td><?php echo $data['no_stnk']; ?></td>
						<td><?php echo $data['plat']; ?> bulan</td>
						<td>Sampai Tanggal : <?php echo $data['pajak']; ?></td>
						<td>
							<p style="color:white; padding:10px; background-color:<?php echo $data['warna']; ?>;">Warna</p>
						</td>
						</td>
						<td>
							<a href="index.php?aksi=update&id=<?php echo $data['id']; ?>&nama=<?php echo $data['nama_mobil']; ?>&hasil=<?php echo $data['hasil_panen']; ?>&lama=<?php echo $data['lama_tanam']; ?>&tanggal=<?php echo $data['tanggal_panen']; ?>">Ubah</a> |
							<a href="index.php?aksi=delete&id=<?php echo $data['id_mobil']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus?')" class="btn btn-danger">Hapus</a>
						</td>
					</tr>
				<?php
					$no++;
				}
				echo "</table>";
				echo "</fieldset>";
			}
			// --- Tutup Fungsi Baca Data (Read)


			// --- Fungsi Ubah Data (Update)
			function ubah($koneksi)
			{

				// ubah data
				if (isset($_POST['btn_ubah'])) {
					$id = $_POST['id'];
					$nm_tanaman = $_POST['nm_tanaman'];
					$hasil = $_POST['hasil'];
					$lama = $_POST['lama'];
					$tgl_panen = $_POST['tgl_panen'];

					if (!empty($nm_tanaman) && !empty($hasil) && !empty($lama) && !empty($tgl_panen)) {
						$perubahan = "nama_tanaman='" . $nm_tanaman . "',hasil_panen=" . $hasil . ",lama_tanam=" . $lama . ",tanggal_panen='" . $tgl_panen . "'";
						$sql_update = "UPDATE mobil SET " . $perubahan . " WHERE id=$id";
						$update = mysqli_query($koneksi, $sql_update);
						if ($update && isset($_GET['aksi'])) {
							if ($_GET['aksi'] == 'update') {
								header('location: index.php');
							}
						}
					} else {
						$pesan = "Data tidak lengkap!";
					}
				}

				// tampilkan form ubah
				if (isset($_GET['id'])) {
				?>
					<a href="index.php"> &laquo; Home</a> |
					<a href="index.php?aksi=create"> (+) Tambah Data</a>
					<hr>

					<form action="" method="POST">
						<fieldset>
							<legend>
								<h2>Ubah data</h2>
							</legend>
							<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
							<label>Nama tanaman <input type="text" name="nm_tanaman" value="<?php echo $_GET['nama'] ?>" /></label> <br>
							<label>Hasil panen <input type="number" name="hasil" value="<?php echo $_GET['hasil'] ?>" /> kg</label><br>
							<label>Lama tanam <input type="number" name="lama" value="<?php echo $_GET['lama'] ?>" /> bulan</label> <br>
							<label>Tanggal panen <input type="date" name="tgl_panen" value="<?php echo $_GET['tanggal'] ?>" /></label> <br>
							<br>
							<label>
								<input type="submit" name="btn_ubah" value="Simpan Perubahan" /> atau <a href="index.php?aksi=delete&id=<?php echo $_GET['id'] ?>"> (x) Hapus data ini</a>!
							</label>
							<br>
							<p><?php echo isset($pesan) ? $pesan : "" ?></p>

						</fieldset>
					</form>
			<?php
				}
			}
			// --- Tutup Fungsi Update


			// --- Fungsi Delete
			function hapus($koneksi)
			{

				if (isset($_GET['id']) && isset($_GET['aksi'])) {
					$id = $_GET['id'];
					$sql_hapus = "DELETE FROM mobil WHERE id_mobil=" . $id;
					$hapus = mysqli_query($koneksi, $sql_hapus);

					if ($hapus) {
						if ($_GET['aksi'] == 'delete') {
							header('location: index.php');
						}
					}
				}
			}
			// --- Tutup Fungsi Hapus


			// ===================================================================

			// --- Program Utama
			if (isset($_GET['aksi'])) {
				switch ($_GET['aksi']) {
					case "create":
						echo '<a href="index.php"> &laquo; Home</a>';
						tambah($koneksi);
						break;
					case "read":
						tampil_data($koneksi);
						break;
					case "update":
						ubah($koneksi);
						tampil_data($koneksi);
						break;
					case "delete":
						hapus($koneksi);
						break;
					default:
						echo "<h3>Aksi <i>" . $_GET['aksi'] . "</i> tidaka ada!</h3>";
						tambah($koneksi);
						tampil_data($koneksi);
				}
			} else {
				tambah($koneksi);
				tampil_data($koneksi);
			}

			?>
</body>

</html>