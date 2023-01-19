<?php
include("inc/top.php");
include_once("../db.php");
$reqn = $pdo->prepare('SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = "annonces" AND COLUMN_NAME!="CURRENT_CONNECTIONS" AND COLUMN_NAME!="image" AND COLUMN_NAME!="TOTAL_CONNECTIONS" AND COLUMN_NAME!="USER"
ORDER BY ORDINAL_POSITION');

$reqn->execute();
$annoncesCols = $reqn->fetchAll();
$reqn->closeCursor();

$req = $pdo->prepare("SELECT * FROM annonces");
$req->execute();
$annonces = $req->fetchAll();
$req->closeCursor();

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
        <h1 class="mt-4">Annonces</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Annonces</li>
        </ol>

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
                Annonces
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <?php
                                foreach ($annoncesCols as $key => $value) {
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
                                foreach ($annoncesCols as $key => $value) {
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
                        foreach ($annonces as $key => $value) {
                        ?>
                            <tr>
                                <td><?php echo $value['annonceId'] ?></td>
                                <td><?php echo $value['title'] ?></td>
                                <td><?php echo $value['price'] ?> $</td>
                                <td><?php echo $value['description'] ?></td>
                                <td><?php echo getCategorieName($value['categorie']) ?></td>
                                <td><?php echo $value['createdat'] ?></td>
                                <td><?php echo $value['userId'] ?></td>
                                <td><a href="modif_annonce.php?id=<?php echo $value['annonceId'] ?>">Modifier</a></td>
                                <td><a href="delete_annonce.php?id=<?php echo $value['annonceId'] ?>">Supprimer</a></td>
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