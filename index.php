<?php
include "config/db_connection.php";
include "header.php";
$message = "";
if (isset($_POST["name"]) && isset($_POST["qte"]) && isset($_POST["etat"]) && isset($_POST["date"])) {
  $nom = $_POST["name"];
  $qte = $_POST["qte"];
  $etat = $_POST["etat"];
  $datee = $_POST["date"];
  $sql_add = "INSERT INTO iot.composant(nom,quantite,etat,date_achat) VALUES(:nom,:qte,:etat,:datee)";
  $statement_add = $connection->prepare($sql_add);
  if ($statement_add->execute([':nom' => $nom, ':qte' => $qte, ':etat' => $etat, ':datee' => $datee])) {
    $message = "data inserted successfuly";
  };
}

// Get all composants
$sql_get_all = "SELECT * FROM iot.composant";
$statement_get = $connection->prepare($sql_get_all);
$statement_get->execute();
$composants = $statement_get->fetchAll(PDO::FETCH_OBJ);

?>
<!-- Content -->
<section class="content">
  <!-- modal that contains add form -->
  <div class="modale">
    <!-- The Modal -->
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Modal Header</h2>
        </div>
        <div class="modal-body">
          <form action="index.php" method="post">
            <label for="name">Nom de Composant</label>
            <input type="text" id="name" name="name" placeholder="Entrer le nom du composant, ex:souris .." />

            <label for="qte">Quantite</label>
            <input type="text" id="qte" name="qte" placeholder="Specifier la quantite du composant, ex 18 .." />


            <label for="etat">Etat</label>
            <select id="etat" name="etat">
              <option value="disponible">Disponible</option>
              <option value="en-pane">En pane</option>
              <option value="perdu">Perdu</option>
            </select>
            <label for="qte">Date d'Achat</label>
            <input type="date" id="date" name="date" />
            <input type="submit" value="Ajouter" />
          </form>
        </div>
        <div class="modal-footer">
          <h3>Modal Footer</h3>
        </div>
      </div>
    </div>
  </div>


  <!-- search -->
  <div class="container">
    <br />
    <form method="post" action="export.php" style="text-align:center;">
      <input type="submit" name="export" class="export" style="width: 100%;" value="Export" />
    </form>
  </div>
  <div class="container">
    <?php
    if (!empty($message)) {
      include "alert_success.php";
    }
    ?>
  </div>
  <!-- affichage du composants dans la page -->
  <div class="container boxes">
    <?php foreach ($composants as $composant) : ?>
      <div class="box">
        <div class="image">
          <img src="images/souris.jpg" alt="" />
        </div>
        <div class="imformation">
          <div class="nom">
            <h3>Nom</h3>
            <p><?= $composant->nom; ?></p>
          </div>
          <div class="quantite">
            <h3>Quantite</h3>
            <p><?= $composant->quantite; ?></p>
          </div>
          <div class="etat">
            <h3>Etat</h3>
            <p><?= $composant->etat; ?></p>
          </div>
          <div class="date">
            <h3>Date d'achat</h3>
            <p><?= $composant->date_achat; ?></p>
          </div>
          <div class="buttons">
            <a class="supprimer" onclick="return confirm('Voulez vous vraiment supprimer ce composant ?')" href="delete.php?id=<?= $composant->id_composant ?>">Supprimer</a>
            <a class="modifier" href="update.php?id=<?= $composant->id_composant ?>">Modifier</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php
include "footer.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="script.js"></script>