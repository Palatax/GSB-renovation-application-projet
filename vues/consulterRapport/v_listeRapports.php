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
            <?php foreach ($rapports as $key => $rapport) {
                $motif = $motifs[$key];
                $praticien = $praticiensRap[$key];
            ?>
                <tr>
                  <td>
                    <?= $rapport['RAP_NUM'] ?>
                  </td>
                  <td>
                    <?= $rapport['PRA_NUM'] ?>
                  </td>
                  <td>
                    <?= $praticien['prenom'] . ' ' . $praticien['nom'] ?>
                  </td>
                  <td>
                    <?= $motif ?>
                  </td>
                  <td>
                    <?= date('d-m-Y', strtotime($rapport['RAP_DATE'])) ?>
                  </td> 
                  <td>
                    <?php 
                      if ($_GET['uc']=='consulterRapportsRegion') {

                        $url = 'index.php?uc=consulterRapportsRegion&action=consulterRapportRegion&rapNum='.$rapport['RAP_NUM'].'&matricule='.$rapport['COL_MATRICULE'];

                      } else {

                        $url = 'index.php?uc=consulterRapports&action=consulterRapport&rapNum='.$rapport['RAP_NUM'];

                      }
                    ?>
                    <a href= "<?php echo $url;  ?>" class= "my-auto btn btn-lg btn-info btn-block text-light">Consulter</a>
                  </td>
                </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>