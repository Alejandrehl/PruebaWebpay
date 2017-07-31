<?php
error_reporting(-1);
$commerceId = '597020000541';
$buyOrder = '12345';
$sessionId = '12334466';

$returnUrl = "http://localhost/web/resultado.php";
$finalUrl = "http://localhost/web/final.php";
$commerceCode = '597020000541';
$amount = '1990';
$shareNumber = '';
$shareAmount = '';
?>
<html>
    <head>
        <title>Prueba WS - Datos de Entrada y datos de salida</title>
    </head>
    <body>
        <fieldset>
            <legend><b>Datos de Transacci&oacute;n</b></legend>
            <form method="post" action="action.php">
                <table>
                    <tr>
                        <td><label for="commerceId">ID Comercio</label></td>
                        <td><input id="commerceId" type="text" name="commerceId" value="<?php echo $commerceId ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="buyOrder">Orden de Compra</label></td>
                        <td><input id="buyOrder" type="text" name="buyOrder" value="<?php echo $buyOrder ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="sessionId">ID Session</label></td>
                        <td><input id="sessionId" type="text" name="sessionId" value="<?php echo $sessionId ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="returnUrl">Url Retorno</label></td>
                        <td><input id="returnUrl" type="text" name="returnUrl" value="<?php echo $returnUrl ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="finalUrl">Url Final</label></td>
                        <td><input id="finalUrl" type="text" name="finalUrl" value="<?php echo $finalUrl ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="commerceCode">Codigo Comercio</label></td>
                        <td><input id="commerceCode" type="text" name="commerceCode" value="<?php echo $commerceCode ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="amount">Cantidad</label></td>
                        <td><input id="amount" type="text" name="amount" value="<?php echo $amount ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="shareNumber">Share Number</label></td>
                        <td><input id="shareNumber" type="text" name="shareNumber" value="<?php echo $shareNumber ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="shareAmount">Share Amount</label></td>
                        <td><input id="shareAmount" type="text" name="shareAmount" value="<?php echo $shareAmount ?>" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="enviar" value="Enviar" /></td>
                    </tr>
                </table>
            </form>
        </fieldset>

    </body>
</html>
