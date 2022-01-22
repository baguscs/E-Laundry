
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>E-Laundry</title>
<link href="{{ asset('css/styles.css') }}" media="all" rel="stylesheet" type="text/css" />
</head>
<style>
    .txt{
        text-align: right;
    }
</style>
<body itemscope itemtype="http://schema.org/EmailMessage">

<table class="body-wrap">
	<tr>
		<td></td>
		<td class="container" width="600">
			<div class="content">
				<table class="main" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="content-wrap aligncenter">
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td class="content-block">
										<h1 class="aligncenter">Verification E-Mail Akun</h1>
									</td>
								</tr>
								<tr>
									<td class="content-block">
                                    <h2 class="aligncenter">Hi, {{$nama}}</h2>
									</td>
								</tr>
								<tr>
									<td class="content-block">Selamat anda telah terdaftar menjadi pegawai E-Laundry Mitra Jaya, silahkan masukkan kode dibawah ini</td>
								</tr>
								<tr>
									<td class="content-block aligncenter">
										<table class="invoice">
											<tr>
												<td>
													<table class="invoice-items" cellpadding="10" cellspacing="5">
														<tr>
															<td>Kode Akses</td>
															<td>:</td>
															<td class="aligncenter">{{$kode}}</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<br>
								<tr>
									<td class="">
										Mohon segera masukkan kode ini, agar anda bisa menggunakan fitur dari E-Laundry ini. Terima Kasih.
									</td>
								</tr>
								<tr>
									<td class="">
                                        <p class="txt">Hormat saya,</p>
                                        <p class="txt">Bagus Cahyo S</p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</div>
		</td>
		<td></td>
	</tr>
</table>

</body>
</html>
