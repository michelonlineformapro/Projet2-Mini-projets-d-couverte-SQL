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
function deleteStudent(){
    $db = getPDO();
    //Test de ternaire
    $id = (isset($_GET['id']) ? $_GET['id'] : '');
    $sql = "DELETE FROM etudiants WHERE id = ?";
    $req = $db->prepare($sql);
    $req->bindParam(1, $id);
    $req->execute(array($id));
    return $req;
}
?>
<form action="" method="post">
    <div class="field">
        <label class="label">SUPPRIMER</label>
    <input type="submit" class="button is-danger" value="confirmer la suppresion de cet étudiant" name="confirmDelete">
    </div>
</form>
<br />
<?php
if(isset($_POST['confirmDelete'])){
    deleteStudent();
    if($_POST){
        $msg='<script type="text/javascript">alert("L\'étudiant à bien été supprimer ");</script>';
        echo $msg;
        echo "<a class='button is-info' href='index.php?url=crud'>Retour au CRUD</a>";
    }
}else{
    $_POST['addStudentBtn'] = "Recommencer";
    echo "<p class='notification is-danger'>La suppression d'un étudiant est irrevocable !</p>";
}

