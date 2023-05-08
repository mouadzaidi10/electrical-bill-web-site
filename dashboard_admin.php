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
    <title>TP2 Web - Dashboard Admin</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.2/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-info p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <img class="img-fluid" src="lib/img/illustrations/icons8-energy.svg" style="width: 60px; height= 60px; padding-top: 8px;">
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link active fs-5" href="dashboard_admin.php"><i class="fa-solid fa-house fs-5"></i><span><b>Dashboard</b></span></a></li>
                    <li class="nav-item"><a class="nav-link fs-5" href="gerer_client.php"><i class="fa-solid fa-user fs-5"></i><span><b>Client</b></span></a></li>
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
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Dashboard</h3>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Nombres Des Client</span></div>
                                            <br>
                                            <?php 

                                            $annee = date('Y');

                                            $consommation_non_payee = 9;

                                            $sql = "SELECT COUNT(*) AS total_client
                                            FROM client 
                                            WHERE id_admin = $id_admin";

                                            $result = mysqli_query($conn, $sql);

                                            $total_client = mysqli_fetch_assoc($result)['total_client'];
                                            
                                            if($total_client == null){
                                              $total_client = 0;
                                            } else {
                                              $total_client;
                                            }
                                    
                                    
                                            
                                            ?>

                                            <div class="text-dark fw-bold h5 mb-0"><span><?php echo $total_client ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fa-solid fa-user fs-1"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Montant Des Factures Non Payees</span></div>
                                            
                                            <?php 

                                            $annee = date('Y');


                                            $sql = "SELECT SUM(f.TTC) AS total_consommation
                                            FROM client c
                                            INNER JOIN facture f 
                                            ON c.id = f.id_client
                                            AND c.id_admin = $id_admin
                                            AND f.annee = $annee
                                            AND f.statut_de_payment = 'non payee'";

                                            $result = mysqli_query($conn, $sql);

                                            $consommation_non_payee = mysqli_fetch_assoc($result)['total_consommation'];
                                            
                                            if($consommation_non_payee == null){
                                              $consommation_non_payee = 0;
                                            } else {
                                              $consommation_non_payee;
                                            }
                                    
                                    
                                            
                                            ?>
                                            
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php echo $consommation_non_payee ?></span> DH</div>
                                        </div>
                                        <div class="col-auto"><i class="fa-solid fa-dollar-sign fs-1"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- added par mois -->
                <section class="py-4 py-md-5 my-5">
        

    <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-info d-flex justify-content-between align-items-center">
            <h3 class="text-light">La Consommation Par Mois</h3>
          </div>
          <div class="card-body" id="show_all_employees">
          
                <?php 

                $annee = date('Y');

                $sql = "
                SELECT mois as monthname,
                SUM(consommation) as amount
                FROM facture
                WHERE id_client in (
                  SELECT id from client
                  WHERE id_admin = $id_admin
                )
                AND facture.annee = $annee
                GROUP BY mois
                ";

                $fire = mysqli_query($conn, $sql);


                while($result = mysqli_fetch_assoc($fire)){
                $month[] = $result['monthname'];
                $amount[] = $result['amount'];
                }


                ?>


                <div style="width: 900px;">
                <canvas id="myChart"></canvas>
                </div>

          </div>
        </div>
      </div>
    </div>
  </div>
    


    </section>


<!-- added par zone geog -->
<section class="py-4 py-md-5 my-5">
        

        <div class="container">
        <div class="row my-5">
          <div class="col-lg-12">
            <div class="card shadow">
              <div class="card-header bg-info d-flex justify-content-between align-items-center">
                <h3 class="text-light">La Consommation Par Zone Geographique</h3>
              </div>
              <div class="card-body" id="show_all_employees">
              <?php 

                $annee = date('Y');

                $sql = "SELECT c.nom_zone_geographique, SUM(f.consommation) AS total_consommation
                FROM client c
                INNER JOIN facture f ON c.id = f.id_client
                AND c.id_admin = $id_admin
                AND f.annee = $annee
                GROUP BY c.nom_zone_geographique";

                $fire = mysqli_query($conn, $sql);


                while($result = mysqli_fetch_assoc($fire)){
                $nom_zone_geographique[] = $result['nom_zone_geographique'];
                $total_consommation[] = $result['total_consommation'];
                }


                ?>


                <div style="width: 900px;">
                    <canvas id="myChart_zone_geo"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

        </section>
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
    <script src="lib/js/startup-modern.js"></script>
    <script src="lib/chartjs/chart.js"></script>
    <script src="lib/js/bs-init.js"></script>
    <script src="lib/js/theme.js"></script>
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
        });
    </script>




<script>
  // === include 'setup' then 'config' above ===
  const labels = <?php echo json_encode($month) ?>;
  const data = {
    labels: labels,
    datasets: [{
    //   label: 'My First Dataset',
      data: <?php echo json_encode($amount) ?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)'
      ],
      borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)'
      ],
      borderWidth: 1
    }]
  };

  const config = {
    type: 'bar',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };

  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>







<script>
  // === include 'setup' then 'config' above ===
  const labels2 = <?php echo json_encode($nom_zone_geographique) ?>;
  const data2 = {
    labels: labels2,
    datasets: [{
    //   label: 'My First Dataset',
      data: <?php echo json_encode($total_consommation) ?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)'
      ],
      borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)'
      ],
      borderWidth: 1
    }]
  };

  const config2 = {
    type: 'bar',
    data: data2,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };

  var myChart = new Chart(
    document.getElementById('myChart_zone_geo'),
    config2
  );
</script>

</body>

</html>