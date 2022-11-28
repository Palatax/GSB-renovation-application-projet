<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Saisie du rapport N°<?= $numRapport ?></h1>
            <p class="text text-center">Formulaire permettant de rédiger un rapport de visite.</p>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="form-rapport-container col-12 col-sm-8 col-lg-6 col-xl-55 col-xxl-4 py-lg-5 py-3">
                <form class="form-rapport form-signin formulaire m-auto" action="index.php?uc=rapportdevisite&action=confirmerRapport" method="post">
                    <p><abbr>*</abbr> Champs obligatoires</p>

                    <h2 class="center form-signin-heading">Rapport de visite</h2>

                    <fieldset class="champs-rapport">
                        <div class="partie-gauche">
                            <p>Numéro du rapport : <?= $numRapport ?></p>
                            <p>Matricule du collaborateur : <?= $matricule ?></p>
    
                            <div class="form-group">
                                <label for="praticien">Praticien concerné <abbr>*</abbr> :</label>
                                <select class="form-select w-75" id="praticien" name="praticien" required>
                                    <option>-Choisissez un praticien-</option>
            
                                    <?php
                                        foreach($praticiens as $praticien)
                                        {
                                            echo '<option value=.'.$praticien['PRA_NUM'].'>'.$praticien['PRA_NOM'].' '.$praticien['PRA_PRENOM'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
    
                            <div class="form-group">
                                <label for="dateSaisie">Date de saisie <abbr>*</abbr> :</label>
                                <input id="dateSaisie" name="dateSaisie" type="date" value="<?= $date ?>" required>
                            </div>
    
                            <div class="form-group">
                                <label for="bilan">Bilan du rapport <abbr>*</abbr> :</label>
                                <textarea class="form-control w-75" id="bilan" name="bilan" required></textarea>
                            </div>
                        </div>
    
                        <div class="partie-droite">
                            <div class="form-group">
                                <label for="dateVisite">Date de visite <abbr>*</abbr> :</label>
                                <input id="dateVisite" name="dateVisite" type="date" />
                            </div>
        
                            <div class="form-group motif-group">
                                <label for="motifNormal">Motif <abbr>*</abbr> : </label>
                                <select class="w-75 form-select" id="motifNormal" name="motifNormal" required>
                                    <option>-Choisissez un motif-</option>
            
                                    <?php
                                        foreach($motifs as $motif)
                                        {
                                            echo '<option value='.$motif['MOTIF_NUM'].'>'.$motif['LIBELLE'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="medicament1">1er médicament présenté:</label>
                                <select class="form-select" id="medicament1" name="medicament1">
                                    <option>-Choisissez un médicament-</option>
        
                                    <?php
                                        foreach($medicaments as $medicament)
                                        {
                                            echo '<option value='.$medicament['MED_DEPOTLEGAL'].'>'.$medicament['MED_NOMCOMMERCIAL'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <br/>

                    <div class="bloc-center form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="saisieDefinitive" name="saisieDefinitive"/>
                        <label for="saisieDefinitive">Saisie définitive</label>
                    </div>

                    <div class="bouton-quitter">
                        <input class="w-25 btn btn-info text-light valider" type="button"  value="Valider le rapport">

                        <input class="w-25 btn btn-info text-light valider" type="button" onclick="history.go(-1)" value="Retour">
                    </div>

                    <!-- <input type="text" class="form-control" name="username" placeholder="Identifiant" autofocus="" />
                    <input type="password" class="form-control" name="password" placeholder="Mot de passe" />
                    <input class="btn btn-lg btn-info btn-block text-light" type="submit" name="connexion" value="Connexion"> -->
                </form>
            </div>
        </div>
    </div>
</section>
