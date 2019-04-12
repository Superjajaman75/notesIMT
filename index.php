<?php
//TODO 
//- export PDF
//- rang

session_start();

if(!isset($_SESSION['username'])){
	header("location:page-login.php"); //Redirection vers la page Login
}

$username = $_SESSION['username'];
$password = $_SESSION['password'];
?>


<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IMT Notes</title>
    <meta name="description" content="IMT Notes">
	<meta name="author" content="Benjamin BONHOMME" />
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

	<style>
		.loader {
		  margin-left: auto;
          margin-right: auto;
		  border: 16px solid #f3f3f3; /* Light grey */
		  border-top: 16px solid #3498db; /* Blue */
		  border-radius: 50%;
		  width: 120px;
		  height: 120px;
		  animation: spin 2s linear infinite;
		}

		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(360deg); }
		}
		
		@media only screen and (max-width: 900px) {
			.rowHide { display: none; }
		}
	</style>
	
</head>

<body>


    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">
            <div class="header-menu">
				<div class="float-left">
					<h3 id="myTitle"></h3>
                </div>
				<div class="user-area dropdown float-right">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img class="user-avatar rounded-circle" src="images/admin.jpg" alt="User Avatar">
					</a>

					<div class="user-menu dropdown-menu">
						<a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i>&nbsp;D&eacute;connexion</a>
					</div>
				</div>
            </div>
        </header><!-- /header -->
        <!-- Header-->


        <div class="content mt-3">
			<div class="card">
				<div class="card-header">
					<strong id="myEcole" class="card-title"></strong>
				</div>
				<div id="container" class="card-body">
					<h2>Chargement des notes...</h2>
					<div class="loader"></div> 
					<p>Cela peut durer un moment en fonction des serveurs de l'IMT.</p>
				</div><!-- cardbody-->
			</div><!-- card -->
		</div><!-- .content -->
	</div><!-- /#right-panel -->

    <!-- Right Panel -->


    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
	<script>
		jQuery.noConflict();
		(function($) {

			function writeJson(json) {
				$('#container').empty();
				
				var myJSON = JSON.parse(json);
				var notes = myJSON.list1.list1_Details_Group_Collection.list1_Details_Group;
				
				//Gestion des étudiants en 1A qui n'ont qu'un bulletin
				//et donc ou 'notes' n'est pas un tableau iterable
				//On transforme donc note en tableau de 1 itérable
				if (typeof (notes) == "object" && !Array.isArray(notes)) { notes = [notes]; }
				
				var ecole = notes[0]["@attributes"].X_Ecole;
				var etudiant = notes[0]["@attributes"].textbox10;
				$('#myTitle')[0].innerHTML = "Relev&eacute; de notes de " + etudiant;
				$('#myEcole')[0].innerHTML = ecole;
				
				html = '<div class="default-tab"><nav><div class="nav nav-tabs" id="nav-tab" role="tablist">';
				
				//Création des onglets
				for (let i = notes.length-1; i >= 0; i--) {
					html += '<a class="nav-item nav-link" id="nav-'+i+'-tab" data-toggle="tab" href="#nav-'+i+'" role="tab" aria-controls="nav-'+i+'" aria-selected="false">'+notes[i]["@attributes"].X_AnnSco+'</a>'
				}
				html += '</div></nav><div class="tab-content pl-3 pt-2" id="nav-tabContent">';
				
				for (let i = notes.length-1; i >= 0; i--) {
					if (i == notes.length-1) {
						html+= '<div class="tab-pane fade show active" id="nav-'+i+'" role="tabpanel" aria-labelledby="nav-'+i+'-tab">';
					} else {
						html+= '<div class="tab-pane fade" id="nav-'+i+'" role="tabpanel" aria-labelledby="nav-'+i+'-tab">';
					}
					
					let moyenne = notes[i].table2["@attributes"].textbox33;
					let moy_pond = parseFloat(moyenne)*5;
					let rang = notes[i]["@attributes"].textbox19;
					
					html += '<div class="col-lg-2 "><p>Moyenne de l\'&eacute;tudiant : </p></div><div class="col-lg-8"><div class="progress mb-3"><div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: '+moy_pond+'%" aria-valuenow="'+moy_pond+'" aria-valuemin="0" aria-valuemax="20">'+moyenne+'</div></div></div><div class="col-lg-2 "><p>'+rang+'</p></div>';
					
					html += '<table class="table"><thead class="thead-dark"><tr><th class="rowHide">Module</th> <th>Nom</th> <th class="rowHide">Heure</th> <th class="rowHide">ECTS</th> <th class="rowHide">Coef</th> <th>Note</th> <th class="rowHide">Note US</th>  </tr> </thead> <tbody>';
					
					let item = notes[i].table2.Detail_Collection.Detail;
					
					item.forEach(function(el) {
						let module 	= el["@attributes"].textbox38 || "";
						let nom 	= el["@attributes"].textbox40 || "";
						let heure 	= el["@attributes"].textbox41 || "";
						let ects 	= el["@attributes"].textbox46 || "";
						let coeff 	= el["@attributes"].textbox22 || "";
						let note 	= el["@attributes"].textbox52 || "";
						let noteUS 	= el["@attributes"].textbox2 || "";
						
						if (!ects && !coeff && !noteUS) {
							html += '<tr><td class="rowHide"><b>'+module+'</b></td> <td><b>'+nom+'</b></td> <td class="rowHide"><b>'+heure+'</b></td> <td class="rowHide"><b>'+ects+'</b></td> <td class="rowHide"><b>'+coeff+'</b></td> <td><b>'+note+'</b></td> <td class="rowHide"><b>'+noteUS+'</b></td> </tr>';
						} else {
							html += '<tr><td class="rowHide">'+module+'</td> <td>'+nom+'</td> <td class="rowHide">'+heure+'</td> <td class="rowHide">'+ects+'</td> <td class="rowHide">'+coeff+'</td> <td>'+note+'</td> <td class="rowHide">'+noteUS+'</td> </tr>';
						}
					});
					html+= '</tbody></table></div>';
				}
				html+= '</div></div>';
				
				$('#container').append(html);
			}
			
			$.ajax({
				data: { username: "<?php echo $username?>", password: "<?php echo $password?>" },
				method: "POST",
				url: "sifiQuery.php",
				success: function(json) {
					writeJson(json);
					//console.log(JSON.parse(json));
				}
			});
		})(jQuery);
		
	</script>


</body>

</html>
