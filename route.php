<?php

session_start();
error_reporting(0);
include 'config.php';

//include library
include('lib/TCPDF-main/tcpdf.php');

if (!isset($_SESSION['id']) && isset($_POST['submit_login'])) {
  
	$email = $_POST['email'];
  $password = md5($_POST['password']);

    // Check if the user is a client
$client_query = "SELECT * FROM client WHERE email='$email' AND password='$password'";
$client_result = mysqli_query($conn, $client_query);

if (mysqli_num_rows($client_result) == 1) {
    // The user is a client
    $user = mysqli_fetch_assoc($client_result);
    
  // Set session variables
    session_start();

    $_SESSION['id'] = $user['id'];
    $_SESSION['nom'] = $user['nom'];
    $_SESSION['prenom'] = $user['prenom'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['adress'] = $user['adress'];
    $_SESSION['telephone'] = $user['telephone'];
    $_SESSION['password'] = $user['password'];
    $_SESSION['nom_zone_geographique'] = $user['nom_zone_geographique'];

    $_SESSION['user_type'] = 'client';


    $_SESSION['status'] = "Welcome Client!";
    $_SESSION['status_code'] = "success";

  
  // Redirect the user to the client dashboard
  header('Location: dashboard_client.php');

  exit();
}


// Check if the user is an agent
$agent_query = "SELECT * FROM agent WHERE email='$email' AND password='$password'";
$agent_result = mysqli_query($conn, $agent_query);

if (mysqli_num_rows($agent_result) == 1) {
  // The user is an agent
  $user = mysqli_fetch_assoc($agent_result);
  
  // Set session variables
  session_start();
    $_SESSION['id'] = $user['id'];
    $_SESSION['nom'] = $user['nom'];
    $_SESSION['prenom'] = $user['prenom'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['adress'] = $user['adress'];
    $_SESSION['telephone'] = $user['telephone'];
    $_SESSION['nom_zone_geographique'] = $user['nom_zone_geographique'];
    $_SESSION['password'] = $user['password'];

    $_SESSION['user_type'] = 'agent';

    $_SESSION['status'] = "Welcome Agent!";
    $_SESSION['status_code'] = "success";
    
  // Redirect the user to the agent dashboard
  header('Location: dashboard_agent.php');
  exit();
}

// Check if the user is an admin
$admin_query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
$admin_result = mysqli_query($conn, $admin_query);

if (mysqli_num_rows($admin_result) == 1) {
  // The user is an admin
  $user = mysqli_fetch_assoc($admin_result);
  
  // Set session variables
    session_start();
    $_SESSION['id'] = $user['id'];
    $_SESSION['nom'] = $user['nom'];
    $_SESSION['adress'] = $user['adress'];
    $_SESSION['telephone'] = $user['telephone'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['password'] = $user['password'];

    $_SESSION['user_type'] = 'admin';
    
  // Redirect the user to the admin dashboard


  $_SESSION['status'] = "Welcome Admin!";
    $_SESSION['status_code'] = "success";


  header('Location: dashboard_admin.php');
  exit();
}

// // The user doesn't exist or the password is incorrect
// echo 'Invalid email or password';



    $_SESSION['status'] = "Invalid email or password";
    $_SESSION['status_code'] = "error";


    header('Location: login.php');
    exit();



    
} else if (isset($_SESSION['id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {

    
    $id_admin = $_SESSION['id'];
    $user_type = $_SESSION['user_type'];


    //Ajouter un nouveaux client
    if (isset($_POST['submit-add-client'])) {

      $nom = $_POST['nom'];
      $prenom = $_POST['prenom'];
      $email = $_POST['email'];
      $adresse = $_POST['adresse'];
      $nom_zone_geographique = $_POST['nom_zone_geographique'];
      $telephone = $_POST['telephone'];
      $password = md5($_POST['password']);
    
        $sql = "SELECT * FROM client WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) { 
    
    
          $sql = "SELECT id FROM agent WHERE nom_zone_geographique_geree = '$nom_zone_geographique'";
        $result = mysqli_query($conn, $sql);
    
        $id_agent = mysqli_fetch_assoc($result)['id'];
    
    
            $sql = "INSERT INTO client (nom, prenom, email, adress, nom_zone_geographique, telephone, password, id_admin, id_agent)
                    VALUES ('$nom', '$prenom', '$email', '$adresse', '$nom_zone_geographique', '$telephone', '$password', '$id_admin', '$id_agent')";
            $result = mysqli_query($conn, $sql);
    
            if ($result) {
    
                $_SESSION['status'] = "Client Added Successfully !";
                $_SESSION['status_code'] = "success";
                header("Location: gerer_client.php");
    
            } else {
    
                $_SESSION['status'] = "Woops! Something Wrong Went.";
                $_SESSION['status_code'] = "error";
                header("Location: gerer_client.php");
    
            }
            
        } else {
    
            $_SESSION['status'] = "Email Already Exists. Please Try Another one.";
            $_SESSION['status_code'] = "error";
            header("Location: gerer_client.php");
    
        }
    }

    //Modifiee les information d'un client
if (isset($_POST['submit-update-client'])) {

  $id = $_POST['emp_id'];
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $email = $_POST['email'];
  $adresse = $_POST['adresse'];
  $nom_zone_geographique = $_POST['nom_zone_geographique'];
  $telephone = $_POST['telephone'];
  
  if(empty($_POST['password'])){
    $sql = "SELECT password FROM client WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $password = mysqli_fetch_assoc($result)['password'];
  } else {
    $password = md5($_POST['password']);
  }


  $sql = "SELECT id FROM agent WHERE nom_zone_geographique_geree = '$nom_zone_geographique'";
  $result = mysqli_query($conn, $sql);

  $id_agent = mysqli_fetch_assoc($result)['id'];
    
  $sql = "UPDATE client SET nom = '$nom',
    prenom = '$prenom', email = '$email', 
    adress = '$adresse', telephone = '$telephone', 
    nom_zone_geographique = '$nom_zone_geographique',
    id_agent = '$id_agent',
    password = '$password' WHERE id = '$id'";


if ($conn->query($sql) === TRUE) {

  $_SESSION['status'] = "Client Updated Successfully !";
  $_SESSION['status_code'] = "success";
  header("Location: gerer_client.php");

} else {
  $_SESSION['status'] = "Woops! Something Wrong Went.";
  $_SESSION['status_code'] = "error";
  header("Location: gerer_client.php");
}

}

    
    //envoie de reponse
    if (isset($_POST['submit-send-reponse'])) {
      
      $reponse = $_POST['reponse'];
      $id_client = $_POST['client_id'];
      $id_reclamation = $_POST['reclamation_id'];
      
        $sql = "UPDATE reclamation SET reponse = '$reponse', statut = 'repondee' WHERE id = '$id_reclamation'";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            $_SESSION['status'] = "Votre Reponse a été envoyé avec succès";
            $_SESSION['status_code'] = "success";
            header("Location: gerer_reclamation.php");

        } else {

            $_SESSION['status'] = "Woops! Something Wrong Went.";
            $_SESSION['status_code'] = "error";
            header("Location: gerer_reclamation.php");

        }

    }


    //Validation des consommation < 50 and > 400
  if (isset($_POST['submit-validation-consommation'])) {

    $id_facture = $_POST['id_facture'];



    $sql = "UPDATE facture SET statut_de_validation = 'valide'
    WHERE id = '$id_facture'";
  
  if ($conn->query($sql) === TRUE) {

    $_SESSION['status'] = "Cette Facture a ete bien validee";
    $_SESSION['status_code'] = "success";
    header("Location: gerer_factures.php");

  } else {
    $_SESSION['status'] = "Woops! Something Wrong Went.";
    $_SESSION['status_code'] = "error";
    header("Location: gerer_factures.php");
  }


  }



} else if (isset($_SESSION['id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'client') {


  //envoiee une reclamation a l'admin
  if (isset($_POST['submit-add-reclamation'])) {


    $id_client = $_SESSION['id'];

    $sql = "SELECT id_admin from client WHERE id = '$id_client'";
      $result = mysqli_query($conn, $sql);

    $user = mysqli_fetch_assoc($result);
    
    $message = $_POST['message'];
    $id_admin = $user['id_admin'];
    $Type = $_POST['category'];
    
    
    if(isset($_POST['other_category'])) {
      
      $Autre_type = $_POST['other_category'];



      $sql = "INSERT INTO reclamation (message, id_client, id_admin , Type, Autre_type)
                VALUES ('$message', '$id_client', '$id_admin', '$Type', '$Autre_type')";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            $_SESSION['status'] = "Reclamation Sended Successfully";
            $_SESSION['status_code'] = "success";
            header("Location: client_reclamation.php");

        } else {

            $_SESSION['status'] = "Woops! Something Wrong Went.";
            $_SESSION['status_code'] = "error";
            header("Location: client_reclamation.php");

        }


    } else {


      $sql = "INSERT INTO reclamation (message, id_client, id_admin , Type)
                VALUES ('$message', '$id_client', '$id_admin', '$Type')";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            $_SESSION['status'] = "Reclamation Sended Successfully";
            $_SESSION['status_code'] = "success";
            header("Location: client_reclamation.php");

        } else {

            $_SESSION['status'] = "Woops! Something Wrong Went.";
            $_SESSION['status_code'] = "error";
            header("Location: client_reclamation.php");

        }

    }

    

  }






  // ajouter une consommation de part de cliente
  if (isset($_POST['submit-add-consommation'])) {

    if (isset($_FILES['image'])){

      
      $id_client = $_SESSION['id'];
      $consommation = $_POST['consommation'];
      $mois = $_POST['month'];
      $annee = date('Y');
      $image = $_FILES['image']['name'];

      $sql = "SELECT * FROM facture WHERE id_client  = '$id_client' AND mois = '$mois' AND annee = '$annee'";
      $result = mysqli_query($conn, $sql);


      if (!$result->num_rows > 0) {

        move_uploaded_file($_FILES['image']['tmp_name'], 'lib/images_consommation/'.
        $_FILES['image']['name']);

      //mois 1
      if($mois == 1){

        $consommation_de_mois_1 = $consommation;

        $annee_pre = $annee - 1;


        $sql = "SELECT * FROM facture WHERE id_client  = '$id_client'
        AND mois = 12 AND annee = '$annee_pre'";
        $result = mysqli_query($conn, $sql);


        if ($result->num_rows > 0) {

          //consommation de tout annee precedent de ce client
          $consommation_tout_annee = mysqli_fetch_assoc($result)['consommation'];


          $sql = "SELECT * FROM consommation_annuelle WHERE id_client  = '$id_client' 
          AND annee = '$annee_pre'";
          $result = mysqli_query($conn, $sql);
          
          //consommation de tout annee precedent de ce client saisee par agent (vrais)
          $consommation_saisee_par_agent = mysqli_fetch_assoc($result)['consommation_annuelle'];


          $difference = $consommation_saisee_par_agent - $consommation_tout_annee;



          if($difference >=0 && $difference <= 100 ){

            //consommation de mois 1
            $consommation;
          } else {

            //consommation de mois 1
            $consommation += $difference;
          }


        } else {
            
            //consommation de mois 1
            $consommation;
        }
        
        
        if($consommation <= 100) {
          $HT = $consommation * 0.91;
        } else if ($consommation >= 101 && $consommation <= 200){
          $HT = $consommation * 1.01;
        } else if ($consommation >= 201){
          $HT = $consommation * 1.12;
        }
        

        $TTC = $HT + $HT * 0.14;


        if ($consommation >= 50 && $consommation <= 400) {

          //validee automatique
          $sql = "INSERT INTO facture (HT, TTC, annee , mois, consommation, image, id_client, statut_de_validation)
                VALUES ('$HT', '$TTC', '$annee', '$mois', '$consommation_de_mois_1', '$image', '$id_client', 'valide')";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            $_SESSION['status'] = "Votre Consommation a ete ajouter avec sucsee";
            $_SESSION['status_code'] = "success";
            header("Location: client_consommation.php");

        } else {

            $_SESSION['status'] = "Woops! Something Wrong Went.";
            $_SESSION['status_code'] = "error";
            header("Location: client_consommation.php");

        }
          
          
        } else {
          //validee non automatique
          $sql = "INSERT INTO facture (HT, TTC, annee , mois, consommation, image, id_client)
                VALUES ('$HT', '$TTC', '$annee', '$mois', '$consommation_de_mois_1', '$image', '$id_client')";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            $_SESSION['status'] = "Votre Consommation a ete ajouter avec sucsee";
            $_SESSION['status_code'] = "success";
            header("Location: client_consommation.php");

        } else {

            $_SESSION['status'] = "Woops! Something Wrong Went.";
            $_SESSION['status_code'] = "error";
            header("Location: client_consommation.php");

        }

        }



      } else if( $mois != 1 ) {


        $mois_precedent = $mois - 1;



        $sql = "SELECT * FROM facture WHERE id_client  = '$id_client' 
        AND mois = '$mois_precedent' AND annee = '$annee'";
        $result = mysqli_query($conn, $sql);


        if ($result->num_rows > 0) {

          $consommation_mois_precedente = mysqli_fetch_assoc($result)['consommation'];

          
          //consommaton de cette mois
          $consommation_de_ce_mois = $consommation - $consommation_mois_precedente;

          //consommaton de cette mois
          // $consommation -= $consommation_mois_precedente;

          if($consommation_de_ce_mois <= 100) {
            $HT = $consommation_de_ce_mois * 0.91;
          } else if ($consommation_de_ce_mois >= 101 && $consommation_de_ce_mois <= 200){
            $HT = $consommation_de_ce_mois * 1.01;
          } else if ($consommation_de_ce_mois >= 201){
            $HT = $consommation_de_ce_mois * 1.12;
          }
          
  
          $TTC = $HT + $HT * 0.14;


          if ($consommation_de_ce_mois >= 50 && $consommation_de_ce_mois <= 400) {

            //validee automatique
            $sql = "INSERT INTO facture (HT, TTC, annee , mois, consommation, image, id_client, statut_de_validation)
                  VALUES ('$HT', '$TTC', '$annee', '$mois', '$consommation', '$image', '$id_client', 'valide')";
          $result = mysqli_query($conn, $sql);
  
          if ($result) {
  
              $_SESSION['status'] = "Votre Consommation a ete ajouté avec succès";
              $_SESSION['status_code'] = "success";
              header("Location: client_consommation.php");
  
              } else {
  
                  $_SESSION['status'] = "Woops! Something Wrong Went.";
                  $_SESSION['status_code'] = "error";
                  header("Location: client_consommation.php");
  
              }
            
            
          } else {
            //validee non automatique
            $sql = "INSERT INTO facture (HT, TTC, annee , mois, consommation, image, id_client)
                  VALUES ('$HT', '$TTC', '$annee', '$mois', '$consommation', '$image', '$id_client')";
          $result = mysqli_query($conn, $sql);
  
            if ($result) {
  
                $_SESSION['status'] = "Votre Consommation a ete ajouté avec succès";
                $_SESSION['status_code'] = "success";
                header("Location: client_consommation.php");
  
            } else {
  
                $_SESSION['status'] = "Woops! Something Wrong Went.";
                $_SESSION['status_code'] = "error";
                header("Location: client_consommation.php");
  
            }
  
          }



        } else {

                $_SESSION['status'] = "Vous avez besoin de saisie la consommation de mois " . $mois_precedent;
                $_SESSION['status_code'] = "error";
                header("Location: client_consommation.php");

        }


      }
      


      } else {
    
        $_SESSION['status'] = "Vous avez deja saisie la consommation de ce mois";
        $_SESSION['status_code'] = "error";
        header("Location: client_consommation.php");

      }

    }

  }







  //Payer Facture
  if (isset($_POST['submit-payer-facture'])) {

    $id_facture = $_POST['id_facture'];



    $sql = "UPDATE facture SET statut_de_payment = 'payee'
    WHERE id = '$id_facture'";
  
  if ($conn->query($sql) === TRUE) {

    $_SESSION['status'] = "Votre Facture a ete payer avec succes";
    $_SESSION['status_code'] = "success";
    header("Location: dashboard_client.php");

  } else {
    $_SESSION['status'] = "Woops! Something Wrong Went.";
    $_SESSION['status_code'] = "error";
    header("Location: dashboard_client.php");
  }
  }




  //Telecharger Facture
  if (isset($_POST['submit-telecharger-facture'])) {

    $id_facture = $_POST['id_facture'];
    $HT_facture = $_POST['HT_facture'];
    $TTC_facture = $_POST['TTC_facture'];
    $annee_facture = $_POST['annee_facture'];
    $mois_facture = $_POST['mois_facture'];
    $consommation_facture = $_POST['consommation_facture'];
    $statut_de_payment_facture = $_POST['statut_de_payment_facture'];
    $id_client_facture = $_POST['id_client_facture'];

    $sql = "SELECT * FROM client WHERE id = '$id_client_facture'";
    $result = mysqli_query($conn, $sql);

    $client = mysqli_fetch_assoc($result);
    
    $id_client = $client['id'];
    $nom_client = $client['nom'];
    $prenom_client = $client['prenom'];
    $adresse_client = $client['adress'];
    $email_client = $client['email'];
    $telephone_client = $client['telephone'];
    $nom_zone_geographique = $client['nom_zone_geographique'];

    
//make TCPDF object
$pdf = new TCPDF('P','mm','A4');

//remove default header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

//add page
$pdf->AddPage();

//add content (student list)
//title
$pdf->SetFont('Helvetica','',14);
$pdf->Cell(190,10,"Information De Facture",0,1,'C');

$pdf->writeHTML("<hr>", true, false, false, false, '');

$pdf->ImageSVG($file='lib/img/illustrations/icons8-energy.svg', $x=165, $y=30, $w='', $h='', $fitonpage=false);
$pdf->Image('lib/img/illustrations/Oprah-Winfrey-Signature-1.png', 145, 155, 50, 50);

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();
$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();
$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();
$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();
$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();
$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();
$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"Information De Facture",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();
$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();
$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(30,5,"Client Id",0);
$pdf->Cell(160,5," :  $id_client ",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(30,5,"Client Nom",0);
$pdf->Cell(160,5," :  $nom_client",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(30,5,"Client Prenom",0);
$pdf->Cell(160,5," :  $prenom_client",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(30,5,"Client Adress",0);
$pdf->Cell(160,5," :  $adresse_client",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(30,5,"Client Email",0);
$pdf->Cell(160,5," :  $email_client",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(30,5,"Client Telephone",0);
$pdf->Cell(160,5," :  $telephone_client",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(60,5,"Nom Zone Geographique De Client",0);
$pdf->Cell(160,5," :  $nom_zone_geographique",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"Information De Facture",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(70,5,"",0);
$pdf->Cell(160,5,"",0);
$pdf->Ln();


//make the table
$html = "
	<table>
		<tr>
			<th>ID</th>
			<th>Consommation</th>
			<th>Le prix HT</th>
			<th>Le prix TTC</th>
			<th>Annee</th>
			<th>Mois</th>
			<th>Statut De Payment</th>
		</tr>
		";


$html .= "
    <tr>
        <td>$id_facture</td>
        <td>$consommation_facture</td>
        <td>$HT_facture</td>
        <td>$TTC_facture</td>
        <td>$annee_facture</td>
        <td>$mois_facture</td>
        <td>$statut_de_payment_facture</td>
    </tr>
    ";	

$html .= "
	</table>
	<style>
	table {
		border-collapse:collapse;
	}
	th,td {
		border:1px solid #888;
	}
	table tr th {
		background-color:#888;
		color:#fff;
		font-weight:bold;
	}
	</style>
";

//WriteHTMLCell
$pdf->WriteHTMLCell(192,0,9,'',$html,0);	


//output
// $pdf->Output();
$pdf->Output('info.pdf', 'D');



  }





} else if (isset($_SESSION['id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'agent') {


    $id_agent = $_SESSION['id'];
    $user_type = $_SESSION['user_type'];



    //ajouter une consommation
  if (isset($_POST['submit-add-ConsommationAnnuelle'])) {

    
    if (isset($_FILES['ficher_conso_annua'])){

      
      $file_name = $_FILES['ficher_conso_annua']['name'];
      $file_temp = $_FILES['ficher_conso_annua']['tmp_name'];
      $file_destination = "fiche/" . $file_name;

      // Check file extension to ensure it's a text file
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));



      if($file_extension === 'txt'){


        move_uploaded_file($_FILES['ficher_conso_annua']['tmp_name'], 'lib/Consommations_Annuelle_Ficher/'.
        $_FILES['ficher_conso_annua']['name']);

        $file = fopen("lib/Consommations_Annuelle_Ficher/" . $_FILES['ficher_conso_annua']['name'], "r");

        // Read the first line (header) and discard it
        fgetcsv($file, 0, "\t");

        // Initialize an empty array to store the data
        $data = array();


        // Loop through each line of the file and store the values in the array
        while (($line = fgetcsv($file, 0, "\t")) !== false) {
          $id_client = $line[0];
          $consommation_annuelle = $line[1];
          $annee = $line[2];

          // Store the values in an array
          $data[] = array(
              "id_client" => $id_client,
              "consommation_annuelle" => $consommation_annuelle,
              "annee" => $annee
          );
        }

        // Close the file
        fclose($file);
        foreach ($data as $key => $value) {

          $id_client = $value['id_client'];
          $consommation_annuelle = $value['consommation_annuelle'];
          $annee = $value['annee'];


          $sql = "SELECT id_admin FROM client WHERE id_agent = '$id_agent' AND id = '$id_client'";
          $result = mysqli_query($conn, $sql);


          $id_admin = mysqli_fetch_assoc($result)['id_admin'];


          $sql = "INSERT INTO consommation_annuelle (consommation_annuelle, annee, id_client, id_admin, id_agent)
              VALUES ('$consommation_annuelle', '$annee', '$id_client', '$id_admin', '$id_agent')";
          $result = mysqli_query($conn, $sql);

          if ($result) {
            $sql_st = 1;
          } else {
            $sql_st = 0;
        }
            
            
        }

          
        if ($sql_st = 1) {
          $_SESSION['status'] = "Ficher Added Successfully !";
          $_SESSION['status_code'] = "success";
          header("Location: dashboard_agent.php");

        } else {
            $_SESSION['status'] = "Woops! Something Wrong Went.";
            $_SESSION['status_code'] = "error";
            header("Location: dashboard_agent.php");
        }
          
        

    } else {
        // If file not a text file, redirect to error page
        $_SESSION['status'] = "The file should be a text file";
            $_SESSION['status_code'] = "error";
            header("Location: dashboard_agent.php");

        exit();
    }

    }

  }


} else {
    // Redirect the user to the login page
    header('Location: login.php');
    exit();
}