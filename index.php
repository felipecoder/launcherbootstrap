<?php
require 'config.php';
$driver = getenv('MSSQL_DRIVER');
$host   = getenv('MSSQL_HOST');
$port   = getenv('MSSQL_PORT');
$user   = getenv('MSSQL_USER');
$pass   = getenv('MSSQL_PASS');
$dbname = getenv('MSSQL_DBNAME');

switch ($driver) {
  case 'odbc':
    $dsn = "odbc:Driver={SQL Native Client};Server={$host};Port={$port};Database={$dbname}; Uid={$user};Pwd={$pass};";
    $pdo = new PDO($dsn);
    break;
  case 'sqlsrv':
    $dsn = "{$driver}:server={$host},{$port};Database={$dbname}";
    $pdo = new PDO($dsn, $user, $pass);
    break;
  case 'dblib':
    $dsn = "{$driver}:host={$host}:{$port};dbname={$dbname}";
    $pdo = new PDO($dsn, $user, $pass);
    break;

  default:
    $dsn = "{$driver}:server={$host},{$port};Database={$dbname}";
    $pdo = new PDO($dsn, $user, $pass);
    break;
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

?>
  <!DOCTYPE html>
  <html lang="pt-br">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Launcher MuOnline</title>
    <!--Bootstrap-->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <!--Custom CSS-->
    <link rel="stylesheet" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
  </head>

  <body>
    <div class="col-md-3">
      <h2>Informações</h2>
      <ul class="info">
        <li>Status:
          <?php
          if (@fsockopen(getenv("SERVER_IP"), getenv("SERVER_PORT"), $errno, $errstr, 1)) {
            echo '<span class="label label-success">Online</span>';
          } else {
            echo '<span class="label label-danger">Offline</span>';
          }
          ?>

        </li>
        <li>Total Online:
          <span class="label label-success">
            <?php
            $totalonline = $pdo->prepare("SELECT count(*) FROM MEMB_STAT WHERE Connectstat = 1");
            $totalonline->execute();
            $totalonline = $totalonline->fetchColumn();
            echo $totalonline;
            ?>
          </span>
        </li>
        <li>Total de Contas:
          <span class="label label-primary">
            <?php
            $totalaccounts = $pdo->prepare("SELECT count(*) FROM MEMB_INFO");
            $totalaccounts->execute();
            $totalaccounts = $totalaccounts->fetchColumn();
            echo $totalaccounts;
            ?>
          </span>
        </li>
        <li>Total de Personagens:
          <span class="label label-primary">
            <?php
            $totalcharacters = $pdo->prepare("SELECT count(*) FROM Character");
            $totalcharacters->execute();
            $totalcharacters = $totalcharacters->fetchColumn();
            echo $totalcharacters;
            ?>
          </span>
        </li>
      </ul>

      <h2>Noticias</h2>
      <ul class="news">
        <?php
        $news = $pdo->prepare("SELECT TOP 5 title, slug FROM mw_news ORDER BY id DESC");
        $news->execute();
        $news = $news->fetchAll(PDO::FETCH_ASSOC);
        foreach ($news as $key => $value) {
          echo "<li><a href='" . getenv("SITE_LINK") . "index.php/news/" . $value['slug'] . "'>" . $value['title'] . "</a></li>";
        }
        ?>
      </ul>
    </div>
    <div class="col-md-9">
      <ul class="menu">
        <li parent="home" class='active'>
          <a href="javacript:void(0);" class="btn btn-primary">Home</a>
        </li>
        <li parent="events">
          <a href="javacript:void(0);" class="btn btn-primary">Eventos</a>
        </li>
        <li parent="promo">
          <a href="javacript:void(0);" class="btn btn-primary">Promoções</a>
        </li>
      </ul>

      <div id="home" class="disabled active">

        <!--Slide-->
        <div id="slide" class="carousel slide" data-ride="carousel">
          <!-- Content -->
          <div class="carousel-inner" role="listbox">

            <!-- Slide 0 -->
            <div class="item active">
              <img src="http://muwebonline.net/templates/muox/assets/images/slides/slide01.jpg">
            </div>
            <!-- Slide 1 -->
            <div class="item">
              <img src="https://joguemuonline.uol.com.br/themes/landingpage/img/section-features/items.jpg">
            </div>

          </div>

          <!-- Previous/Next controls -->

          <a class="left carousel-control" href="#slide" data-slide="prev">
            <i class="glyphicon glyphicon-chevron-left"></i>
          </a>
          <a class="right carousel-control" href="#slide" data-slide="next">
            <i class="glyphicon glyphicon-chevron-right"></i>
          </a>
        </div>
      </div>
      <div id="events" class="disabled">
        <ul class="events"></ul>
      </div>

      <div id="promo" class="disabled">
        <!--Promoções-->
        <div id="slide" class="carousel slide" data-ride="carousel">
          <!-- Content -->
          <div class="carousel-inner" role="listbox">

            <!-- Slide 0 -->
            <div class="item active">
              <img src="http://muwebonline.net/templates/muox/assets/images/slides/slide01.jpg">
            </div>
            <!-- Slide 1 -->
            <div class="item">
              <img src="https://joguemuonline.uol.com.br/themes/landingpage/img/section-features/items.jpg">
            </div>

          </div>

          <!-- Previous/Next controls -->

          <a class="left carousel-control" href="#slide" data-slide="prev">
            <i class="glyphicon glyphicon-chevron-left"></i>
          </a>
          <a class="right carousel-control" href="#slide" data-slide="next">
            <i class="glyphicon glyphicon-chevron-right"></i>
          </a>
        </div>
      </div>
      <!--Bootstrap-->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
      <!--Events-->
      <script src="assets/js/events.js"></script>
      <!--Custom JS-->
      <script src="assets/js/custom.js"></script>
      <script>
        var events = [
          ["Chaos Castle", ["01:00", "03:00", "05:00", "07:00", "09:00", "11:00", "13:00", "15:00", "17:00", "19:00", "21:00", "23:00"]],
          ["Devil Square", ["00:30", "04:30", "08:30", "12:30", "16:30", "20:30"]],
          ["Blood Castle", ["00:00", "03:00"]],
          ["Castle Deep", ["01:00", "04:00", "08:00"]],
          ["Teste", ["21:42", "21:47", "21:52", "21:57", "22:02", "22:07", "22:12", "22:17", "22:22"]]
        ];
        getEvents('.events', events);
      </script>
  </body>

  </html>