<?php
include("inc/top.php");
include_once("../db.php");
$reqn = $pdo->prepare('SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = "users" AND COLUMN_NAME!="CURRENT_CONNECTIONS" AND COLUMN_NAME!="TOTAL_CONNECTIONS" AND COLUMN_NAME!="isadmin"
AND COLUMN_NAME!="USER"  AND COLUMN_NAME!="created_at"  AND COLUMN_NAME!="password"  AND COLUMN_NAME!="mail" AND COLUMN_NAME!="id" AND COLUMN_NAME!="createdat"
ORDER BY ORDINAL_POSITION');

$reqn->execute();
$usersCols = $reqn->fetchAll();
$reqn->closeCursor();



if(isset($_GET['msg'])){
    if($_GET['msg']=='yes'){
        $msg = 'SUCCESSFULLY Deleted !';
    }else{
        $msg = 'Oops! Something went wrong. Please try again later.';
    }
}else {
$msg="Message de l'action.";
}
?>



<!--  debut contenu -->
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Admins</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Admins</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <a href="ajout_admin.php">Ajouter un admin</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
            <?php
                            echo $msg;
                            ?>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Admins
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <?php
                                foreach ($usersCols as $key => $value) {
                                    # code... 
                                ?>
                                    <th><?php echo $value[0] ?></th>
                                <?php }
                                ?>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <?php
                                foreach ($usersCols as $key => $value) {
                                    # code... 
                                ?>
                                    <th><?php echo $value[0] ?></th>
                                <?php }
                                ?>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </tr>
                        </tfoot>
                        <tbody>

                        <?php
                        $req = $pdo->prepare("SELECT * FROM users WHERE isadmin=TRUE");
                        $req->execute();
                        $users = $req->fetchAll();
                        $req->closeCursor();
                        foreach ($users as $key => $value) {
                            # code... 

                            # code... 
                        ?>
                            <tr>
                                <td><?php echo $value['nom'] ?></td>
                                <td><?php echo $value['prenom'] ?></td>
                                <td><a href="modif_admin.php?id=<?php echo $value['id'] ?>">Modifier</a></td>
                                <td><a href="delete_user.php?id=<?php echo $value['id'] ?>">Supprimer</a></td>
                            </tr>
                        <?php }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- fin contenu -->


<?php
include("inc/bottom.php");
?>