<?php
    // On inclu la connexion
    require_once 'assets/lib/connexion.php';
    // On inclu le fichier helpers (supposé être lib)
    require_once 'assets/lib/helpers.php';

    try {
        $sql = "SELECT e.id,date,duree,libelle,genre,nom,prenom,telephone,mail,em.id as emprunteur_id FROM emprunts as e INNER JOIN ouvrages as o ON e.`ouvrage_id` = o.`id` INNER JOIN emprunteurs as em ON e.`emprunteur_id` = em.`id`";
        $emprunts = $db->query( $sql );
    } catch (Exception $e) {
        echo "Erreur:".$e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Liste des Emprunts</title>
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

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="assets/js/html5shiv.js"></script>
        <![endif]-->
    </head>

  <body>
    <?php require 'assets/_partials/navigation.php'; ?>
    <div class="container">
        <div class="row-fluid">
            <h1>Liste d'emprunts</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Livre</th>
                        <th>Genre</th>
                        <th>Emprunteur (tel)</th>
                        <th>Date limite</th>
                        <th></th>
                        <th style="width: 36px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $emprunts->fetchAll( PDO::FETCH_ASSOC ) as $emprunt ) : ?>
                    <tr>
                        <td><?php echo $emprunt['libelle']; ?></td>
                        <td><?php echo $emprunt['genre']; ?></td>
                        <td><?php echo $emprunt['prenom'] . ' ' . $emprunt['nom'] . ' (' . $emprunt['telephone'] . ')'; ?></td>
                        <td class="<?php echo ( isOverdue( $emprunt['duree'] ) ) ? 'text-error' : ''; ?>">
                            <?php echo $emprunt['duree']; ?>
                        </td>
                        <td>
                            <?php if ( isOverdue( $emprunt['duree'] ) ) echo '<a href="assets/lib/sendMail.php?mail=' . $emprunt['mail'] . '" class="btn btn-warning">Envoyer email de rappel</a>'; ?>
                        </td>
                        <td>
                        <a href="update.php?id=<?php echo $emprunt['id']; ?>"><i class="icon-pencil"></i></a>
                        <a href="assets/lib/delete.php?id=<?php echo $emprunt['id']; ?>" role="button"><i class="icon-remove"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div> <!-- /container -->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
</html>
