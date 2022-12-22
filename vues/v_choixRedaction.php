<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Formulaire de rédaction de rapport</h1>
            <p class="text text-center">Formulaire permettant de rédiger un rapport.</p>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5">
                <img class="img-fluid" src="assets/img/papier.jpg">
            </div>
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
                <form class="form-signin formulaire m-auto" action="index.php?uc=saisirRapport&action=modifierRapport" method="post">
                    <h2 class="form-signin-heading">Choix du rapport</h2>
                    
                    <select name="rapport" class="form-select">
                        <?php
                            foreach($rapports as $rapport)
                            {
                                echo '<option value="'.$rapport['RAP_NUM'].'">Rapport n°'.$rapport['RAP_NUM'].' saisi le '.$rapport['RAP_DATESAISIE'].'</option>';
                            }
                        ?>
                    </select>

                    <input class="btn btn-lg btn-info btn-block text-light" type="submit" name="connexion" value="Choisir">
                    <div><a class="btn btn-lg btn-info btn-block text-light" href="index.php?uc=saisirRapport&action=redigerRapport">Nouveau rapport</a></div>
                </form>
            </div>
        </div>
    </div>
</section>
