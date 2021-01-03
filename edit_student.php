<?php
var_dump($_GET['id']);


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

    $db = getPDO();
    //ICI nom n'est pas sencible à la casse palmer = PALMER
    $sql = "SELECT * FROM etudiants WHERE id = ?";
    $req = $db->prepare($sql);
    $id = $_GET['id'];
    $req->bindParam(1, $id, PDO::PARAM_INT);
    $req->execute(array($id));
    $studentID = $req->fetch();

?>

<div class="form-container">
    <h1 class="has-text-danger is-size-1">Editer l'étudiant : <?= $studentID['nom'] ?></h1>
    <form action="" method="post">
        <!--NOM-->
        <div class="field">
            <label class="label">Nom</label>
            <div class="control">
                <input class="input" type="text" name="nom" placeholder="<?= $studentID['nom'] ?>">
            </div>
        </div>

        <!--PRENOM-->
        <div class="field">
            <label class="label">Prenom</label>
            <div class="control">
                <input class="input" type="text" name="prenom" placeholder="<?= $studentID['prenom'] ?>">
            </div>
        </div>

        <!--Sexe-->
        <div class="field">
            <label class="label">Sexe</label>
            <div class="control">
                <div class="select">
                    <select name="sexe">
                        <option value="<?= $studentID['sexe'] ?>">HOMME</option>
                        <option value="<?= $studentID['sexe'] ?>">FEMME</option>
                    </select>
                </div>
            </div>
        </div>

        <!--email-->
        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" name="email" placeholder="<?= $studentID['email'] ?>">
            </div>
        </div>

        <!--Departement-->
        <div class="field">
            <label class="label">Département</label>
            <div class="control">
                <input class="input" type="text" name="departement" placeholder="<?= $studentID['departement'] ?>">
            </div>
        </div>

        <div class="field">
            <label for="date_naissance">Date de naissance</label>
            <input class="input" type="date" id="date_naissance" name="date_naissance">
        </div>

        <div class="field">
            <label for="date_jour">Date de jour</label>
            <input class="input" id="date_jour" name="date_jour" type="datetime-local" value="datetime-local">
        </div>

        <!--AGE-->
        <div class="field">
            <label class="label">Age</label>
            <div class="control">
                <input class="input" type="number" name="age" placeholder="<?= $studentID['age'] ?>">
            </div>
        </div>

        <!--Sexe-->
        <div class="field">
            <label class="label">Matière principale</label>
            <div class="control">
                <div class="select">
                    <select name="id_matieres">
                        <option value="1">Mathématique</option>
                        <option value="2">Litérature</option>
                        <option value="3">Science</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="submit" class="button is-success" value="Mettre a jour" name="updateStudentBtn">
    </form>

</div>
<?php
function updateStudent(){
    $db = getPDO();

    $sql = "UPDATE etudiants SET nom = ?, prenom = ?, sexe = ?, email = ?, departement = ?, date_naissance = ?, date_jour = ?, age = ?, id_matieres = ? WHERE id = ? ";

    $req = $db->prepare($sql);
    $req->bindParam(1, $nom);
    $req->bindParam(2, $prenom);
    $req->bindParam(3, $sexe);
    $req->bindParam(4, $email);
    $req->bindParam(5, $departement);
    $req->bindParam(6, $date_naissance);
    $req->bindParam(7, $date_jour);
    $req->bindParam(8, $age);
    $req->bindParam(9, $id_matieres);

    $id = $_GET['id'];

    if(isset($_POST['nom']) && !empty($_POST['nom'])){
        $nom = $_POST['nom'];
    }
    if(isset($_POST['prenom']) && !empty($_POST['prenom'])){
        $prenom = $_POST['prenom'];
    }
    if(isset($_POST['sexe']) && !empty($_POST['sexe'])){
        $sexe = $_POST['sexe'];
    }else{
        $_POST['sexe'] = 1;
    }
    if(isset($_POST['email']) && !empty($_POST['email'])){
        $email = $_POST['email'];
    }
    if(isset($_POST['departement']) && !empty($_POST['departement'])){
        $departement = $_POST['departement'];
    }
    if(isset($_POST['date_naissance']) && !empty($_POST['date_naissance'])){
        $date_naissance = $_POST['date_naissance'];
    }
    if(isset($_POST['age']) && !empty($_POST['age'])){
        $age = $_POST['age'];
    }
    if(isset($_POST['id_matieres']) && !empty($_POST['id_matieres'])){
        $id_matieres = $_POST['id_matieres'];
    }
    if(isset($_POST['date_jour']) && !empty($_POST['date_jour'])){
        $date_jour = date('Y-m-d H:i:s');
    }
    $req->execute(array($nom, $prenom, $sexe, $email, $departement, $date_naissance, $date_jour, $age, $id_matieres, $id));
    return $req;
}

if(isset($_POST['updateStudentBtn'])){
    updateStudent();
    if($_POST){
        $msg='<script type="text/javascript">alert("L\'étudiant à bien été modifié ! ");</script>';
        echo $msg;
        echo "<a class='button is-info' href='index.php?url=crud'>Retour au CRUD</a>";
    }
}else{
    $_POST['updateStudentBtn'] = "Recommencer";
    echo "<p class='notification is-danger'>Merci de remplir tous les champs du formulaire</p>";
}

//DEBUG
var_dump($_POST['nom']);
var_dump($_POST['prenom']);
var_dump($_POST['sexe']);
var_dump($_POST['email']);
var_dump($_POST['departement']);
var_dump($_POST['date_naissance']);
var_dump($_POST['date_jour']);
var_dump($_POST['age']);
var_dump($_POST['id_matieres']);
?>
