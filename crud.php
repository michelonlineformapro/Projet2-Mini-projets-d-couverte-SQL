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
function getAllStudents(){
    $db = getPDO();
    //ICI nom n'est pas sencible à la casse palmer = PALMER
    $sql = "SELECT * FROM etudiants INNER JOIN matieres ON matieres.matiere_id = etudiants.id_matieres";
    //La variable $req stock le resultat de query qui :
    //Exécute une requête SQL, retourne un jeu de résultats en tant qu'objet PDOStatement
    $req = $db->query($sql);
    return $req;
}


?>
<h2 class="has-text-danger is-size-4">ADMINISTRATION</h2>
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
            <th>Age</th>
            <th>Matière principale</th>
            <th>Action</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $getAll = getAllStudents();
        foreach ($getAll as $row){
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
                <td><?= $row['age'] ?></td>
                <td><?= $row['nom_matiere'] ?></td>
                <td><a href="index.php?url=add_student" class="button is-success">AJOUTER</a></td>
                <td><a href="index.php?url=edit_student&id=<?= $row['id'] ?>" class="button is-info">EDITER</a></td>
                <td><a href="index.php?url=delete_student&id=<?= $row['id'] ?>" class="button is-danger">SUPPRIMER</a></td>
            </tr>
            <?php

            //var_dump($row['id_etudiant']);
        }
        ?>
        </tbody>
    </table>
</div>

