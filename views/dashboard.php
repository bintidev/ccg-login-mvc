<?php

//include 'config/secure-session.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Dashboard</title>
      <link rel="shortcut icon" href="public/img/favicon.ico" type="image/x-icon">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <link rel="stylesheet" href="public/css/dashboard-style.css">
  </head>
  <body>

      <?php include 'templates/header.php'; ?>

      <!-- Content -->
      <main class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
        <div>
          <h1 class="mb-4 text-white text-center fw-bold">
            <span id="welcome" class="fst-italic">Welcome back,</span> 
            <?php echo $_SESSION['idusuario'] ?>
          </h1>
          <div class="mb-5 p-3" id="reminder">
            <p>
              Even if it costs you your arms and legs, you must fight.
            </p>
          </div>
          <div class="d-flex justify-content-center align-items-center">
            <a class="btn btn-primary fs-6 w-25 p-3" href="index.php?action=logout" id="logout-btn">Logout</a>
          </div>
        </div>
      </main>

      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>

  </body>
</html>