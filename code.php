<?php
    session_start();

    //Get Heroku ClearDB connection information
    $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $cleardb_server = $cleardb_url["host"];
    $cleardb_username = $cleardb_url["user"];
    $cleardb_password = $cleardb_url["pass"];
    $cleardb_db = substr($cleardb_url["path"],1);
    $active_group = 'default';
    $query_builder = TRUE;
    // Connect to DB
    $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
    // $conn = mysqli_connect("localhost", "root", "", "crud");

    // if press create button and method is POST
    if(isset($_POST['create'])){

        // get the form data in each input field
        $employee = $_POST['employee'];
        $department = $_POST['department'];
        $phone = $_POST['phone'];
        $avatar = $_FILES['avatar']['name'];

        $allowed_extension = array('gif', 'png', 'jpg', 'jpeg');
        // to get the extension of the file 
        $file_extension = pathinfo($avatar, PATHINFO_EXTENSION);
        // if the file extension is not those 4 above
        if(!in_array($file_extension, $allowed_extension)){
            $_SESSION['status'] = "Only Image Is Allowed!";
            // redirect to create.php
            header("Location: create.php");
        }else{
            // if avatar is existed 
            if(file_exists("upload/".$avatar)){
                $_SESSION['status'] = "Opps Someone Else has Used This Avatar! ".$avatar;
                header("Location: create.php");
            }else{
                // insert new data in to company table
                $query = "INSERT INTO company 
                    (employee, department, phone, avatar) 
                    VALUES ('$employee', '$department', '$phone', '$avatar')";

                // query the database if successed of not
                $query_run = mysqli_query($conn, $query);
                if($query_run){
                    // save file into the path
                    move_uploaded_file($_FILES['avatar']['tmp_name'], "upload/".$_FILES['avatar']['name']);
                    $_SESSION['status'] = "Create successfully";
                    header("Location: index.php");
                }else{
                    $_SESSION['status'] = "Failed to Create";
                    header("Location: create.php");
                }
            }
        }
    }


    // if press update button and method is POST
    if(isset($_POST['update'])){
        // get the form data in each input field
        $id = $_POST['id'];
        $employee = $_POST['employee'];
        $department = $_POST['department'];
        $phone = $_POST['phone'];
        // use new avatar if there is one otherwise use old avatar
        $new_avatar = $_FILES['avatar']['name'];
        $old_avatar = $_POST['old_avatar'];
        if($new_avatar != ''){
            $avatar = $new_avatar;
        }else{
            $avatar = $old_avatar;
        }

        // if there is a new avatar and same avatar is existed in folder
        if($new_avatar != '' && file_exists("upload/".$avatar)){
            $_SESSION['status'] = "Avatar Already Exists! ".$avatar;
            // redirect to update.php with the target id 
            header("Location: update.php?id=$id");
        }else{
            // update data to target id
            $query = "UPDATE company 
                    SET employee='$employee', department='$department', phone='$phone', avatar='$avatar'
                    WHERE id='$id' ";

            $query_run = mysqli_query($conn, $query);
            if($query_run){
                // save new avatar into folder and remove old one if there is new one
                if($new_avatar != ''){
                    move_uploaded_file($_FILES['avatar']['tmp_name'], "upload/".$_FILES['avatar']['name']);
                    unlink("upload/".$old_avatar);
                }
                $_SESSION['status'] = "Update successfully";
                header("Location: index.php");
            }else{
                $_SESSION['status'] = "Failed to Update";
                header("Location: update.php?id=$id");
            }
        }
    }


    // if press delete button and method is POST
    if(isset($_POST['delete'])){
        $id = $_POST['id'];
        $avatar = $_POST['avatar'];

        $query = "DELETE FROM company WHERE id='$id' ";
        $query_run = mysqli_query($conn, $query);
        if($query_run){
            // remove avatar from folder
            unlink("upload/".$avatar);
            $_SESSION['status'] = "Delete successfully";
            header("Location: index.php");
        }else{
            $_SESSION['status'] = "Failed to Delete";
            header("Location: index.php");
        }
    }
?>