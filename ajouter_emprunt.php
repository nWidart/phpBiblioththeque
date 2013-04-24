<?php
    // On inclu la connexion
    require_once 'assets/lib/connexion.php';
    // On inclu le fichier helpers (supposé être lib)
    require_once 'assets/lib/helpers.php';

    // On récupère la liste de livres
    try {
        $sql = "SELECT * FROM ouvrages";
        $livres = $db->query( $sql );
    } catch (Exception $e) {
        echo "Erreur:".$e->getMessage();
    }

    // On récupère la liste des emprunteurs
    //
    try {
        $sql = "SELECT * FROM emprunteurs";
        $emprunteurs = $db->query( $sql );
    } catch (Exception $e) {
        echo "Erreur:".$e->getMessage();
    }
    // $date = new DateTime();
    // echo $date->format('Y-m-d H:i:s');

    // Quand le formulaire est envoyé
    //
    if ( $_POST )
    {
        // On récupère la date
        $date = new DateTime();
        // Et on insert
        try {
            $stmt = $db->prepare('INSERT INTO emprunts (ouvrage_id, emprunteur_id, date, duree) VALUES (:ouvrage_id, :emprunteur_id, :date, :duree)');
            $stmt->execute( array(
                ':ouvrage_id' => $_POST['livre'],
                ':emprunteur_id' => $_POST['emprunteur'],
                ':date' => $date->format('Y-m-d H:i:s'),
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
        <title>Ajouter un Emprunt</title>
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
                    <legend class="">Emprunter un livre</legend>
                </div>
                <div class="control-group">
                    <label class="control-label" for="livre">Livre</label>
                    <div class="controls">
                        <select id="livre" name="livre" class="input-xlarge">
                            <?php
                                foreach ( $livres->fetchAll( PDO::FETCH_ASSOC ) as $livre )
                                {
                                    echo "<option value='" . $livre['id'] . "'>" . $livre['libelle'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="emprunteur">Emprunteur</label>
                    <div class="controls">
                        <select id="emprunteur" name="emprunteur" class="input-xlarge">
                            <?php
                                foreach ( $emprunteurs->fetchAll( PDO::FETCH_ASSOC ) as $emprunteur )
                                {
                                    echo "<option value='" . $emprunteur['id'] . "'>" . $emprunteur['nom'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- Text input-->
                <div class="control-group">
                    <label class="control-label" for="duree">Durée</label>
                    <div class="controls">
                        <div id="datetimepicker4" class="input-append">
                            <input data-format="yyyy-MM-dd" type="text" name="duree" id="duree"></input>
                            <span class="add-on">
                                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                            </i>
                        </span>
                    </div>
                    <span class="help-block">Date de retour.</span>

                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success">Emprunter</button>
                    </div>
                </div>

                </fieldset>
            </form>
        </div>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
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
