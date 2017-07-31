<?php
error_reporting(-1);

require_once 'wss/soap-wsse.php';
require_once 'wss/soap-validation.php';
require_once 'wss/WebpayService.php';

define('SERVER_CERT', 'tbk.pem');

$result = false;
$token = $_POST['token_ws'];

/* Acá se mostrará el resultado de la transacción */

$webpayService = new WebPayService("https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl");
$getTransactionResult = new getTransactionResult();
$getTransactionResult->tokenInput = $token;
$getTransactionResultResponse = $webpayService->getTransactionResult($getTransactionResult);
$xmlResponse = $webpayService->soapClient->__getLastResponse();
$soapValidation = new SoapValidation($xmlResponse, SERVER_CERT);
$validationResult = $soapValidation->getValidationResult();
$validationResult = true;
if ($validationResult) {
	/* Validación de firma correcta */
	$result = true;
	$transactionResultOutput = $getTransactionResultResponse->return;
	$url = $transactionResultOutput->urlRedirection;
	$wsTransactionDetailOutput = $transactionResultOutput->detailOutput;
	$authorizationCode = $wsTransactionDetailOutput->authorizationCode;
	$paymentTypeCode = $wsTransactionDetailOutput->paymentTypeCode;
	$responseCode = $wsTransactionDetailOutput->responseCode;
	$sharesNumber = $wsTransactionDetailOutput->sharesNumber;
	$amount = $wsTransactionDetailOutput->amount;
	$commerceCode = $wsTransactionDetailOutput->commerceCode;
	$buyOrder = $wsTransactionDetailOutput->buyOrder;

	if ($wsTransactionDetailOutput->responseCode == 0) {
		/* Esto indica que la transacción está autorizada */
	}

	$acknowledgeTransaction = new acknowledgeTransaction();
	$acknowledgeTransaction->tokenInput = $token;
	$acknowledgeTransactionResponse = $webpayService->acknowledgeTransaction($acknowledgeTransaction);
}
?>

<html>
    <head>
        <title>Resultado de Transacci&oacute;n</title>
    </head>
    <body>
        <?php if ($result) {?>
            <fieldset>
                <legend><b>Resultado de Transacci&oacute;n</b></legend>
                C&oacute;digo Autorizaci&oacute;n: <?php echo $authorizationCode ?><br />
                Tipo de Pago C&oacute;digo: <?php echo $paymentTypeCode ?><br />
                C&oacute;digo de respuesta: <?php echo $responseCode ?><br />
                N&uacute;mero de acciones: <?php echo $sharesNumber ?><br />
                Cantidad: <?php echo $amount ?><br />
                C&oacute;digo de Comercio: <?php echo $commerceCode ?><br />
                Orden de compra: <?php echo $buyOrder ?>
            </fieldset>
            <form method="post" action="<?php echo $url ?>">
                <input type="hidden" name="token_ws" value="<?php echo $token ?>" />
                <input type="submit" name="acknowledge" value="Continuar" />
            </form>
        <?php } else {?>
            <h2>Validaci&oacute;n incorrecta de firma</h2>
        <?php }?>
    </body>
</html>
