<form class="form-signin formulaire m-auto" action="index.php?uc=rapportdevisite&action=" method="post">
    <input type="date" class="form-control" name="date" placeholder="Date de la visite" autofocus="" />

    <textarea class="form-control" name="bilan" placeholder="bilan"></textarea>
    <input type="password" class="form-control" name="password" placeholder="Mot de passe" />

    <select name="motifNormal">
        <?php
            foreach($motifs as $motif)
            {
                echo '<option value='.$motif['MOTIF_NUM'].'>'.$motif['MOTIF_LIBELLE'].'</option>';
            } 
        ?>
    </select>
</form>