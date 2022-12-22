<?php
require_once('controleur/c_rapport.php');

class SaisirRapportControleur extends RapportControleur
{
    private $action;
    private $matricule;
    private $motifs;
    private $medicaments;
    private $praticiens;
    private $paramsVue;

    public function __construct($action)
    {
        parent::__construct();

        $this->action = $action;

        $this->matricule = $_SESSION['matricule'];
        $this->motifs = $this->rapportModele->getMotifs();
        $this->medicaments = $this->medicamentModele->getAllNomMedicament();
        $this->praticiens = $this->praticienModele->getAllNomPraticien();

        $this->paramsVue = [
            'matricule' => $this->matricule,
            'motifs' => $this->motifs,
            'medicaments' => $this->medicaments,
            'praticiens' => $this->praticiens
        ];
    }

    /**
     * Permet de choisir l'action à effectuer
     * @return void
     */
    public function routeAction()
    {
        switch($this->action)
        {
            case 'choixRedaction':
                $this->choixRedaction();
                break;
            case 'redigerRapport':
                $this->redigerRapport();
                break;
            case 'confirmerRapport':
                $this->confirmerRapport();
                break;
            case 'modifierRapport':
                $this->modifierRapport();
                break;
            case 'confirmerModification':
                $this->confirmerRapport();
                break;
            default:
                header('Location:index.php?uc=accueil');
                break;
        }
    }

    /**
     * Affiche le formulaire permettant de choisir entre modifier un rapport ou en saisir un nouveau
     * @return void
     */
    private function choixRedaction()
    {
        $rapports = $this->rapportModele->getRapportsNonDef($this->matricule);

        if(!$rapports)
            header('Location:index.php?uc=saisirRapport&action=redigerRapport');

        $this->render('v_choixRedaction', ['rapports' => $rapports]);
    }

    /**
     * Affiche un formulaire de saisie vide pour saisir un nouveau rapport
     * @return void
     */
    private function redigerRapport()
    {
        $numRapport = $this->rapportModele->getRapportNum($this->matricule);
        $dateSaisie = date('Y-m-d', time());
        $url = 'index.php?uc=saisirRapport&action=confirmerRapport';

        $this->paramsVue += [
            'numRapport' => $numRapport,
            'dateSaisie' => $dateSaisie,
            'url' => $url
        ];

        $this->render('v_saisieRapport', $this->paramsVue);
    }
    
    /**
     * Permet de modifier un rapport existant depuis le formulaire pré-rempli
     * @return void
     */
    private function modifierRapport()
    {
        if(!isset($_POST['rapport']))
            header('Location:index.php?uc=saisirRapport&action=choixModifierRapport');

        $numRapport = $_POST['rapport'];

        // Récupère les données depuis le rapport à modifier
        $rapport = $this->rapportModele->getRapport($numRapport, $this->matricule);
        $dateSaisie = $rapport['RAP_DATESAISIE'] ?? date('Y-m-d', time());
        $echantillons = $this->medicamentModele->getEchantillons($numRapport, $this->matricule);

        $this->paramsVue += [
            'numRapport' => $numRapport,
            'dateSaisie' => $dateSaisie,
            'bilan' => $rapport['RAP_BILAN'],
            'dateVisite' => $rapport['RAP_DATE'],
            'praticien' => $rapport['PRA_NUM'],
            'medicament1' => $rapport['MEDICAMENT1'],
            'remplacant' => $rapport['PRA_REMP'],
            'motif' => $rapport['MOTIF_NUM'],
            'motifAutre' => $rapport['RAP_MOTIF'],
            'echantillons' => $echantillons,
            'url' => 'index.php?uc=saisirRapport&action=confirmerModification'
        ];

        $this->render('v_saisieRapport', $this->paramsVue);
    }

    /**
     * Vérifie les données du formulaire rempli 
     * -Si elles sont correctes, les enregistre en BDD
     * -Sinon, réaffiche le formulaire avec la liste des erreurs
     * @return void
     */
    private function confirmerRapport()
    {
        $numRapport = $_POST['rapport'];

        $valeursForm = $this->getValeursForm();
        extract($valeursForm);
        
        $erreurs = $this->getErreurs($praticien, $dateVisite, $dateSaisie, $motif, $motifAutre, $bilan);

        if(empty($erreurs))
        {
            // Si on insère un nouveau rapport
            if($this->action === 'confirmerRapport')
                $this->rapportModele->ajouterRapport(
                    $numRapport, $this->matricule, $dateVisite, $praticien, 
                    $remplacant, $motif, $motifAutre, $dateSaisie, $bilan, 
                    $medicament1, $medicament2, $saisieDefinitive
                );
            // Si on modifie un rapport déjà existant
            else if($this->action === 'confirmerModification')
            {
                $this->rapportModele->modifierRapport(
                    $numRapport, $this->matricule, $dateVisite, $praticien, 
                    $remplacant, $motif, $motifAutre, $dateSaisie, $bilan, 
                    $medicament1, $medicament2, $saisieDefinitive
                );

                // On supprime tous les échantillons pour ne pas créer de conflits avec les potentiels nouveaux à insérer
                $this->medicamentModele->supprimerEchantillons($numRapport, $this->matricule);
            }

            // On insère les échantillons
            if(isset($_POST['echantillonadd']))
            {
                $this->medicamentModele->insererEchantillons(
                    $numRapport, $_POST['echantillonadd'], $_POST['nbEchantillon'], $this->matricule
                );
            }
        }
        else 
        {
            // On ajoute les champs entrés dans le formulaire à la vue pour le pré-remplir
            $this->paramsVue += $valeursForm;

            // On ajoute les paramètres nécessaires pour la vue
            $this->paramsVue += [
                'numRapport' => $numRapport,
                'url' => 'index.php?uc=saisirRapport&action='.$this->action,
                'erreurs' => $erreurs
            ];

            // On affiche la vue avec la liste des erreurs
            $this->render('v_saisieRapport', $this->paramsVue);
        }
    }
    
    /**
     * Récupère tous les champs depuis le formulaire
     * @return array $tab La liste des champs sous forme de tableau associatif
     */
    private function getValeursForm()
    {
        // Gestion des champs non obligatoires
        $_POST['motifNormal'] != 'autre' && $_POST['motifNormal'] != '' ? 
            $motif = $_POST['motifNormal'] : 
            $motif = null;
        $motifAutre = $_POST['motif-autre'] ?? null;
        $medicament1 = $_POST['medicament1'] == '' ? null : $_POST['medicament1'];
        $medicament2 = $_POST['medicament2'] ?? null;
        isset($_POST['saisieDefinitive']) ? $saisieDefinitive = 1 : $saisieDefinitive = 0;
        $remplacant = $_POST['remplacant'] == '' ? null : $_POST['remplacant'];

        $tab = [
            'praticien' => $_POST['praticien'],
            'dateSaisie' => $_POST['dateSaisie'],
            'bilan' => $_POST['bilan'],
            'dateVisite' => $_POST['dateVisite'],
            'motif' => $motif,
            'motifAutre' => $motifAutre,
            'medicament1' => $medicament1,
            'medicament2' => $medicament2,
            'saisieDefinitive' => $saisieDefinitive,
            'remplacant' => $remplacant
        ];

        return $tab;
    }

    /**
     * Retourne un tableau contenant les erreurs de saisie du formulaire
     * @param mixed $praticien l'identifiant du praticien
     * @param mixed $dateVis la date de la visite
     * @param mixed $dateSaisie la date de saisie du rapport
     * @param mixed $motif l'identifiant du motif (s'il est habituel)
     * @param mixed $motifAutre le motif spécial (si le motif n'est pas habituel)
     * @param mixed $bilan le bilan de la visite
     * @return array<string> La liste des erreurs de saisie du formulaire
     */
    private function getErreurs($praticien, $dateVis, $dateSaisie, $motif, $motifAutre, $bilan)
    {
        $erreurs = [];
    
        if($praticien == '')
            $erreurs[] = 'Vous devez choisir un praticien';
        if($dateVis == '')
            $erreurs[] = 'Vous devez choisir une date de visite';
        if($dateSaisie == '')
            $erreurs[] = 'Vous devez choisir une dateDeSaisie';
        if(($motif == '' || $motif == 'autre') && $motifAutre == '')
            $erreurs[] = 'Veuillez saisir un motif';
        if($bilan == '')
            $erreurs[] = 'Vous devez rédiger un bilan';
    
        return $erreurs;
    }
}
