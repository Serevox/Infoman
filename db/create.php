<?php
//Noie Glenn Manoy - WD 201

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$custnum = $custname = $street = $city = $state = $zip = $repnum = "";
$custnum_err = $custname_err = $street_err = $city_err = $state_err = $zip_err = $repnum_err = "";
 

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate customer number
    $input_custnum = trim($_POST["custnum"]);
    if(empty($input_custnum)){
        $input_custnum_err = "Please enter customer name.";
    } else{
        $custnum = $input_custnum;

    // Validate name
    $input_custname = trim($_POST["custname"]);
    if(empty($input_custname)){
        $input_custname_err = "Please enter customer name.";
    } else{
        $custname = $input_custname;
    }
    
    // Validate street
    $input_street = trim($_POST["street"]);
    if(empty($input_street)){
        $street_err = "Please enter street.";
    } elseif(!filter_var($input_street, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-999a-zA-Z\s]+$/")))){
        $input_street_err = "Please enter a valid Street.";     
    } else{
        $street = $input_street;
    }

    // Validate city
    $input_city = trim($_POST["city"]);
    if(empty($input_city)){
        $city_err = "Please enter city.";
    } elseif(!filter_var($input_city, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $input_city_err = "Please enter a valid city.";     
    } else{
        $city = $input_city;
    }

    // Validate state
    $input_state = trim($_POST["state"]);
    if(empty($input_state)){
        $state_err = "Please enter state.";
    } elseif(!filter_var($input_state, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $input_state_err = "Please enter a valid state.";     
    } else{
        $state = $input_state;
    }

    // Validate zip
    $input_zip = trim($_POST["zip"]);
    if(empty($input_zip)){
        $zip_err = "Please enter zip code.";
    } elseif(!filter_var($input_zip, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-999]+$/")))){
        $input_zip_err = "Please enter a valid zip.";     
    } else{
        $zip = $input_zip;
    }
    
    // Validate salary
    $input_repnum = trim($_POST["repnum"]);
     if(empty($input_repnum)){
        $repnum_err = "Please enter representative number.";     
    } else{
        $repnum = $input_repnum;
    }
}
    
    // Check input errors before inserting in database
    if(empty($custnum_err) && empty($custname_err) && empty($street_err) && empty($city_err) && empty($state_err) && empty($zip_err) && empty($repnum_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO customer (CUSTOMER_NUM, CUSTOMER_NAME, STREET, CITY, STATE, ZIP, REP_NUM) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_custnum, $param_custname, $param_street, $param_city, $param_state, $param_zip, $param_repnum);
            
            // Set parameters
            $param_custnum = $custnum;
            $param_custname = $custname;
            $param_street = $street;
            $param_city = $city;
            $param_state = $state;
            $param_zip = $zip;
            $param_repnum = $repnum;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add representative record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Customer Number</label>
                        <input type="text" name="custnum" class="form-control <?php echo (!empty($custnum_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $custnum; ?>">
                        <span class="invalid-feedback"><?php echo $custnum_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" name="custname" class="form-control <?php echo (!empty($custname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $custname; ?>">
                        <span class="invalid-feedback"><?php echo $custname_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Street</label>
                        <textarea name="street" class="form-control <?php echo (!empty($street_err)) ? 'is-invalid' : ''; ?>"><?php echo $street; ?></textarea>
                        <span class="invalid-feedback"><?php echo $street_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <textarea name="city" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>"><?php echo $city; ?></textarea>
                        <span class="invalid-feedback"><?php echo $city_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <textarea name="state" class="form-control <?php echo (!empty($state_err)) ? 'is-invalid' : ''; ?>"><?php echo $state; ?></textarea>
                        <span class="invalid-feedback"><?php echo $state_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>ZIP</label>
                        <input type="text" name="zip" class="form-control <?php echo (!empty($zip_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $zip; ?>">
                        <span class="invalid-feedback"><?php echo $zip_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Representative Number</label>
                        <input type="text" name="repnum" class="form-control <?php echo (!empty($repnum_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $repnum; ?>">
                        <span class="invalid-feedback"><?php echo $repnum_err;?></span>
                    </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>