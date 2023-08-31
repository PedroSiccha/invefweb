S/. 
    <?php 
        if ($totalInventario->total == null) {
            echo("0.00");
        }else {
            echo($totalInventario->total);
        }
    ?>