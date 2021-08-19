<?php

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');

$DBhost = "localhost";
$DBuser = "stevedia_p";
$DBpassword = "2=]yuT~.d6u8";
$DBname = "stevedia_p";


$conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBname);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

	$sql = "SELECT * FROM tbl_image WHERE 1";
	$stmt = $conn->prepare($sql); 
	$stmt->bind_param("s", $id);
	$stmt->execute();

	$dbdata = array();

	$result = $stmt->get_result();

	if (mysqli_num_rows($result) > 0) {
		while ( $row = $result->fetch_assoc())  {
			$dbdata[]=$row;
		}
		echo json_encode($dbdata);
	}
	else {
		http_response_code(404);
	}

	$stmt->close();

}

else if ($method === 'POST') {

	$data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format
	
	$fileName  =  $_FILES['sendimage']['name'];
	$tempPath  =  $_FILES['sendimage']['tmp_name'];
	$fileSize  =  $_FILES['sendimage']['size'];
			
	if(empty($fileName))
	{
		$errorMSG = json_encode(array("message" => "please select image", "status" => false));	
		echo $errorMSG;
	}
	else
	{
		$upload_path = 'upload/'; // set upload folder path 
		
		$fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension
			
		// valid image extensions
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
						
		// allow valid image file formats
		if(in_array($fileExt, $valid_extensions))
		{				
			//check file not exist our upload folder path
			if(!file_exists($upload_path . $fileName))
			{
				// check file size '5MB'
				if($fileSize < 5000000){
					move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
				}
				else{		
					$errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));	
					echo $errorMSG;
				}
			}
			else
			{		
				$errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));	
				echo $errorMSG;
			}
		}
		else
		{		
			$errorMSG = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed", "status" => false));	
			echo $errorMSG;		
		}
	}
			
	// if no error caused, continue ....
	if(!isset($errorMSG))
	{
		$query = mysqli_query($conn,'INSERT into tbl_image (name) VALUES("'.$fileName.'")');
				
		echo json_encode(array("message" => "Image Uploaded Successfully", "status" => true));	
	}
}

$conn->close();

?>