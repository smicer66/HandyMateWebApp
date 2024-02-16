<html>
<head>
<title>PROBASEPAY}</title>
</head>
<body>
DO NOT REFRESH THIS PAGE!!!
<?php
/*$merchantId = "7OESIFCUXQ";
$deviceCode = "QYSH2MM5";
$serviceTypeId = "1981511018900";
$orderId = random_int(10000, 99999);
$responseurl = "http://shikola.com/payments/response";
$api_key = "D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F";

$toHash = $merchantId.$deviceCode.$serviceTypeId.$orderId.$amount.$responseurl.$api_key;
$toHash2 = $merchantId."-".$deviceCode."-".$serviceTypeId."-".$orderId."-".$amount."-".$responseurl."-".$api_key;
echo $toHash2;
javascript:document.SubmitPayForm.submit()
$hash = hash('sha512', $toHash);*/
?>

<body onload="javascript:document.SubmitPayForm.submit()">
<div style="font-size:14px;"><strong>LOADING PAYMENT PAGE!!!</strong></div>
<form autocomplete="off" accept-charset="UTF-8" action="http://payments.probasepay.com/payments/init" method="post" name="SubmitPayForm" id="SubmitRemitaForm" >
	<input name="merchantId" value="{{$params['merchantId']}}" type="hidden">
	<input name="deviceCode" value="{{$params['deviceCode']}}" type="hidden">
	<input name="serviceTypeId" value="{{$params['serviceTypeId']}}" type="hidden">
	<input name="orderId" value="{{$params['orderId']}}" type="hidden">
	<input name="hash" value="{{$params['hash']}}" type="hidden">
	<input name="payerName" value="{{$params['payerName']}}" type="hidden">
	<input name="payerEmail" value="{{$params['payerEmail']}}" type="hidden">
	<input name="payerPhone" value="{{$params['payerPhone']}}" type="hidden">
@if(isset($params['currency']))
	<input name="currency" value="{{$params['currency']}}" type="hidden">
@endif
	@foreach($params['amount'] as $amt)
		<input name="amount[]" value="{{$amt}}" type="hidden">
	@endforeach
	@foreach($params['paymentItem'] as $paymentItem)
		<input name="paymentItem[]" value="{{$paymentItem}}" type="hidden">
	@endforeach
	<input name="responseurl" value="{{$params['responseurl']}}" type="hidden">
	<input style="display:none" type ="submit" name="submit_btn" value="PAY USING PROBASEPAY">
	
	<!--Specifically for school fees payment-->
	<input name="payerId" value="{{$params['payerId']}}" type="hidden"><!--Student Id-->
	<input name="nationalId" value="{{$params['nationalId']}}" type="hidden"><!--national Id-->
	<input name="scope" value="{{$params['scope']}}" type="hidden"><!--Term of school-->
	<input name="description" value="{{$params['description']}}" type="hidden"><!--description-->
	
	<input name="payment_options" value="{{$params['payment_options']}}" type="hidden">
	
	@if(isset($params['merchant_defined_data']))
	    @foreach($params['merchant_defined_data'] as $k)
	        <input name="{{$k['name']}}" value="{{$k['value']}}" type="hidden">
	    @endforeach
	@endif
</form>
</body>
</html>