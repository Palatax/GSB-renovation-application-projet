<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Liste des rapports de votre région</h1>
            <p class="text text-center">
                Liste de tous les rapports rédigés dans votre région
            </p>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5">
                <img class="img-fluid size-img-page" src="assets/img/papier.jpg">
            </div>
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
                <?php if ($_SESSION['erreur']) {
                    echo '<p class="alert alert-danger text-center w-100">Un problème est survenu lors de la selection du rapport</p>';
                    $_SESSION['erreur'] = false;
                } ?>
                <form action="index.php?uc=rapportVisite&action=confirmerRapportRegion" method="post" class="formulaire-recherche col-12 m-0">
                    <label class="titre-formulaire" for="listerRapport">Rapports disponible :</label>
                    <select required name="rapportVisite" class="form-select mt-3">
                        <option value class="text-center">- Choisissez un rapport -</option>
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
    </div>
</section>