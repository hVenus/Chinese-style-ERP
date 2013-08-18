<?php
include_once( "inc/auth.php" );
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="/theme/9/style.css" />
    <link rel="stylesheet" type="text/css" href="/theme/9/mytable.css" />
</head>
<body>
<table style="width: 100%; margin-right:2px;; min-width: 1000px; ">
    <tr>
        <td>
            <?php include('../sale_list.php'); ?>
        </td>
        <td>
            <?php include('../inventory.php'); ?>
        </td>
    </tr>
</table>



</body>
</html>