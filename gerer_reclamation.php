<?php

session_start();
error_reporting(0);
include 'config.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
  // Redirect the user to the login page
  header('Location: login.php');
  exit();
}


$id_admin = $_SESSION['id'];
$user_type = $_SESSION['user_type'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>TP2 Web</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="lib/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="lib/css/untitled-1.css">
    <link rel="stylesheet" href="lib/css/untitled.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.2/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

</head>

<body id="page-top">


<!-- edit employee modal start -->
<div class="modal fade" id="repondreModal" tabindex="-1" aria-labelledby="exampleModalLabel"
data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Reponse</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="route.php" method="POST" id="edit_employee_form" enctype="multipart/form-data">
      <div class="modal-body p-4 bg-light">
        <input type="hidden" name="client_id" id="client_id">
        <input type="hidden" name="reclamation_id" id="reclamation_id">
        
        <div class="">
            <label for="reponse">Reponse:</label>
            <br>
            <br>
            <textarea id="reponse" name="reponse" rows="8" cols="50"></textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="edit_employee_btn" name="submit-send-reponse" class="btn btn-success">Send Reponse</button>
      </div>
    </form>
  </div>
</div>
</div>
<!-- edit employee modal end -->




    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-info p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <img class="img-fluid" src="lib/img/illustrations/icons8-energy.svg" style="width: 60px; height= 60px; padding-top: 8px;">
                
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link fs-5" href="dashboard_admin.php"><i class="fa-solid fa-house fs-5"></i><span><b>Dashboard</b></span></a></li>
                    <li class="nav-item"><a class="nav-link fs-5" href="gerer_client.php"><i class="fa-solid fa-user fs-5"></i><span><b>Client</b></span></a></li>
                    <li class="nav-item"><a class="nav-link active fs-5" href="gerer_reclamation.php"><i class="fa-solid fa-triangle-exclamation fs-5"></i><span><b>Reclamation</b></span></a></li>
                    <li class="nav-item"><a class="nav-link fs-5" href="gerer_factures.php"><i class="fas fa-table fs-5"></i><span><b>Factures</b></span></a></li>
                    <li class="nav-item"><a class="nav-link fs-5" href="logout.php"><i class="fa-solid fa-right-from-bracket fs-5"></i><span><b>Logout</b></span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small">ADMIN</span></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Reclamation</h3>
                    <div class="">
                        

    <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-info d-flex justify-content-between align-items-center">
            <h3 class="text-light">Les Reclamation</h3>
          </div>
          <div class="card-body" id="show_all_employees">

            <table id="client_data" class="table table-striped table-sm text-center align-middle">
        <thead>
            <tr>
                <th>N°</th>
                <th>id_client </th>
                <th>message</th>
                <th>date</th>
                <th>statut</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $ret=mysqli_query($conn,"select * from reclamation 
            where statut = 'non repondee'
            AND id_admin = '$id_admin'");
            $cnt=1;
            while($row=mysqli_fetch_array($ret))
            {?>
            <tr>
                <td><?php echo $cnt;?></td>
                <td><?php echo $row['id_client'];?></td>
                <td><?php echo $row['message'];?></td>
                <td><?php echo $row['date'];?></td>
                <td><?php echo $row['statut'];?></td>
                <?php
                    if($row['Type'] == 'Autre'){
                        ?><td><?php echo $row['Autre_type'];?></td><?php
                    } else {
                        ?><td><?php echo $row['Type'];?></td><?php
                    }
                ?>
                

                <input type="hidden" name="emp_nom" id="emp_nom" value="<?=$row['nom']?>">
                <td>
                    <a data-toggle="modal" 
                    
                    data-id="<?php echo $row['id_client'] ?>"
                    data-reclamation="<?php echo $row['id'] ?>"

                    title="Add this item"
                    class="open-AddBookDialog btn btn-info" href="#addBookDialog"
                    data-bs-toggle="modal" 
                    data-bs-target="#repondreModal">Repondre</a>
                </td>
            </tr>
            <?php $cnt=$cnt+1; }?>
            
        </tbody>
    </table>
    
          </div>
        </div>
      </div>
    </div>
  </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>

    <script src="lib/jquery/jquery-3.6.3.min.js"></script>

    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="lib/js/bs-init.js"></script>
    <script src="lib/js/theme.js"></script>
    <script src="lib/js/startup-modern.js"></script>

    <script src="lib/DataTables/datatables.min.js"></script>
    <script src="lib/sweetalert2/sweetalert2.all.min.js"></script>


    <?php
        if(isset($_SESSION['status']) && $_SESSION['status'] != ''){
            ?>

            <script>
                Swal.fire({
                    title: '<?php echo $_SESSION['status'] ?>',
                    // text: 'good',
                    icon: '<?php echo $_SESSION['status_code'] ?>'
                })
            </script>
            <?php
            unset($_SESSION['status']);
        }
    ?>
    <script>
        $(document).ready(function(){
            $('#client_data').DataTable();
            $(document).on("click", ".open-AddBookDialog", function () {
                var clientId = $(this).data('id');
                var reclamationId = $(this).data('reclamation');

                $(".modal-body #client_id").val( clientId );
                $(".modal-body #reclamation_id").val( reclamationId );
            });
        });
    </script>
</body>
</html>