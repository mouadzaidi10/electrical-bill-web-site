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
    <style>

      .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        }

        .modal img {
        max-width: 90%;
        max-height: 90%;
        margin: auto;
        display: block;
        }

    </style>

</head>

<body id="page-top">


    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-info p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <img class="img-fluid" src="lib/img/illustrations/icons8-energy.svg" style="width: 60px; height= 60px; padding-top: 8px;">
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link fs-5" href="dashboard_admin.php"><i class="fa-solid fa-house fs-5"></i><span><b>Dashboard</b></span></a></li>
                    <li class="nav-item"><a class="nav-link fs-5" href="gerer_client.php"><i class="fa-solid fa-user fs-5"></i><span><b>Client</b></span></a></li>
                    <li class="nav-item"><a class="nav-link fs-5" href="gerer_reclamation.php"><i class="fa-solid fa-triangle-exclamation fs-5"></i><span><b>Reclamation</b></span></a></li>
                    <li class="nav-item"><a class="nav-link active fs-5" href="gerer_factures.php"><i class="fas fa-table fs-5"></i><span><b>Factures</b></span></a></li>
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
                    <h3 class="text-dark mb-4">Factures</h3>
                    <div class="">
                        
    <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-info d-flex justify-content-between align-items-center">
            <h3 class="text-light">Manage Factures</h3>
          </div>
          <div class="card-body" id="show_all_employees">

            <table id="client_data" class="table table-striped table-sm text-center align-middle">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nom Client</th>
                <th>Prenom Client</th>
                <th>Annee</th>
                <th>Mois</th>
                <th>Consommation De Ce Mois</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $ret=mysqli_query($conn,"
            select * from facture
            INNER JOIN client 
            ON facture.id_client = client.id
            AND client.id_admin = '$id_admin'
            AND facture.statut_de_validation = 'non valide'");
            $cnt=1;
            while($row=mysqli_fetch_array($ret))
            {?>
            <tr>
                <input type="hidden" name="emp_id" id="emp_id" value="<?=$row['id']?>">
                <td><?php echo $cnt;?></td>
                <td><?php echo $row['nom'];?></td>
                <td><?php echo $row['prenom'];?></td>
                <td><?php echo $row['annee'];?></td>
                <td><?php echo $row['mois'];?></td>
                <?php 

                if($row['mois'] == 1){
                  $row['consommation'];
                } else {

                  $mois_pre = $row['mois'] - 1;

                  $sql = "SELECT consommation FROM facture WHERE id_client  = '$row[id_client]'
                  AND mois = $mois_pre";
                  $result = mysqli_query($conn, $sql);
                  $row2 = mysqli_fetch_assoc($result);

                  $consommation_mois_pre = $row2['consommation'];

                  $row['consommation'] -= $consommation_mois_pre;
                }

                ?>
                <td><?php echo $row['consommation'];?></td>
                
                <td>
                  <img src="<?php echo 'lib/images_consommation/' . $row['image'];?>" alt="Image" onclick="showImage(this);" style="width: 50px; height: 50px;">
                </td>

                <td><?php

                    $ret_valid = mysqli_query($conn,"
                    select * from 
                    facture
                    WHERE facture.id_client in (
                        SELECT id FROM client
                        WHERE client.id_admin = '$id_admin'
                    ) AND facture.statut_de_validation = 'non valide'
                    AND facture.mois = " . $row['mois'] . "");
                    $row_valid = mysqli_fetch_array($ret_valid);
                    echo '<form method="post" action="route.php">';
                    echo '<input type="hidden" name="id_facture" value="'.$row_valid['id'].'">';
                    echo '<button type="submit" class="btn btn-info" name="submit-validation-consommation">Validee Cette<br>Facture</button>';
                    echo '</form>';
                ?></td>
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
    $(document).ready(function() {
        $('#client_data').DataTable();
    });
</script>

<script>
    function showImage(img) {
      // Create a modal popup
      var modal = document.createElement('div');
      modal.classList.add('modal');

      // Create an image element to display the full-size image
      var fullImg = document.createElement('img');
      fullImg.src = img.src;

      // Add the image to the modal popup
      modal.appendChild(fullImg);

      // Add the modal popup to the page
      document.body.appendChild(modal);

      // Add a click event listener to the modal popup to close it when clicked
      modal.addEventListener('click', function() {
        modal.parentNode.removeChild(modal);
      });
    }
</script>
</body>
</html>