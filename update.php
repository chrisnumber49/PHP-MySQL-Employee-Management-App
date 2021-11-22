<?php 
    session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <title>PHP MySQL Employee Management App</title>
    </head>
    <body>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-warning">
                            <h4>Update Data</h4>
                        </div>

                        <div class="card-body">
                            <?php
                                if(isset($_SESSION['status']) && $_SESSION != ''){
                                ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong> <?php echo$_SESSION['status']; ?> </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                    
                                <?php
                                    unset($_SESSION['status']);
                                }
                            ?>

                            <?php
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

                                $id = $_GET['id'];
                                $query = "SELECT * FROM company WHERE id='$id'";
                                $query_run = mysqli_query($conn, $query);

                                if(mysqli_num_rows($query_run)>0){
                                    foreach($query_run as $row){
                                        ?>
                                        <form action="code.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?php echo $row['id'];?>">

                                            <div class="form-group">
                                                <label for="employee">Employee</label>
                                                <input type="text" required class="form-control" name="employee" value="<?php echo $row['employee']; ?>" placeholder="Name of Employee...">
                                            </div>

                                            <div class="form-group">
                                                <label for="department">Department</label>
                                                <input type="text" required class="form-control" name="department" value="<?php echo $row['department']; ?>" placeholder="Department...">
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" required class="form-control" name="phone" value="<?php echo $row['phone']; ?>" placeholder="Phone...">
                                            </div>

                                            <div class="form-group">
                                                <label for="avatar">Avatar</label>
                                                <input type="file" accept="image/*" class="form-control" name="avatar">
                                                <input type="hidden" name="old_avatar" value="<?php echo $row['avatar']; ?>">
                                            </div>

                                            <img 
                                                src="<?php echo "upload/".$row['avatar']; ?>" 
                                                style="width:100px;" 
                                                alt="<?php echo $row['avatar']; ?>"
                                                class="mb-3"
                                            >

                                            <div class="form-group">
                                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                <a href="index.php" class="btn btn-secondary">Cancel</a>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                }else{
                                    echo "Nothing is Found!";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>

    </body>
</html>