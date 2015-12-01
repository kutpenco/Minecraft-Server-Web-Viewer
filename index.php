<?php

    $ip = "docker.vignat"; //IP or domain name
    $port = "25566" // Query port

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $ip; ?> - Minecraft Server</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="jumbotron-narrow.css" rel="stylesheet">
    </head>
<?php
    require __DIR__ . '/vendor/autoload.php';

    use xPaw\MinecraftQuery;
    use xPaw\MinecraftQueryException;

    $q = new MinecraftQuery();
    $e = array();

    try
    {
        $q->Connect($ip, $port);
        $info = $q->GetInfo();
        $players = $q->GetPlayers();
    }
    catch(MinecraftQueryException $exception)
    {
        $e[] = $exception->getMessage();
    }
?>
    <body>
        <br>
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted"><?php echo $ip; ?> - Minecraft Server</h3>
            </div>
            <div class="jumbotron">
<?php
    if(empty($e))
    {
?>
                <p><strong>Motd : </strong><?php echo $info['HostName'] ?></p>
                <p><strong>Game : </strong><?php echo $info['GameName'].' / '.$info['Software'].' ('.$info['Version'].')' ?></p>
                <p><strong>Players : </strong><?php echo $info['Players'].' / '.$info['MaxPlayers'] ?></p>
                <p><strong>IP:Port : </strong><?php echo $info['HostIp'].':'.$info['HostPort'] ?></p>
<?php
    }
    else
    {
        echo "<p class=\"lead\">Erreur : ".$e[0]."</p>";
    }
?>
            </div>
<?php
    if(empty($e))
    {
?>
            <hr>
            <div class="jumbotron">
                <p class="lead">
                    <strong>Players online :</strong>
                </p>
<?php
        if($info['Players'] == 0)
        { ?>
            <p>No players connected.</p>
<?php
        }
        else
        {
?>
                <div class="row">
<?php
            $size = 250;
            echo "<ul>";

            foreach ($players as $player)
            {
                echo "<div class=\"col-sm-6 col-md-4\"><div class=\"thumbnail\">";
                echo "<img src='scripts/skin.php?u=".$player."&s=".$size."' />";
                echo "<div class=\"caption\"><h3 class=\"text-center\">".$player."</h3></div>";
                echo "</div></div>";
            }
            echo "</ul></div>";
        }
        echo "</div>";
    }
?>
        </div>
        <footer class="footer">
            <div class="container text-center">
                <p>Made with <span class="glyphicon glyphicon-heart" aria-hidden="true"></span> by <a href="https://github.com/p1rox">@p1rox</a></p>
            </div>
        </footer>
  </body>
</html>
