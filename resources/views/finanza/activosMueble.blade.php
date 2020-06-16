S/. 
    <?php 
        if ($totalInventario[0]->total == null) {
            echo("0.00");
        }else {
            echo($totalInventario[0]->total);
        }
    ?>