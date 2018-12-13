<?php 
require "core/init.php"; 
$formaction = "https://www.sandbox.paypal.com/cgi-bin/webscr"; // Test account
//$formaction = "https://www.paypal.com/cgi-bin/webscr";

 //Live account

$paypalmail = $paypal_email;
$prjt_name = "Investment";

$amt = $db->extractCol("select contribute_amount from contribute where invest_id='".$_SESSION['invid']."'");

$item_number="1";

$return_url = $baseUrl."success/";
$cancel = $baseUrl."user-invest/?cancel";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_title;  ?></title>
</head>
<script>
function FormSubmit()
{
document.frm_process.submit();	
}
</script>

<body onload="Javascript:FormSubmit();">
<table width="100%" height="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  align="center" valign="middle">
	
    <form name="frm_process" method="get" action="<?php echo $formaction; ?>">
<center>&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="333333">
 <img src="<?=$baseUrl;?>images/load.gif" border="0" alt="loading" />&nbsp; </font></center>
<input type="hidden" name="cmd" value="_xclick" />
<table>
	<tr><td>
<!-- Owner Paypal Id -->
<input type="hidden" name="business" value="<?php echo $paypalmail; ?>" />
</td></tr>
<tr><td>
<!-- Product Name -->
<input type="hidden" name="item_name" value="<?php echo $prjt_name; ?>" />
</td></tr>
<tr><td>
<!-- Product Amount -->
<input type="hidden" name="amount" value="<?php echo $amt; ?>" />
</td></tr>
<tr><td>
<input type="hidden" name="no_note" value="2" />
<input type="hidden" name="rm" value="2" />
</td></tr>
<tr><td>
<!-- Amount Currency -->
<input type="hidden" name="currency_code" value="USD" />
</td></tr>
<tr><td>
<input type="hidden" name="bn" value="PP-BuyNowBF" />
<input type="hidden" name="item_number" value="<?php echo $item_number; ?>">

</td></tr>
<tr><td>
<!--<input type="hidden" name="notify_url" value="<?php echo $return_url; ?>">-->
<!-- Success Return Path -->

<input type="hidden" name="return" value="<?php echo $return_url; ?>">
<!--http://en.426k.com/login.php?pay_suss-->

</td></tr>
<tr><td>
<!-- Failure Return Path -->
<input type="hidden" name="cancel_return" value="<?php echo $cancel; ?>" />
</td></tr>
<tr><td>

</td></tr>
<tr><td></td>
</form>
    </td>
  </tr>
</table>

</body>
</html>