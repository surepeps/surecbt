<!DOCTYPE html>
<html lang="en">
<head>
	<title>SureExam | Welcome Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="SureExam | Online Exam Software" />
	<meta name="author" content="Hassan Tijani.A" />
<?php include 'style.php'; ?>
</head>
<body>

	<div class="loader"></div>
	<div id="app">
		<section class="section">
			<div class="container mt-5">
				<div class="row">
					<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
						<div class="login-brand">
							SureExam
						</div>
							<?php include 'pages/'.$page_name.'.php'; ?>
						<div class="simple-footer">
							Copyright &copy; SureExam 2020 V 1.21
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<?php include 'script.php'; ?>

	</body>
	</html>
