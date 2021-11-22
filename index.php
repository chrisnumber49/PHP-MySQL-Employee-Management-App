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
                        <div class="card-header d-flex justify-content-between">
                            <h4>Employee Informations</h4>
                            <a href="create.php" class="btn btn-primary">Add New Employee</a>
                        </div>

                        <div class="card-body">
                            <?php
                                // //Get Heroku ClearDB connection information
                                // $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
                                // $cleardb_server = $cleardb_url["host"];
                                // $cleardb_username = $cleardb_url["user"];
                                // $cleardb_password = $cleardb_url["pass"];
                                // $cleardb_db = substr($cleardb_url["path"],1);
                                // $active_group = 'default';
                                // $query_builder = TRUE;
                                // // Connect to DB
                                // $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
                                $conn = mysqli_connect("localhost", "root", "", "crud");

                                if(isset($_POST['search'])){
                                    $employee = $_POST['employee'];

                                    $query = "SELECT * FROM company WHERE employee LIKE '%$employee%'";
                                    $query_run = mysqli_query($conn, $query);
                                }else{
                                    $query = "SELECT * FROM company";
                                    $query_run = mysqli_query($conn, $query);
                                }
                            ?>

                            <?php
                                if(isset($_SESSION['status']) && $_SESSION != ''){
                                ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong> <?php echo$_SESSION['status']; ?> </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                    
                                <?php
                                    unset($_SESSION['status']);
                                }
                            ?>

                            <form action="" method="POST">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="employee" placeholder="Search Employee...">
                                    <div class="input-group-append">
                                        <button type="submit" name="search" class="btn btn-info">Search</button>
                                    </div>
                                </div>
                            </form>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Employee</th>
                                        <th>Department</th>
                                        <th>Phone</th>
                                        <th>Avatar</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php 
                                        if(mysqli_num_rows($query_run)>0){
                                            foreach($query_run as $row){
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['employee']; ?></td>
                                                    <td><?php echo $row['department']; ?></td>
                                                    <td><?php echo $row['phone']; ?></td>
                                                    <td>
                                                        <img 
                                                            src="<?php echo "upload/".$row['avatar']; ?>" 
                                                            style="max-height:150px;max-width:100px;" 
                                                            alt="<?php echo $row['avatar']; ?>"
                                                        >
                                                    </td>
                                                    <td>
                                                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                                                    </td>
                                                    <td>
                                                        <form action="code.php" method="POST">
                                                            <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                                                            <input type="hidden" name="avatar" value="<?php echo $row['avatar'];?>">
                                                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <tr>
                                                <td>No Record Available!</td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
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