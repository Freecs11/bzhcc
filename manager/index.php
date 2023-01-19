<?php
session_start();
include_once("../db.php");
include("inc/top.php");

$reqn = $pdo->prepare('SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = "users" AND COLUMN_NAME!="CURRENT_CONNECTIONS" AND COLUMN_NAME!="TOTAL_CONNECTIONS" AND COLUMN_NAME!="USER" AND COLUMN_NAME!="createdat"
ORDER BY ORDINAL_POSITION');

$reqn->execute();
$usersCols = $reqn->fetchAll();
$reqn->closeCursor();

$req = $pdo->prepare("SELECT * FROM users");
$req->execute();
$users = $req->fetchAll();
$req->closeCursor();
?>



<!--  debut contenu -->
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <?php
                    $req = $pdo->prepare("SELECT COUNT(*) FROM users");
                    $req->execute();
                    $resultats = $req->fetch();
                    $req->closeCursor();
                    ?>
                    <div class="card-body">Membres</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link"><?php echo $resultats[0] ?></a>
                        <a class="small text-white stretched-link" href="list_membres.php">En savoir plus</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <?php
                    $req = $pdo->prepare("SELECT COUNT(*) FROM categories");
                    $req->execute();
                    $resultats = $req->fetch();
                    $req->closeCursor();
                    ?>
                    <div class="card-body">Catégories</div>

                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link"><?php echo $resultats[0] ?></a>
                        <a class="small text-white stretched-link" href="list_categories.php">En savoir plus</a>
                        <div class="small text-white"><i class="fas fa-angle-right"> </i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <?php
                    $req = $pdo->prepare("SELECT COUNT(*) FROM annonces");
                    $req->execute();
                    $resultats = $req->fetch();
                    $req->closeCursor();
                    ?>
                    <div class="card-body">Annonces</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link"><?php echo $resultats[0] ?></a>
                        <a class="small text-white stretched-link" href="list_annonces.php">En savoir plus</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <?php
                    $req = $pdo->prepare("SELECT COUNT(*) FROM contact");
                    $req->execute();
                    $resultats = $req->fetch();
                    $req->closeCursor();
                    ?>
                    <div class="card-body">Contact</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link"><?php echo $resultats[0] ?></a>
                        <a class="small text-white stretched-link" href="list_contacts.php">En savoir plus</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">



        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Membres enregistrés
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                        <?php 
                            foreach ($usersCols as $key => $value) {
                                # code... ?>
                                <th><?php echo $value[0] ?></th>
                            <?php }
                        ?>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        <?php 
                            foreach ($usersCols as $key => $value) {
                                # code... ?>
                                <th><?php echo $value[0] ?></th>
                            <?php }
                        ?>
                        </tr>
                    </tfoot>
                    <tbody>
                        
                        <?php 
                            foreach ($users as $key => $value) {
                                # code... 
                               
                                    # code... ?>
                                <tr>
                                <td><?php echo $value['id'] ?></td>
                                <td><?php echo $value['nom'] ?></td>
                                <td><?php echo $value['prenom'] ?></td>
                                <td><?php echo $value['mail'] ?></td>
                                <td><?php echo $value['password'] ?></td>
                                <td><?php echo $value['isadmin'] ?></td>
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