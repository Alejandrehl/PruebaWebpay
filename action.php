<?php
error_reporting(-1);

require_once 'wss/soap-wsse.php';
require_once 'wss/soap-validation.php';
require_once 'wss/WebpayService.php';

define('SERVER_CERT', 'tbk.pem');

$transactionType = 'TR_NORMAL_WS';

$commerceId = $_POST["commerceId"];
$buyOrder = $_POST["buyOrder"];
$sessionId = $_POST["sessionId"];
$returnUrl = $_POST["returnUrl"];
$finalUrl = $_POST["finalUrl"];
$commerceCode = $_POST["commerceCode"];
$amount = $_POST["amount"];
$shareNumber = $_POST["shareNumber"];
$shareAmount = $_POST["shareAmount"];

$wsInitTransactionInput = new wsInitTransactionInput();
$wsTransactionDetail = new wsTransactionDetail();

/* Variables de tipo string */
$wsInitTransactionInput->wSTransactionType = $transactionType;
$wsInitTransactionInput->commerceId = $commerceId;
$wsInitTransactionInput->buyOrder = $buyOrder;
$wsInitTransactionInput->sessionId = $sessionId;
$wsInitTransactionInput->returnURL = $returnUrl;
$wsInitTransactionInput->finalURL = $finalUrl;

$wsTransactionDetail->commerceCode = $commerceCode;
$wsTransactionDetail->buyOrder = $buyOrder;
$wsTransactionDetail->amount = $amount;
$wsTransactionDetail->sharesNumber = $shareNumber;
$wsTransactionDetail->sharesAmount = $shareAmount;

$wsInitTransactionInput->transactionDetails = $wsTransactionDetail;

$endpoint = "https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl";

$webpayService = new WebPayService($endpoint);
$initTransactionResponse = $webpayService->initTransaction(
	array("wsInitTransactionInput" => $wsInitTransactionInput)
);

$xmlResponse = $webpayService->soapClient->__getLastResponse();
$soapValidation = new SoapValidation($xmlResponse, SERVER_CERT);

$validationResult = $soapValidation->getValidationResult();

if ($validationResult) {
	$wsInitTransactionOutput = $initTransactionResponse->return;
	$tokenWebpay = $wsInitTransactionOutput->token;
	$urlRedirect = $wsInitTransactionOutput->url;
}
?>

            <fieldset>
                <legend><b>Respuesta del servicio</b></legend>
                Token Webpay: <?php echo $tokenWebpay ?><br />
                Url Redirección: <?php echo $urlRedirect ?>
                <form method="post" action="<?php echo $urlRedirect ?>">
                    <input type="hidden" name="token_ws" value="<?php echo $tokenWebpay ?>" />
                    <input type="submit" value="Direccionar a Webpay" />
                </form>
            </fieldset>
