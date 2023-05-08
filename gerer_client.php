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


    <!-- add new employee modal start -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="route.php" method="POST" id="add_employee_form" enctype="multipart/form-data">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="nom">Nom</label>
              <input type="text" name="nom" class="form-control" placeholder="Nom" required>
            </div>
            <div class="col-lg">
              <label for="prenom">Prenom</label>
              <input type="text" name="prenom" class="form-control" placeholder="Prenom" required>
            </div>
          </div>
          <div class="my-2">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="my-2">
            <label for="adresse">Adresse</label>
            <input type="text" name="adresse" class="form-control" placeholder="Adresse" required>
          </div>
          <div class="my-2">
            <label for="nom_zone_geographique">Nom Zone Geographique : </label>
            <!-- <br> -->

                  <!-- <input type="text" name="nom_zone_geographique" class="form-control" placeholder="Nom Zone Geographique" required> -->
                  <select id="nom_zone_geographique" name="nom_zone_geographique">
                        <?php
                    // Query the database for the distinct values of nom_zone_geographique
                    $sql = "SELECT DISTINCT nom_zone_geographique_geree FROM agent";
                    $result = mysqli_query($conn, $sql);

                    // Iterate through the results and create an option for each distinct value
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<option value=\"" . $row["nom_zone_geographique_geree"] . "\">" . $row["nom_zone_geographique_geree"] . "</option>";
                    }

                  ?>
                  </select><br>
          
          </div>
          <div class="my-2">
            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone" class="form-control" placeholder="Téléphone" required>
          </div>
          <div class="my-2">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="submit-add-client" id="add_employee_btn" class="btn btn-info">Add Client</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- add new employee modal end -->









<!-- edit employee modal start -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Client</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="route.php" method="POST" id="edit_employee_form" enctype="multipart/form-data">
      <div class="modal-body p-4 bg-light">
        <input type="hidden" name="emp_id" id="client_id">
        <div class="row">
          <div class="col-lg">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="client_nom" class="form-control" placeholder="Nom" required>
          </div>
          <div class="col-lg">
            <label for="prenom">Prenom</label>
            <input type="text" name="prenom" id="client_prenom" class="form-control" placeholder="Prenom" required>
          </div>
        </div>
        <div class="my-2">
          <label for="email">Email</label>
          <input type="email" name="email" id="client_email" class="form-control" placeholder="Email" required>
        </div>
        <div class="my-2">
          <label for="adresse">Adresse</label>
          <input type="tel" name="adresse" id="client_adresse" class="form-control" placeholder="Adresse" required>
        </div>
        <div class="my-2">
            <label for="nom_zone_geographique">Nom Zone Geographique : </label>
            <!-- <input type="text" name="nom_zone_geographique" id="nom_zone_geographique" class="form-control" placeholder="Nom Zone Geographique" required> -->
            <select id="nom_zone_geographique" name="nom_zone_geographique">
                        <?php
                    // Query the database for the distinct values of nom_zone_geographique
                    $sql = "SELECT DISTINCT nom_zone_geographique_geree FROM agent";
                    $result = mysqli_query($conn, $sql);

                    // Iterate through the results and create an option for each distinct value
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<option value=\"" . $row["nom_zone_geographique_geree"] . "\">" . $row["nom_zone_geographique_geree"] . "</option>";
                    }

                  ?>
            </select><br>
        
        
          </div>
        <div class="my-2">
          <label for="telephone">Téléphone</label>
          <input type="text" name="telephone" id="client_telephone" class="form-control" placeholder="Téléphone" required>
        </div>
        <div class="my-2">
          <label for="password">Password</label>
          <input type="text" name="password" id="client_password" class="form-control" placeholder="Modifie The Password">
        </div>
        <div class="mt-2" id="avatar">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="edit_employee_btn" name="submit-update-client" class="btn btn-success">Update Client</button>
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
                    <li class="nav-item"><a class="nav-link active fs-5" href="gerer_client.php"><i class="fa-solid fa-user fs-5"></i><span><b>Client</b></span></a></li>
                    <li class="nav-item"><a class="nav-link fs-5" href="gerer_reclamation.php"><i class="fa-solid fa-triangle-exclamation fs-5"></i><span><b>Reclamation</b></span></a></li>
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
                    <h3 class="text-dark mb-4">Client</h3>
                    <div class="">
                        
    
    <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-info d-flex justify-content-between align-items-center">
            <h3 class="text-light">Manage Client</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
                class="bi-plus-circle me-2"></i>Add New Client</button>
          </div>
          <div class="card-body" id="show_all_employees">

            <table id="client_data" class="table table-striped table-sm text-center align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>E-mail</th>
                <th>Adresse</th>
                <th>Telephone</th>
                <!-- <th>Password</th> -->
                <th>Mdifier</th>
            </tr>
        </thead>
        <tbody>
            <?php $ret=mysqli_query($conn,"select * from client where id_admin = ".$id_admin."");
            $cnt=1;
            while($row=mysqli_fetch_array($ret))
            {?>
            <tr>
                <input type="hidden" name="emp_id" id="emp_id" value="<?=$row['id']?>">
                <td><?php echo $cnt;?></td>
                <td><?php echo $row['nom'];?></td>
                <td><?php echo $row['prenom'];?></td>
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['adress'];?></td>
                <td><?php echo $row['telephone'];?></td>
                <!-- <td><?php echo $row['password'];?></td> -->
                <?php
                 $sql = "SELECT * FROM client WHERE id=". $row['id'] . "";
                $result = mysqli_query($conn, $sql);
                ?>

                <input type="hidden" name="emp_nom" id="emp_nom" value="<?=$row['nom']?>">
                <td>
                    <a data-toggle="modal" 
                    
                    data-id="<?php echo $row['id'] ?>" 
                    data-nom="<?php echo $row['nom'] ?>"
                    data-prenom="<?php echo $row['prenom'] ?>"
                    data-email="<?php echo $row['email'] ?>"
                    data-adress="<?php echo $row['adress'] ?>"
                    data-zone="<?php echo $row['nom_zone_geographique'] ?>"
                    data-telephone="<?php echo $row['telephone'] ?>"
                    data-password="<?php echo $row['password'] ?>"

                    title="Add this item"
                    class="open-AddBookDialog btn btn-info" href="#addBookDialog"
                    data-bs-toggle="modal" 
                    data-bs-target="#editEmployeeModal">Mdifier Client</a>
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
                var clientNom = $(this).data('nom');
                var clientPrenom = $(this).data('prenom');
                var clientEmail = $(this).data('email');
                var clientAdress = $(this).data('adress');
                var clientZoneGeographique = $(this).data('zone');
                var clientTelephone = $(this).data('telephone');

                $(".modal-body #client_id").val( clientId );
                $(".modal-body #client_nom").val( clientNom );
                $(".modal-body #client_prenom").val( clientPrenom );
                $(".modal-body #client_email").val( clientEmail );
                $(".modal-body #client_adresse").val( clientAdress );
                $(".modal-body #nom_zone_geographique").val( clientZoneGeographique );
                $(".modal-body #client_telephone").val( clientTelephone );

            });
        });

    </script>
</body>
</html>