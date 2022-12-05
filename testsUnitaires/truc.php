


<head>
    <title>Projet GSB</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/boxicon.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/gsb.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>






<div class="container"></div>
	<div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3 formulaire-recherche">
			<div class="structure-hero pt-lg-5 pt-4">
	            <h1 class="titre text-center">Rapport de visite</h1>
	        </div>
				<p class="red">*</p><p>Champs obligatoires</p>
                <form action="index.php?uc=medicaments&action=affichermedoc" method="post" class="formulaire-recherche col-12 m-0">
                    <label class="titre-formulaire" for="listemedoc">Praticien concerné :</label>
                    <p class="red">*</p>
                    <select required name="medicament" class="form-select mt-3">
                        <option value class="text-center">- Choisissez un médicament -</option>
                        <?php
                        foreach ($result as $key) {
                            echo '<option value="' . $key['MED_DEPOTLEGAL'] . '" class="form-control">' . $key['MED_DEPOTLEGAL'] . ' - ' . $key['MED_NOMCOMMERCIAL'] . '</option>';
                        }
                        ?>
                    </select>
                    <input class="btn btn-info text-light valider" type="submit" value="Afficher les informations">
                </form>
	</div>
</div>



<!-- pas important 
<?php include("../vues/v_footer.php") ;?>
-->