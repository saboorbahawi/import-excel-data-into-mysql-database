<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include PhpSpreadsheet library autoloader 
require_once 'vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\Reader\Xlsx; 
 
if(isset($_POST['importSubmit'])){ 
     
    // Allowed mime types 
    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
     
    // Validate whether selected file is a Excel file 
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)){ 
         
        // If the file is uploaded 
        if(is_uploaded_file($_FILES['file']['tmp_name'])){ 
            $reader = new Xlsx(); 
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']); 
            $worksheet = $spreadsheet->getActiveSheet(); 
            $sheet1 = $spreadsheet->getSheetByName('Sheet1'); 
            $sheet2 = $spreadsheet->getSheetByName('Sheet2'); 

            // conver data into array
            $sheet1Data = $sheet1->toArray();
            $sheet2Data = $sheet2->toArray();
            // convert data into json
            // Sheet1 columns and values
            
             unset($sheet1Data[1]);
             foreach($sheet1Data as $row){
                print_r($row[0] . '<br>');
                print_r($row[1] . '<br>');
                print_r($row[2] . '<br>');
                print_r($row[3] . '<br>');

             }
            // Output data from Sheet 1
             
            // echo "Data from Sheet 2:\n";
            // foreach ($sheet2Data as $row) {
            //     echo implode("\t", $row) . "\n";
            // }
            // print_r($sheet2->toArray());
            // print_r($worksheet);
            $worksheet_arr = $worksheet->toArray(); 
            // print_r(json_encode($spreadsheet));
            // Remove header row 
            unset($worksheet_arr[0]); 
 
            // foreach($worksheet_arr as $row){ 
            //     $first_name = $row[0]; 
            //     $last_name = $row[1]; 
            //     $email = $row[2]; 
            //     $phone = $row[3]; 
            //     // $status = $row[4]; 
            //     $status = ($row[4] == "Active") ? 1 : 0; 

            //     // Check whether member already exists in the database with the same email 
            //     $prevQuery = "SELECT id FROM members WHERE email = '".$email."'"; 
            //     $prevResult = $db->query($prevQuery); 
                 
            //     if($prevResult->num_rows > 0){ 
            //         // Update member data in the database 
            //         $db->query("UPDATE members SET first_name = '".$first_name."', last_name = '".$last_name."', email = '".$email."', phone = '".$phone."', status = '".$status."', modified = NOW() WHERE email = '".$email."'"); 
            //     }else{ 
            //         // Insert member data in the database 
            //         $db->query("INSERT INTO members (first_name, last_name, email, phone, status, created, modified) VALUES ('".$first_name."', '".$last_name."', '".$email."', '".$phone."', '".$status."', NOW(), NOW())"); 
            //     } 
            // } 
             
            $qstring = '?status=succ'; 
        }else{ 
            $qstring = '?status=err'; 
        } 
    }else{ 
        $qstring = '?status=invalid_file'; 
    } 
} 
 
// Redirect to the listing page 
// header("Location: index.php".$qstring); 
 
 