<section class="bg-light">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="form-rapport-container col-12 col-sm-8 col-lg-6 col-xl-55 col-xxl-4 py-lg-5 py-3">
                <div class="form-rapport form-signin formulaire m-auto">
                    <h2 class="center form-signin-heading">Rapport de visite</h2>

                    <div class="champs-rapport">
                        <div class="partie-gauche">
                            <div>Numéro rapport : <?= $rapNum ?> </div>
                            <div>Matricule du collaborateur : <?= $matricule ?></div>
                            <div> Praticien : 
                                <a href="index.php?uc=praticien&action=afficherPraticien&praticien=<?= $rapport['PRA_NUM'] ?>">
                                    <?= $praticien['PRA_NOM'].' '.$praticien['PRA_PRENOM']?>
                                </a>
                            </div>
                            <div>Date de saisie du rapport : <?=$rapport['RAP_DATESAISIE']?></div>
                            <div>Bilan de la visiste : <?=$rapport['RAP_BILAN'] ?></div>
                        </div>
    
                        <div class="partie-droite">
                            <div>Date de la visite : <?= $rapport['RAP_DATE'] ?></div>
                            <div>Motif de la visite : <?= $motif ?></div>

                            <?php
                            if (isset($medicament1))
                                echo '
                                <div>Médicament présenté : 
                                    <a href="index.php?uc=medicaments&action=affichermedoc&medicament='.$rapport['MEDICAMENT1'].'">' 
                                        . $medicament1['MED_NOMCOMMERCIAL'].
                                    '</a>
                                </div>';

                            if(isset($medicament2))
                                echo '
                                <div>Deuxième médicament présenté : 
                                    <a href="index.php?uc=medicaments&action=affichermedoc&medicament='.$rapport['MEDICAMENT2'].'">' 
                                        . $medicament2['MED_NOMCOMMERCIAL'].
                                    '</a>
                                </div>
                                ';
                            ?>

                            <div><?php
                            if($echantillons)
                            {
                                foreach($echantillons as $key => $ech)
                                    echo 'Echantillon n°'.($key+1).' : 
                                    <a href="index.php?uc=medicaments&action=affichermedoc&medicament='.$ech['MED_DEPOTLEGAL'].'">'
                                        .$ech['MED_NOMCOMMERCIAL'].
                                    '</a><br>';
                            } else
                                echo 'Aucun échantillon offert';
                            ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>