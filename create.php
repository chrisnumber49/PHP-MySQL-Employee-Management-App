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
                        <div class="card-header bg-primary">
                            <h4>Create New Data</h4>
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

                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="employee">Employee</label>
                                    <input type="text" required class="form-control" name="employee" placeholder="Name of Employee...">
                                </div>

                                <div class="form-group">
                                    <label for="department">Department</label>
                                    <input type="text" required class="form-control" name="department" placeholder="Department...">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" required class="form-control" name="phone" placeholder="Phone...">
                                </div>

                                <div class="form-group">
                                    <label for="avatar">Avatar</label>
                                    <input type="file" required accept="image/*" class="form-control" name="avatar">
                                </div>

                                <div class="form-group">
                                    <button type="submit" name="create" class="btn btn-primary">Create</button>
                                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
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