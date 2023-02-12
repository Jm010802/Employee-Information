<!DOCTYPE html>
<html lang = "en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name = "viewport" content="width=device=width, initial-scale=1.0">
<title>Employee Information</title>
<h1 align="center">EMPLOYEE INFORMATION</h1>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<form name= "Employee" method="POST" name="upload_excel" enctype="multipart/form-data">

<table cellpadding="5" cellspacing="3" align="center">
<tr>
<td>Employee ID:</td>
<td><input type = "text" name="empID" maxlength="4" placeholder="Enter Employee ID:"></td>
</tr>

<tr>
<td>Employee Name:</td>
<td><input type = "text" name="empName" maxlength="20" placeholder="Enter Employee Name:"></td>
</tr>

<tr>
<td>Employee Salary:</td>
<td><input type = "text" name="empSalary" maxlength="100" placeholder="Enter Employee Salary:"></td>
</tr>
</table>

<center>
<input type= "submit" name= "insertSub" value="INSERT">
<input type="submit" name="deleteSub" value="DELETE">
<input type="submit" name="updateSub" value="UPDATE">
<input type="submit" name="viewSub" value="VIEW">
<input type="submit" name="searchSub" value="SEARCH"><br><br>
<input type="file" name="file" id="file" class="form-control" />
<button type="submit" id="submit" name="Import" class="btn btn-primary mt-3">Import</button>

</center>
</form>

<?php
$DBHost = "localhost";
$DBUser = "root";
$DBPass = "Jmnicolas08";
$DBName = "db_employee";

$conn = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

if(!$conn){
die("Connection failed: ".mysql_error());
}

if(isset($_POST['insertSub'])!=''){
    $sql = "INSERT into tbl_employee (`emp_ID`,`emp_Name`,`emp_Salary`) values ('$_POST[empID]','$_POST[empName]','$_POST[empSalary]')";
    $result = mysqli_query($conn,$sql);
    
    echo "<br>Recorded";
}

if(isset($_POST['deleteSub'])!=''){
    if($_POST['empID']==""){
    }else {
        $sql = "DELETE from tbl_employee WHERE `emp_ID`='$_POST[empID]'";
        $result = mysqli_query($conn,$sql);
        
        if($result){
            echo "<br>Record Deleted";
        }else{
            die("Record cannot find in the database".mysqli_error());
        }
    }
}
    
if(isset($_POST['updateSub'])!=''){  
    if($_POST['empID']==""&& $_POST['empSalary']==""){
    }else {
        $sql = "UPDATE tbl_employee SET `emp_Salary`='$_POST[empSalary]' WHERE `emp_ID`='$_POST[empID]'";
        $result = mysqli_query($conn,$sql);
            
        echo"<br>Record Updated";
    }
}
    
if(isset($_POST['viewSub'])!=''){
    echo "<center>";
    $sql = "Select * from tbl_employee";
    $result = mysqli_query($conn,$sql);
    
    if(mysqli_num_rows($result) > 0){
        echo "<table border = 3>" . "<th>Employee ID </th> <th>Employee Name</th> <th>Employee Salary</th>";
        while ($rows = mysqli_fetch_assoc($result)){
            echo "
            <tr>
            <td>".$rows["emp_ID"]."</td>
            <td>".$rows["emp_Name"]."</td>
            <td>".$rows["emp_Salary"]."</td>
            </tr>";
        }
        echo "</table>";
    }
        if($result){
        }
        else{
            die ("Record cannot find in the database".mysqli_error());
        }
    echo"</center>";
}
    
if(isset($_POST['searchSub'])!=''){
    if($_POST['empName']==""){
        echo "Fill Employee Name field you want to search.";
    }else{
        if(preg_match("/[A-Z | a-z]+/", $_POST['empName'])){
            $empname = $_POST['empName'];     
            $sql = "SELECT `emp_ID`, `emp_Name`, `emp_Salary` FROM tbl_employee WHERE `emp_name` LIKE '%". $empname ."%'";
            $result = mysqli_query($conn,$sql);
            
            echo "<table align = center border=1 cellspacing=3 cellpadding=5>";
            echo "<th> Employee ID</th><th>Employee Name</th><th>Employee Salary</th>";
            
            while($row = mysqli_fetch_assoc($result)){
                
                $empid_=$row["emp_ID"];
                $empname_=$row["emp_Name"];
                $empsalary_=$row["emp_Salary"];
                
                echo"
                <tr>
                <td>".$empid_."</td>
                <td>".$empname_."</td>
                <td>".$empsalary_."</td>
                </tr>";
            }
            echo "</table>";
            }
        echo "Record Searched";
    }
}
if (isset ($_POST['Import'])) {
    echo $filename=$_FILES["file"]["tmp_name"];

    if($_FILES["file"]["size"] > 0) {

        $file = fopen($filename, "r");
        while (($empData = fgetcsv($file, 10000, ",")) !== FALSE) {

            $sql = "INSERT into tbl_employee (`emp_ID`,`emp_Name`,`emp_Salary`) VALUES ('$empData[0]','$empData[1]','$empData[2]')";

            $result = mysqli_query($conn,$sql);

            if(! $result)
            {
                echo "<script type=\"text/javascript\">
                alert(\"Invalid File: Please Upload CSV File.\");
                window.location = \"EmployeeInfo.php\"
                </script>";
            }
        }

    fclose($file);
    echo "<script type=\"text/javascript\">
        alert(\"CSV File has been successfull imported.\");
        window.location = \"EmployeeInfo.php\"
        </script>";

        mysql_close($conn);

    }
}
?>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
