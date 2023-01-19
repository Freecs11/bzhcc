<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="assets/demo/chart-pie-demo.js"></script>
<?php
session_start();
include_once("../db.php");
include("inc/top.php");

$reqn = $pdo->prepare('SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = "users" AND COLUMN_NAME!="CURRENT_CONNECTIONS" AND COLUMN_NAME!="TOTAL_CONNECTIONS" AND COLUMN_NAME!="USER"
ORDER BY ORDINAL_POSITION');

$reqn->execute();
$usersCols = $reqn->fetchAll();
$reqn->closeCursor();

$req = $pdo->prepare("SELECT * FROM users");
$req->execute();
$users = $req->fetchAll();
$req->closeCursor();

// categorie with the most announces
$req = $pdo->prepare("SELECT COUNT(*) AS nb, categorie FROM annonces GROUP BY categorie ORDER BY nb DESC LIMIT 1");
$req->execute();
$categorieMax = $req->fetch();
$req->closeCursor();

// categorie with the least announces
$req = $pdo->prepare("SELECT COUNT(*) AS nb, categorie FROM annonces GROUP BY categorie ORDER BY nb ASC LIMIT 1");
$req->execute();
$categorieMin = $req->fetch();
$req->closeCursor();


// oldest announce 
$req = $pdo->prepare("SELECT * FROM annonces ORDER BY createdat ASC LIMIT 1");
$req->execute();
$oldest = $req->fetch();
$req->closeCursor();

// top 10 users with the most announces 
$req = $pdo->prepare("SELECT COUNT(*) AS nb, userId FROM annonces GROUP BY userId ORDER BY nb DESC LIMIT 10");
$req->execute();
$top10 = $req->fetchAll();
$req->closeCursor();

function getUserName($userId) {
    global $users;
    foreach ($users as $user) {
        if ($user['id'] == $userId) {
            return $user['nom'];
        }
    }
}

//categorie with the  highest average price
$req = $pdo->prepare("SELECT AVG(price) AS moyenne, categorie FROM annonces GROUP BY categorie ORDER BY moyenne DESC LIMIT 1");
$req->execute();
$categorieprixAVG = $req->fetch();
$req->closeCursor();

// categories with the number of annonces over the month in ascending order as [Catégorie, Nombre d'annonces] to put in a chart 
$req = $pdo->prepare("SELECT categorie, COUNT(*) AS nb FROM annonces WHERE createdat > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY categorie ORDER BY nb ASC");
$req->execute();
$categorieNb = $req->fetchAll();
$req->closeCursor();

$max = 0;
foreach($categorieNb as $categorie) {
    $max = max($categorie['nb'],$max);
}

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
        <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header"> Categorie with the most announces is :  </div>
                    <div class="card-body"> <?php echo getCategorieName($categorieMax['categorie']) ?> with <?php echo $categorieMax['nb'] ?> announces</div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header"> Categorie with the least announces is :  </div>
                    <div class="card-body">  <?php echo getCategorieName($categorieMin['categorie']) ?> with <?php echo $categorieMin['nb'] ?> announces
</div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header"> Oldest annonce :  </div>
                    <div class="card-body"> <?php echo $oldest['title'] . '  , created at : '. $oldest['createdat']  ?> </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header"> TOP 10 users :   </div>
                    <div class="card-body"> <?php 
                    // print the top 10 in a ul 
                    foreach($top10 as $user) {
                        echo '<ul>';
                        echo '<li>'.getUserName($user['userId']).' : '.$user['nb'].' announces</li>';
                        echo '</ul>';
                    }
                    
                    ?> </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header"> Category with the highest average price : </div>
                    <div class="card-body"> 
                    <?php  
                    echo getCategorieName($categorieprixAVG['categorie']).' whith the avg of : '.$categorieprixAVG['moyenne'].' €';
                    ?>        
                </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Annonces</div>
                    <div class="card-body"><canvas id="mychart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
        <script>
            // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("mychart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
      // print the categories as labels
    labels: [<?php foreach($categorieNb as $categorie) { echo '"'.getCategorieName($categorie['categorie']).'",'; } ?>],
    datasets: [{
      label: "Nombre d'annonces",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
        data: [<?php foreach($categorieNb as $categorie) { echo $categorie['nb'].','; } ?>],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: <?php echo $max ?>,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
        </script>

    </div>
</main>

<!-- fin contenu -->

<?php
include("inc/bottom.php");
                            
?>