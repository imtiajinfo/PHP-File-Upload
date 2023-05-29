<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PHP File Upload</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<?php 
		    $fileError = '';
		    $success = '';
		    
			if (isset($_POST['upload'])) {
				// echo "<pre>";
				// var_dump($_FILES);
				// echo "</pre>";
				$file_name = $_FILES['image']['name'];
				$file_type = $_FILES['image']['type'];
				$file_tmp_name = $_FILES['image']['tmp_name'];
				$file_size = $_FILES['image']['size'];
				$file_error = $_FILES['image']['error'];

				//for check without validation
				//echo $file_name;

				$uploadDir = 'uploads/';
				$allowExt = ['jpg', 'png', 'jpeg', 'gif'];
				$fileArray = explode('.', $file_name);

				//print_r($fileArray[1]);
				$ext = strtolower(end($fileArray));

				// fileArray & extension in one line
				//$fileExt = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
				// print_r($ext);
				$uniqueImage = substr(md5(time() . uniqid()), 0, 20).'.'.$ext;
				// md5 generate 32 digit,time method for time uniqid for genrate individual uniq id
				if($file_error > 0){
					$fileError = "Plese Select Image First";
				}elseif($allowExt != $uniqueImage){
					$fileError = "Image Should be valid extension";
				}elseif($file_size > 1048576){
					// 1024*1024=1048576 (1 Mb) in binary
					$fileError = "File Size must be less than 1 MB";
				}else{
					move_uploaded_file($file_tmp_name, $uploadDir . $uniqueImage);
					$success = "Successfully Image Uploaded";
				}
			}

		 ?>
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">PHP File Upload</h4>
					</div>
					<div class="card-body">
						<form action="" method="POST" enctype="multipart/form-data">
							<div class="mb-4">
								<input type="file" name="image" class="form-control">
								<p class="text-danger"><?php echo $fileError ?></p>
								<p class="text-success"><?php echo $success ?></p>
							</div>
							<div>
								<button type="submit" name="upload" class="btn btn-success">Upload</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<?php
						// Directory containing the uploaded images
						$uploadDir = 'uploads/';
						
						// Get all image file names in the directory
						$showImages = glob($uploadDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
						
						// Loop through the image files and display them
						foreach ($showImages as $disImage) {
							echo '<img src="' . $disImage . '" alt="Uploaded Image" style="height: 150px; width: 150px;"><br>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>