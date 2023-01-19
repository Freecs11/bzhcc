<?php
require("sendgrid/sendgrid-php.php");
session_start();
include("inc/top.php");
$SENDGRID_API_KEY = 'snedgrid_API_KEY here';
$favs = $_SESSION['favoris'];
$site = file_get_contents("favoris.php");
$number = 1;
$strl = "";
foreach ($favs as $key => $value) {
?>
    <?php $strl .= '<div class="ser-grid-list">'; ?>
    <?php $strl .=    '<h5>' . $value["title"] . '</h5>'; ?>
    <?php $strl .=     '<img alt="" src="images/' . $value["image"] . '>'; ?>
    <?php $strl .=    '<p>' . $value["description"] . '</p>'  ?>
    <?php $strl .=  '</div>' ?>
<?php $number++;
    if ($number % 3 == 1) {
        $strl .= '<div class="clear"></div>';
    }
}

$va = '
<html>
<head>
  <title>Favs</title>
</head>
<body>
<div class="main">
<div class="ser-main">

    
       ' . $strl . '
</div>
<div class="clear"></div>

</body>
</html>
';
?>
<?php

if (!isset($_POST["submit"])) {

?>

    <div class="col span_2_of_4">
        <div class="contact-form">
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                To: <input type="text" name="to"><br>
                <input type="submit" name="submit" value="Click To send mail">
            </form>
        </div>
    </div>
        <?php
    } else {

        if (isset($_POST['to'])) {
            $to      = $_POST['to'];
            $subject = 'Sending favs';
            $message = $va;

            $email = new \SendGrid\Mail\Mail();
            $email->setFrom("rachid.bouhmad@etudiant.univ-rennes1.fr", "Rachid");
            $email->setSubject("Used Sengrid for this");
            $email->addTo($to, "From $to");
            $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
            $email->addContent(
                "text/html",
                $message
            );
            $sendgrid = new SendGrid($SENDGRID_API_KEY);
            try {
                $response = $sendgrid->send($email);
                header('location: favoris.php');
            } catch (Exception $e) {
                echo 'Caught exception: ' . $e->getMessage() . "\n";
                header('location: favoris.php');
            }
        }
    }
      
   
    ?>
