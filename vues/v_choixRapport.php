<?php
foreach($rapports as $rapport)
{
?>
    <a href="index.php?uc=rapportdevisite&action=modifierRapport&id=<?= $rapport['RAP_NUM'] ?>" class="form-signin formulaire m-auto rapport">
        Numéro du rapport : <?= $rapport['RAP_NUM'] ?>
    </a>
<?php
}
?>
