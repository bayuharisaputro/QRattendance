<?php
	session_start();
	include "koneksi.php";
	
    $nim 	= $_POST['nim'];
    $pass 	= $_POST['pass'];
	
	class emp{}
	
	if (empty($nim)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "Error mengambil Data"; 
		die(json_encode($response));
	} else {
		$query 	= mysqli_query($connect, "SELECT * FROM mhs WHERE nim='".$nim."' and password='".$pass."'");
		$row 	= mysqli_fetch_array($query);
		
		if (!empty($row)) {
			$response = new emp();
			$response->success = 1;
			$response->nim = $row["nim"];
			$response->password = $row["password"];
            $response->nama_mahasiswa = $row["nama_mahasiswa"];
            $response->jk = $row["jk"];
			$response->agama = $row["agama"];
			$response->kota_lahir = $row["kota_lahir"];
			$response->tanggal_lahir = $row["tanggal_lahir"];
			$response->kelas = $row["kelas"];
			$response->alamat = $row["alamat"];
			$response->kota = $row["kota"];
			$response->provinsi = $row["provinsi"];
			$response->kelas= $row["kelas"];
			$response->izin= $row["jumlah_izin"];
			$response->sakit= $row["jumlah_sakit"];
			$response->alpha= $row["jumlah_alpha"];
			die(json_encode($response));
		} else{ 
			$response = new emp();
			$response->success = 0;
			$response->message = "error";
			die(json_encode($response)); 
		}	
	}
?>