<?php
    // On inclu la connexion
    require_once 'assets/lib/connexion.php';
    // On inclu le fichier helpers (supposé être lib)
    require_once 'assets/lib/helpers.php';

    // Si pas de variable GET on redirige vers l'index.
    //
    if ( !isset( $_GET['id'] ) ) header('Location: index.php');
    $id = $_GET['id'];
    // On sélectionne l'emprunt en question
    try {
        $sql = "SELECT * FROM emprunts WHERE id=$id";
        $res = $db->query( $sql );
        $emprunt = $res->fetch();
    } catch (Exception $e) {
        echo "Erreur:".$e->getMessage();
    }

    // Quand le formulaire est envoyé
    //
    if ( $_POST )
    {
        try {
            $stmt = $db->prepare('UPDATE emprunts SET duree = :duree WHERE id = :id');
            $stmt->execute( array(
                ':id' => $id,
                ':duree' => $_POST['duree']
            ) );
            // Si on a bien mit à jour un row on redirect
            if ( $stmt->rowCount() )
                header('Location: index.php');
        } catch (Exception $e) {
            echo "Erreur:".$e->getMessage();
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Mettre à jour un Emprunt</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <style>
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
        </style>
        <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="assets/js/html5shiv.js"></script>
        <![endif]-->
    </head>

  <body>
    <?php require 'assets/_partials/navigation.php'; ?>
    <div class="container">
        <div class="row-fluid">
            <form class="form-horizontal" method="post" action="">
                <fieldset>
                <div id="legend">
                    <legend class="">Prolonger livre</legend>
                </div>
                <div class="control-group">
                    <label class="control-label" for="duree">Nouvelle date de retour</label>
                    <div class="controls">
                        <div id="datetimepicker4" class="input-append">
                            <input data-format="yyyy-MM-dd" type="text" name="duree" id="duree" value="<?php echo $emprunt['duree']; ?>"></input>
                            <span class="add-on">
                                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                            </i>
                        </span>
                    </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success">Prolonger</button>
                    </div>
                </div>

                </fieldset>
            </form>
        </div>
    </div> <!-- /container -->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript">
      $(function() {
        $('#datetimepicker4').datetimepicker({
          pickTime: false
        });
      });
    </script>

  </body>
</html>
