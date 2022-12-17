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
            <?php foreach ($rapports as $rapport) {
                $motif = getMotifLibelle($rapport);
                $praticien = getAllInformationPraticien($rapport['PRA_NUM']);
            ?>

              <a href="index.php">
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
                </tr>
              </a>

            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>