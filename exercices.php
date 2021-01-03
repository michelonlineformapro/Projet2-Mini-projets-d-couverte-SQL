<?php
function getPDO(){
    //PDO = instance de la classe + host + dbname + charset + user + pass
    $user = "root";
    $pass = "";
    $db = new PDO("mysql:host=localhost;dbname=utilisateurs;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p class='notification is-success'>CONNEXION A MYSQL PDO</p>";
    return $db;
}
//Afficher les etudiants qui ont le nom de famille PALMER
function getPalmer(){
    $db = getPDO();
    //ICI nom n'est pas sencible à la casse palmer = PALMER
    $sql = "SELECT * FROM etudiants WHERE nom = 'palmer'";
    //La variable $req stock le resultat de query qui :
    //Exécute une requête SQL, retourne un jeu de résultats en tant qu'objet PDOStatement
    $req = $db->query($sql);
    return $req;
}
//Afficher les etudiants qui sont des femmes
function getFemme(){
    $db = getPDO();
    $sql = "SELECT * FROM etudiants WHERE sexe = 1";
    //La variable $req stock le resultat de query qui :
    //Exécute une requête SQL, retourne un jeu de résultats en tant qu'objet PDOStatement
    $req = $db->query($sql);
    return $req;
}

//Afficher les etudiants qui habite un département qui commence par N
function getDepartementN(){
    $db = getPDO();
    $sql = "SELECT * FROM etudiants WHERE departement LIKE 'N%'";
    $req = $db->query($sql);
    return $req;
}

//Afficher les etudiants dont le mail contient google (ce n'est pas sensible à la casse google = GOOGLE)
function getEmailGoogle(){
    $db = getPDO();
    $sql = "SELECT * FROM etudiants WHERE email REGEXP 'google'";
    $req = $db->query($sql);
    return $req;
}

//Afficher les étudiants trié par departement en odre alphabetique
function getDepartementASC(){
    $db = getPDO();
    $sql = "SELECT * FROM etudiants ORDER BY departement ASC";
    $req = $db->query($sql);
    return $req;
}

//Affiche le nombre d'homme
function getHommeCount(){
    $db = getPDO();
    $sql = "SELECT COUNT(*) FROM etudiants WHERE sexe = 0";
    $req = $db->query($sql)->fetchColumn();
    return $req;
}

//Affiche le nombre de femme
function getFemmeCount(){
    $db = getPDO();
    $sql = "SELECT COUNT(*) FROM etudiants WHERE sexe = 1";
    $req = $db->query($sql)->fetchColumn();
    return $req;
}

function getAllData(){
    $db = getPDO();
    $sql = "SELECT `nom`,`prenom`,`sexe`,`email`,`departement`,`date_naissance`,`date_jour`,`age`, Year(`date_jour`) - Year(`date_naissance`) + (Format(`date_naissance`, 'mmdd') > Format(`date_jour`, 'mmdd')) FROM etudiants";
    $req = $db->query($sql);
    return $req;
}

//Matière des etudiants cle etrangère
function getMatieres(){
    $db = getPDO();
    $sql = "SELECT * FROM etudiants INNER JOIN matieres ON matieres.matiere_id = etudiants.id_matieres";
    $req = $db->query($sql);
    return $req;

}

?>


<h1 class="title has-text-centered is-size-1 has-text-primary-dark">SQL</h1>

<div>
    <?php
    $name = getPalmer();
    ?>
    <h2 class="has-text-danger is-size-4">1) Afficher tous les etudiants dont le nom est palmer.</h2>

    <div class="table-container mt-5">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
            <tr>
                <th>Etudiant ayant le nom de famille PALMER</th>
                <th>Prenom</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($name as $row){
            ?>
            <tr>
                <td><?= $row['nom'] ?></td>
                <td><?= $row['prenom'] ?></td>
            </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>

    <h2 class="has-text-danger is-size-4">2) Afficher tous les étudiants qui sont des femmes.</h2>
    <?php
    $femme = getFemme();
    ?>
    <div class="table-container mt-5">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Sexe</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($femme as $row){
                ?>
                <tr>
                    <td><?= $row['nom'] ?></td>
                    <td><?= $row['prenom'] ?></td>
                    <?php
                    //Conversion d'un booléen (0 = false et 1 = true) et assignation d'une valeur String
                    if($row['sexe'] === 0){
                        $row['sexe'] = "HOMME";
                    }else{
                        $row['sexe'] = "FEMME";
                    }
                    ?>
                    <td><?= $row['sexe'] ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php
    $departement = getDepartementN();
    ?>
    <h2 class="has-text-danger is-size-4">3) Afficher tous les etudiants qui habite un département qui commence par la lettre N.</h2>
    <div class="table-container mt-5">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Sexe</th>
                <th>Email</th>
                <th>Departement</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($departement as $row){
                ?>
                <tr>
                    <td><?= $row['nom'] ?></td>
                    <td><?= $row['prenom'] ?></td>
                    <?php
                    //Conversion d'un booléen (0 = false et 1 = true) et assignation d'une valeur String

                    if($row['sexe']){
                        $row['sexe']= "HOMME";
                    }else{
                        $row['sexe'] = "FEMME";
                    }
                    ?>
                    <td><?= $row['sexe'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['departement'] ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>


    <?php
    $google = getEmailGoogle();
    ?>
    <h2 class="has-text-danger is-size-4">4) Afficher tous les etudiants dont l'email contient le mot google.</h2>
    <div class="table-container mt-5">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Sexe</th>
                <th>Email</th>
                <th>Departement</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($google as $row){
                ?>
                <tr>
                    <td><?= $row['nom'] ?></td>
                    <td><?= $row['prenom'] ?></td>
                    <?php
                    //Conversion d'un booléen (0 = false et 1 = true) et assignation d'une valeur String

                    if($row['sexe']){
                        $row['sexe']= "HOMME";
                    }else{
                        $row['sexe'] = "FEMME";
                    }
                    ?>
                    <td><?= $row['sexe'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['departement'] ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>

    <?php
    $departementASC = getDepartementASC();
    ?>
    <h2 class="has-text-danger is-size-4">5) Afficher tous les etudiants trié par département par ordre alphabétique.</h2>
    <div class="table-container mt-5">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Sexe</th>
                <th>Email</th>
                <th>Departement</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($departementASC as $row){
                ?>
                <tr>
                    <td><?= $row['nom'] ?></td>
                    <td><?= $row['prenom'] ?></td>
                    <?php
                    //Conversion d'un booléen (0 = false et 1 = true) et assignation d'une valeur String

                    if($row['sexe']){
                        $row['sexe']= "HOMME";
                    }else{
                        $row['sexe'] = "FEMME";
                    }
                    ?>

                    <td><?= $row['sexe'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['departement'] ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>

    <h2 class="has-text-danger is-size-4">6) LE CRUD (Create, Read, Update, Delete) des etudiants</h2>
    <a href="index.php?url=crud" class="button is-warning">CRUD DES ÉTUDIANTS</a>

    <h2 class="has-text-danger is-size-4">7-A) Afficher le nombre d'homme et de femme</h2>
    <?php
    $hommeCounter = getHommeCount();
    $femmeCounter = getFemmeCount();

    echo "<p>Nombre d'homme dans la table étudiant  = ". $hommeCounter . "</p>";
    echo "<p>Nombre de femme dans la table étudiant  = ". $femmeCounter . "</p>";
    ?>


    <?php
    $allDatas = getAllData();
    ?>
    <h2 class="has-text-danger is-size-4">8-A) Afficher l'age des etudiants</h2>
    <div class="table-container mt-5">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Sexe</th>
                <th>Email</th>
                <th>Departement</th>
                <th>Date de naissance</th>
                <th>Date du jour</th>
                <th>Age</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($allDatas as $row){
                ?>
                <tr>
                    <td><?= $row['nom'] ?></td>
                    <td><?= $row['prenom'] ?></td>
                    <?php
                    //Conversion d'un booléen (0 = false et 1 = true) et assignation d'une valeur String

                    if($row['sexe']){
                        $row['sexe']= "HOMME";
                    }else{
                        $row['sexe'] = "FEMME";
                    }
                    ?>
                    <td><?= $row['sexe'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['departement'] ?></td>
                    <td><?= $row['date_naissance'] ?></td>
                    <td><?= $row['date_jour'] ?></td>
                    <?php
                    $age = (int) $row['age'];

                    ?>
                    <td><?= $row['age'] ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>

    <h2 class="has-text-danger is-size-4">8 - B) Afficher la moyenne d'age des etudiants</h2>
    <div class="table-container mt-5">

        <?php

        $db = getPDO();
        foreach($db->query('SELECT AVG(age) AS moyenne FROM etudiants') as $row) {
            echo "<p>Moyenne d'age totale :</p>";
            echo  $row['moyenne'];
        }

        foreach($db->query('SELECT AVG(`age`) AS moyenneHomme FROM etudiants WHERE sexe = 0') as $row) {
            echo "<p>Moyenne d'age des homme :</p>";
            echo  $row['moyenneHomme'];
        }

        foreach($db->query('SELECT AVG(`age`) AS moyenneFemme FROM etudiants WHERE sexe = 1') as $row) {
            echo "<p>Moyenne d'age des femmes :</p>";
            echo  $row['moyenneFemme'];
        }


        ?>
    </div>


     <h2 class="has-text-danger is-size-4">9) Afficher le nombre d'homme et de femme</h2>
    <div class="table-container mt-5">

            <?php

                $db = getPDO();
            foreach($db->query('SELECT COUNT(*) AS nombreHomme FROM etudiants WHERE sexe = 0') as $row) {
                echo "<p>Nombre d'homme :</p>";
                echo  $row['nombreHomme'];
            }
            foreach($db->query('SELECT COUNT(*) AS nombreFemme FROM etudiants WHERE sexe = 1') as $row) {
                echo "<p>Nombre d'homme :</p>";
                echo  $row['nombreFemme'];
            }
            ?>
    </div>



    <h2 class="has-text-danger is-size-4">10) Afficher la matière principale des étudiants</h2>
    <div class="table-container mt-5">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Matière principale</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $matiere = getMatieres();
            foreach ($matiere as $row){
                ?>
                <tr>
                    <td><?= $row['nom'] ?></td>
                    <td><?= $row['prenom'] ?></td>
                    <td><?= $row['nom_matiere'] ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>

    <h2 class="has-text-danger is-size-4">11) Afficher les données de l'etudiants numéro 9</h2>
    <div class="table-container mt-5">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Sexe</th>
                <th>Email</th>
                <th>Departement</th>
                <th>Date de naissance</th>
                <th>Date du jour</th>
                <th>Age</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($db->query('SELECT * FROM etudiants WHERE id = 9') as $row){
                ?>
                <tr>
                    <td><?= $row['nom'] ?></td>
                    <td><?= $row['prenom'] ?></td>
                    <?php
                    //Conversion d'un booléen (0 = false et 1 = true) et assignation d'une valeur String

                    if($row['sexe']){
                        $row['sexe']= "HOMME";
                    }else{
                        $row['sexe'] = "FEMME";
                    }
                    ?>
                    <td><?= $row['sexe'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['departement'] ?></td>
                    <td><?= $row['date_naissance'] ?></td>
                    <td><?= $row['date_jour'] ?></td>
                    <?php
                    $age = (int) $row['age'];

                    ?>
                    <td><?= $row['age'] ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>


</div>
