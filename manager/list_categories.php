<?php
include_once("../db.php");
include("inc/top.php");

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
                        <h1 class="mt-4">Catégories</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Catégories</li>
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
                                Catégories
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Numéro</th>
                                            <th>Nom</th>
                                            <th>Modifier</th>
                                            <th>Supprimer</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Numéro</th>
                                            <th>Nom</th>
                                            <th>Modifier</th>
                                            <th>Supprimer</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $req = $pdo -> prepare("SELECT * FROM categories");
                                        $req -> execute();
                                        $resultats = $req->fetchAll();
                                        $req -> closeCursor(); 
                                        foreach ($resultats as $key => $value) {
                                            # code... ?>
                                            <tr>
                                            <td><?php echo $value['id'] ?></td>
                                            <td><?php echo $value['NAME'] ?></td>
                                            <td><a href="modif_categorie.php?id=<?php echo $value['id'] ?>">Modifier</a></td>
                                            <td><a href="delete_categorie.php?id=<?php echo $value['id'] ?>">Supprimer</a></td>
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
