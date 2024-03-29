<script>
    var medicaments = <?= json_encode($medicaments) ?>;
</script>

<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Saisie du rapport N°<?= $numRapport ?></h1>
            <p class="text text-center">Formulaire permettant de rédiger un rapport de visite.</p>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="form-rapport-container col-12 col-sm-8 col-lg-6 col-xl-55 col-xxl-4 py-lg-5 py-3">
                <?php
                    if(isset($erreurs) && $erreurs)
                    {
                        include('vues/v_afficherErreurs.php');
                    }
                ?>

                <form class="form-rapport form-signin formulaire m-auto" action="<?= $url ?>" method="post">
                    <p><abbr>*</abbr>Champs obligatoires</p>

                    <input name="rapport" hidden value="<?= $numRapport ?>" />

                    <h2 class="center form-signin-heading">Rapport de visite</h2>

                    <fieldset class="champs-rapport">
                        <div class="partie-gauche">
                            <p>Numéro du rapport : <?= $numRapport ?></p>
                            <p>Matricule du collaborateur : <?= $matricule ?></p>
    
                            <div class="form-group">
                                <label for="praticien">Praticien concerné <abbr>*</abbr> :</label>
                                <select class="form-select w-75" id="praticien" name="praticien">
                                    <option value="">-Choisissez un praticien-</option>
            
                                    <?php
                                    foreach($praticiens as $pra)
                                    {
                                    ?>        
                                        <option value=<?= $pra['PRA_NUM'] ?> <?php if(isset($praticien) && $pra['PRA_NUM'] == $praticien) echo 'selected' ?>>
                                            <?= $pra['PRA_NOM'].' '.$pra['PRA_PRENOM'] ?>
                                        </option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </div>

							<div class="form-group">
								<label for="remplacant">Remplaçant</label>
								<select class="form-select w-75" id="remplacant" name="remplacant">
									<option value="">Aucun</option>

									<?php
                                    foreach($praticiens as $pra)
                                    {
                                    ?>        
                                        <option value=<?= $pra['PRA_NUM'] ?> <?php if(isset($remplacant) && $pra['PRA_NUM'] == $remplacant) echo 'selected' ?>>
                                            <?= $pra['PRA_NOM'].' '.$pra['PRA_PRENOM'] ?>
                                        </option>
                                    <?php 
                                    }
                                    ?>
								</select>
							</div>
    
                            <div class="form-group">
                                <label for="dateSaisie">Date de saisie <abbr>*</abbr> :</label>
                                <input id="dateSaisie" name="dateSaisie" type="date" value="<?= $dateSaisie ?>">
                            </div>
    
                            <div class="form-group">
                                <label for="bilan">Bilan du rapport <abbr>*</abbr> :</label>
                                <textarea class="form-control w-75" id="bilan" name="bilan"><?php 
									if(isset($bilan)) echo htmlspecialchars($bilan); ?></textarea>
                            </div>
                        </div>
    
                        <div class="partie-droite">
                            <div class="form-group">
                                <label for="dateVisite">Date de visite <abbr>*</abbr> :</label>
                                <input id="dateVisite" name="dateVisite" type="date" 
                                    <?php
                                        if(isset($dateVisite)) echo "value='$dateVisite'";
                                    ?>
                                />
                            </div>
        
                            <div class="form-group motif-group">
                                <label for="motifNormal">Motif <abbr>*</abbr> : </label>
                                <select class="w-75 form-select" id="motifNormal" name="motifNormal" onchange="addMotifAutre(this.value)">
                                    <option value="">-Choisissez un motif-</option>
            
                                    <?php
                                    foreach($motifs as $mot)
                                    {
                                    ?>
                                        <option value='<?= $mot['MOTIF_NUM'] ?>'
                                            <?php if(isset($motif) && $mot['MOTIF_NUM'] == $motif) echo 'selected'; ?>
                                        > 
                                            <?= $mot['MOTIF_LIBELLE'] ?>
                                        </option>;
                                    <?php
                                    }
                                    ?>

									<option value="autre" <?php if(isset($motifAutre) && $motifAutre != null) echo 'selected'; ?>>Autre</option>
                                </select>
                            </div>

                            <?php
                                if(isset($motifAutre) && $motifAutre != null)
                                {
                                    echo '
                                    <div id="divmotifautre" name="divmotifautre">
                                        <textarea id="motif-autre" class="form-control m-0 mt-2" name="motif-autre" placeholder="Veuillez saisir le motif autre">'.$motifAutre.'
                                        </textarea>
                                    </div>';
                                }
                                else 
                                {
                                    echo '<div id="divmotifautre" name="divmotifautre" hidden></div>';
                                }
                            ?>
                            
                            <div id="medoc" class="form-group">
                                <label for="medicament1">1er médicament présenté:</label>
                                <select class="form-select" id="medicament1" name="medicament1" onchange="addMedicament(this, medicaments)">
                                    <option value="">-Aucun-</option>
        
                                    <?php
                                    foreach($medicaments as $medicament)
                                    {
                                    ?>
                                        <option value="<?= $medicament['MED_DEPOTLEGAL'] ?>" 
                                            <?php if(isset($medicament1) && $medicament['MED_DEPOTLEGAL'] == $medicament1) echo 'selected'?>
                                        >
                                            <?= $medicament['MED_NOMCOMMERCIAL'] ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <?php if($medicament2 != null) { ?>
                                <div id="medoc-autre">
                                    <label id="labelMedoc" for="medicament2">2ème médicament présenté :</label>

                                    <select class="form-select" id="medicament1" name="medicament1">
                                        <option value="">-Choisissez un médicament-</option>
            
                                        <?php
                                        foreach($medicaments as $medicament)
                                        {
                                        ?>
                                            <option value="<?= $medicament['MED_DEPOTLEGAL'] ?>" 
                                                <?php if(isset($medicament1) && $medicament['MED_DEPOTLEGAL'] == $medicament2) echo 'selected'?>
                                            >
                                                <?= $medicament['MED_NOMCOMMERCIAL'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php } ?>

                            <div class="bloc-center form-check form-switch">
                                <input <?php if(isset($echantillons) && $echantillons) echo "checked"; ?> id="check-echantillon" class="form-check-input" type="checkbox" onchange="addEchantillon(this, medicaments)" >
                                <label for="check-echantillon">Echantillon</label>
                            </div>

                            <div id="redigerEtEchantillon" hidden>
                            </div>

                            <?php
                                if(isset($echantillons) && $echantillons)
                                {
                                    echo "<div class=\"col-10 d-flex flex-column justify-content-center align-items-center mt-3 mb-5 mx-auto\" id=\"addechantillon\">";

                                    foreach($echantillons as $key => $ech)
                                    {
                                        $echNb = $key + 1;

                                        echo 
                                        "
                                            <div id=\"Echantillon$echNb\" class=\" mb-1 d-flex flex-row\">
                                                <select name=\"echantillonadd[]\" id=\"echantillonadd$echNb\" class=\"form-select m-0 me-1\" required>
                                                    <option value=\"\">- Choisissez un échantillon -</option>
                                        ";

                                        foreach($medicaments as $medicament)
                                        {
                                        ?>
                                            <option value="<?= $medicament['MED_DEPOTLEGAL'] ?>" 
                                                <?php if($medicament['MED_DEPOTLEGAL'] == $ech['MED_DEPOTLEGAL']) echo 'selected'?>
                                            >
                                                <?= $medicament['MED_NOMCOMMERCIAL'] ?>
                                            </option>
                                        <?php
                                        }

                                        echo 
                                        '
                                                </select>
                                                <input name="nbEchantillon[]" required min="1" value="'.$ech['OFF_QTE'].'" class="form-control me-1 rounded w-25 text-center" id="nbEchantillon$echNb" type="number">
                                        ';
                                        if($key == count($echantillons) - 1)
                                        {
                                            echo
                                            "
                                            <button type=\"button\" id=\"button\" value=\"$echNb\" onclick=\"addOtherEchantillon();\" class=\"btn btn-outline-secondary\">
                                                <i class=\"bi bi-plus-lg\"></i>
                                            </button>
                                            ";
                                        }
                                        if($echNb > 1)
                                        {
                                            echo "
                                                <button type=\"button\" id=\"buttonMinus\" value=\"$echNb\" onclick=\"minusEchantillon(this);\" class=\"btn btn-outline-secondary\">
                                                    <i class=\"bi bi-dash-lg\"></i>
                                                </button>
                                            ";
                                        }

                                        echo 
                                        "
                                            </div>
                                        ";
                                    }

                                    echo "</div>";
                                }
                            ?>
                        </div>

                    </fieldset>
                    <br/>

                    <div class="bloc-center form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="saisieDefinitive" name="saisieDefinitive"/>
                        <label for="saisieDefinitive">Saisie définitive</label>
                    </div>

                    <div class="bouton-quitter">
                        <input class="w-25 btn btn-info text-light valider" onclick="return warn()" type="submit" value="Valider le rapport">

                        <input class="w-25 btn btn-info text-light valider" type="button" onclick="history.go(-1)" value="Retour">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>