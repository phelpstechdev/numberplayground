<?php
include_once("connect.php");
include_once("data.php");

$data = new Data;

if (isset($_GET['search'])) {
  if ($_GET['search'] == "game") {
    if (isset($_GET['value'])) {
      $searchResults = $data->getGamesBySearch($_GET['value']);
      foreach ($searchResults as $game) {
        ?>
        <a href="javascript:addGame(<?php echo $game['id']; ?>)" class="no-text-decoration text-dark">
          <div class="chip">
              <img src="../../images/<?php echo $game['image']; ?>">
              <?php echo $game['name']; ?>
          </div>
        </a>
        <?php
      }
    }
  }
}

if (isset($_GET['list'])) {
  if ($_GET['value']) {
    $items = explode(", ", $_GET['value']);
    foreach ($items as $item) {
      $game = $data->getGameById($item);
      ?>
      <a href="javascript:removeGame(<?php echo $game['id']; ?>)" class="no-text-decoration text-dark">
        <div class="chip">
            <img src="../../images/<?php echo $game['image']; ?>">
            <?php echo $game['name']; ?>
        </div>
      </a>
      <?php
    }
  }
}

 ?>
