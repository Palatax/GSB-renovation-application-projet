<section class="bg-light">
    <div class="container">
        <div class="structure-hero pt-lg-5 pt-4">
            <h1 class="titre text-center">Profil</h1>
            <p class="text text-center">
                Vos informations personnelles.
            </p>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5">
                <img class="img-fluid w-75" src="assets/img/profil.png">
            </div>
            <div class="test col-12 col-sm-8 col-lg-6 col-xl-5 col-xxl-4 py-lg-5 py-3">
                <div class="formulaire">

                    <p><span class="carac">Matricule</span> : <?php echo $info['matricule'] ?></p>
                    <p><span class="carac">Nom</span> : <?php echo $info['nom'] ?></p>
                    <p><span class="carac">Prenom</span> : <?php echo $info['prenom'] ?></p>
                    <p><span class="carac">Rue</span> : <?php echo $info['adresse'] ?></p>
                    <p><span class="carac">Code Postal</span> : <?php echo $info['cp'] ?></p>
                    <p><span class="carac">Ville</span> : <?php echo $info['ville'] ?></p>
                    <p><span class="carac">Date d'embauche</span> : <?php echo $info['date_embauche'] ?></p>
                    <p><span class="carac">Habilitation</span> : <span style="color:#0DCAF0;font-weight: 700;"> <?php echo $info['habilitation'] ?></span></p>
                    <p><span class="carac">Secteur</span> : <?php echo $info['secteur'] ?></p>
                    <p><span class="carac">Région</span> : <?php echo $info['region'] ?></p>

                </div>
            </div>
        </div>
</section>