<section class="bg-light">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3 w-100">
                <form class="formulaire form-horizontal" action="#" method="post">
                    <div class="form-group">
                        <label for="praticien">Choix praticien :</label>
                        <select class="form-select" id="praticien" name="praticien">
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
                        <label for="dateDebut">Depuis :</label>
                        <input class="form-control datepicker" type="date" id="dateDebut" name="dateDebut" <?php if(isset($dateDebut)) echo "value=$dateDebut" ?> />
                    </div>

                    <div class="form-group">
                        <label for="dateFin">Jusqu'à :</label>
                        <input class="form-control datepicker" type="date" id="dateFin" name="dateFin" <?php if(isset($dateFin)) echo "value=$dateFin" ?> />
                    </div>
                    
                    <input class="btn btn-lg btn-info btn-block text-light" type="submit" value="Filtrer">
                </form>
            </div>
        </div>
    </div>
</section>

<section class="bg-light">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3 w-100 list-group">
                <?php
                foreach($rapports as $rapport)
                {
                ?>

                <a class="list-group-item list-group-item-action">
                    <?= $rapport['RAP_NUM'] ?>   <?= $rapport['PRA_NUM'] ?>
                </a>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>
