<html>
  <header>
    <title>Welcome to my demo app!</title>
  </header>
  <body>
    <?php
      $label1 = "Cats";
      $label2 = "Dogs";
      $question = "What do you like better?";
    ?>

   <?php
    $page = $_SERVER['PHP_SELF'];
    $sec = "2";
    header("Refresh: $sec; url=$page");
   ?>



    <h1>Welcome to my demo app!</h1>
    <h2>Container information</h2>
      <ul>
          <li>IP: <?php print $_SERVER['SERVER_ADDR']; ?></li>
          <li>Kernel info: <?php print exec('uname -a'); ?></li>

          <?php
            // Determine the host running the DB. Check the environment variable SQLSERVER, and if it does
            // not exist, default to "sqlserver"
            $sqlHost = getenv('SQLSERVER');
            if (strlen($sqlHost)>1) {
              echo "<li>SQLSERVER environment variable found with value: " . $sqlHost . "</li>\n";              
            } else {
              $sqlHost = "sqlserver";
              echo "<li>SQLSERVER environment variable not defined, defaulting to 'sqlserver'</li>\n";
            }
          ?>
            
          <?php
              $sqlVersion = exec ("/root/getSqlVersion.sh " . $sqlHost . " 2>/dev/null");
              if (strlen($sqlVersion)>1) {
                echo "<li>SQL Server Version (" . $sqlHost . "): " . $sqlVersion . "</li>\n";
              } else {
                echo "<li>SQL Server version from " . $sqlHost . " could not be retrieved</li>\n";
              }
          ?>
      </ul>

      <?php
          // Increase the corresponding counter if this page was called from the buttons at the end (if the method is a POST)
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST["voteOption1"] == "true") {
              exec ("/root/incCounter.sh 1 " . $sqlHost);
            }
            if ($_POST["voteOption2"] == "true") {
              exec ("/root/incCounter.sh 2 " . $sqlHost);
            }
          }
     ?>

    <h2>Query to the DB</h2>
    <?php
        // Try to increase one of the counters, to see if the DB is there
        $value1 = exec("/root/getCounter.sh 1 " . $sqlHost . " 2>/dev/null");
        if (strlen($value1) < 1) {
          echo "<p>Initializing database...</p>\n";
          usleep (500);
          exec("/root/createDB.sh " . $sqlHost);
          usleep (500);
          $value1 = exec("/root/getCounter.sh 1 " . $sqlHost . " 2>/dev/null");
        }
        $value2 = exec("/root/getCounter.sh 2 " . $sqlHost . " 2>/dev/null");
        if (strlen($value2) < 1) {
          echo "<p>Counters could not be retrieved from the database</p>\n";
        } else {
          echo "<p>" . $question . "</p>\n";
          echo "<ul>\n";
          echo " <li>" . $label1 . ": " . $value1 . "</li>\n";        
          echo " <li>" . $label2 . ": " . $value2 . "</li>\n";        
          echo "</ul>\n";
        }
?>

    <h2>Vote</h2>
      <?php echo "<p>" . $question . "</p>\n"; ?>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="voteOption1" value="true">
        <input type="submit" value="<?php echo $label1; ?>">
      </form>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="voteOption2" value="true">
        <input type="submit" value="<?php echo $label2; ?>">
      </form>

  </body>
</html>