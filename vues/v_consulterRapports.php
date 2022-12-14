<section class="bg-light">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3 w-100">
                <form class="formulaire form-horizontal" action="#" method="post">
                    <table class="table">
                        <thead class="justify-content-between">
                            <tr>
                                <th>Choix praticien</th>
                                <th>Depuis</th>
                                <th>Jusqu'à</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="justify-content-between">
                                <td>
                                    <select class="form-select" id="praticien" name="praticien">
                                        <option value="">Tous</option>
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
                                </td>
                                <td>
                                    <input class="form-control datepicker" type="date" id="dateDebut" name="dateDebut" <?php if(isset($dateDebut)) echo "value=$dateDebut" ?> />
                                </td>
                                <td>
                                    <input class="form-control datepicker" type="date" id="dateFin" name="dateFin" <?php if(isset($dateFin)) echo "value=$dateFin" ?> />
                                </td>
                                <td id="truc">
                                    <input class="my-auto btn btn-lg btn-info btn-block text-light" type="submit" value="Filtrer">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="bg-light">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="formulaire test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3 w-100 list-group">
                <table class="table">
                    <thead>
                        <th>Numéro du rapport</th>
                        <th>Numéro du praticien</th>
                        <th>Nom du praticien</th>
                        <th>Motif</th>
                        <th>Date de la visite</th>
                    </thead>
                    <tbody>
                        <?php foreach($rapports as $rapport) { 
                            $motif = getMotifLibelle($rapport);
                            $praticien = getAllInformationPraticien($rapport['PRA_NUM']);
                        ?>
                        
                        <a href="index.php">
                            <tr>
                                <td><?= $rapport['RAP_NUM'] ?></td>
                                <td><?= $rapport['PRA_NUM'] ?></td>
                                <td><?= $praticien['prenom'].' '.$praticien['nom'] ?></td>
                                <td><?= $motif ?></td>
                                <td><?= date('d-m-Y', strtotime($rapport['RAP_DATE'])) ?></td>
                            </tr>
                        </a>
                        
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
