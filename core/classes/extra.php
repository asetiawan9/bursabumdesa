<?php
class extra {
	
	/** returns user's ip address **/
	public function ipAddress() 
	{
		if(!empty($_SERVER['HTTP_CLIENT_IP']))
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip=$_SERVER['REMOTE_ADDR'];
		return $ip;
	}
	
	/** returns base url **/
	public function baseUrl(){
		return sprintf(
			"%s://%s%s",
			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
			$_SERVER['SERVER_NAME'],
			dirname($_SERVER['SCRIPT_NAME']).'/'
		);
	}
	
	/** set error message **/
	public function setMsg($msg, $class) {
		$_SESSION['dispMsg'][]=$msg;
		$_SESSION['dispMsg'][]=$class;
	}
	
	/** display error message **/
	public function flashMsg() {
		if(isset($_SESSION['dispMsg'])) {
			echo '<div class="alert alert-'.$_SESSION['dispMsg'][1].' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> '.$_SESSION['dispMsg'][0].'</div>';
			unset($_SESSION['dispMsg']);
		}
	}
	
	/** set form data **/
	public function setFormdata($data) {
		$_SESSION['formData']=$data;
	}
	
	/** get form data **/
	public function getFormdata() {
		$formdata=isset($_SESSION['formData'])?$_SESSION['formData']:'';
		unset($_SESSION['formData']);
		return $formdata;
	}
	
	/** redirect to specifed page **/
	public function redirect_to($pageurl) {
		echo "<script>location.href='$pageurl';</script>";
		header("Location: $pageurl");
		exit;
	}
	
	/** check if the specified image exists or not **/
	public function chkImg($imgName, $path) {
		global $baseUrl;
		if(file_exists($path.$imgName) && $imgName!="") return $baseUrl.$path.$imgName;
		else return $baseUrl.$path."emptyimg.png";
	}
	
	/** check if the specified project image exists or not **/
	public function chkprjtImg($imgName, $path) {
		global $baseUrl;
		if(file_exists($path.$imgName) && $imgName!="") return $baseUrl.$path.$imgName;
		else return '';
	}
	
	/** custom-display swal message **/
	public function swalMsg($title,$text,$type,$url) {
			echo "<script>swal({title: '$title',text: '$text',type: '$type',
			confirmButtonColor: '#228ae6',confirmButtonText: 'OK',},function(){
			location.href='$url';});</script>";
	}
	/** custom-display swal single-message **/
	public function swalMsgSingle($msg) {
			echo "<script>swal('$msg');</script>";
	}
	
	/** custom-display swal option confirm-message **/
	public function swalMsgConfirm($title,$text,$type,$url) 
	{
		echo "<script>swal({
	  title: '$title',
	  text: '$text',
	  type: '$type',
	  showCancelButton: true,
	  confirmButtonClass: 'btn-danger',
	  confirmButtonText: 'Yes',
	  closeOnConfirm: false
	},
	function(){
	  location.href='$url';
	});</script>";
	}
	
	/** get datetimestamp **/
	function datetimestamp($getdate){
		$DateArr = @split("/",$getdate);
		@list($bkYear,$bkMonth,$bkDate) = $DateArr;
		$ret = @mktime(0,0,0,$bkMonth,$bkDate,$bkYear);
		return $ret;
	}
	
	/** limits string length **/
	function checkLength($str,$len){
		$strs = (strlen($str)>$len)?substr($str,0,$len).'...':$str;
		return $strs;
	}
	
	/** number format **/
	function nice_number($n) {
		// first strip any formatting;
		$n = (0+str_replace(",", "", $n));
		// is this a number?
		if (!is_numeric($n)) return false;
		if ($n > 1000000000000) return round(($n/1000000000000), 2).' Trillion';
		elseif ($n > 1000000000) return round(($n/1000000000), 2).' Billion';
		elseif ($n > 1000000) return round(($n/1000000), 2).' Million';
		//elseif ($n > 1000) return round(($n/1000), 2).' Thousand';
		return number_format($n,2);
	}
	
	/** reurl **/
	function reurl($name) {
		$name = trim($name);
		$result = strtolower($name);
		$res = str_replace(' ','-',$result);
		return $res;
	}
	/** custom-signup template **/
	public function signuptemplate($site_url,$site_logo,$topcontent,$site_title,$redirecturl)
	{
		$msg="<div marginwidth='0' marginheight='0' style='margin:0;padding:0;background-color:#d3dae0;height:100%!important;width:100%!important'>
   <center>
      <table style='border-collapse:collapse;margin:0;padding:0;background-color:#d3dae0;height:100%!important;width:100%!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center' height='100%'>
         <tbody>
            <tr>
               <td style='margin:0;padding:20px;border-top:0;height:100%!important;width:100%!important' valign='top' align='center'>
                  <table style='border-collapse:collapse;border:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                     <tbody>
                        
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td valign='top'>
                                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td style='padding:9px' valign='top'>
                                                      <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td style='padding-right:9px;padding-left:9px;padding-top:0;padding-bottom:0;text-align:center' valign='top'>
                                                                 <a href='$site_url'> <img src='$site_logo' style='max-width:600px;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;outline:none;text-decoration:none' width='140' align='middle'></a>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                         
                                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;color:#606060;font-family:Helvetica;font-size:15px;line-height:150%;text-align:left' valign='top'>
                                                                  <div style='text-align:left'><span style='font-family:arial,helvetica neue,helvetica,sans-serif'><span style='font-size:18px'><span style='font-size:16px'>Hi&nbsp;There,<br>
                                                                     
																	 <p>$topcontent</p></br>




<p>Please confirm your $site_title account by clicking the link below</p>
																	 
                                                                    
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td valign='top'>
                                       
                                        
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td style='padding-top:0;padding-right:18px;padding-bottom:18px;padding-left:18px'  valign='top' align='center'>
                                                      <table  style='border-collapse:separate!important;border:2px solid #298eea;border-radius:5px;background-color:#298eea' cellspacing='0' cellpadding='0' border='0'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='font-family:Arial;font-size:16px;padding:16px' valign='middle' align='center'>
                                                                  <a  title='Acivate account' href='$redirecturl' style='font-weight:bold;letter-spacing:normal;line-height:100%;text-align:center;text-decoration:none;color:#ffffff;word-wrap:break-word' target='_blank' data-saferedirecturl='#'>Activate your account</a>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                     
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse'  width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;color:#444444;font-family:Helvetica;font-size:15px;line-height:150%;text-align:left' valign='top'>
                                                                 
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                      
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='min-width:100%;padding:18px'>
                                                      <table  style='min-width:100%;border-top:1px solid #999999;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <span></span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td  width='50%' valign='top' align='left'>
                                          <table  style='border-collapse:collapse;min-width:100%' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td  valign='top'></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       <td  width='50%' valign='top' align='left'>
                                          <table  style='border-collapse:collapse;min-width:100%' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td  valign='top'></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                       <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td style='padding-bottom:9px' valign='top'>
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse'  width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='padding:0px 18px 9px;color:#aaaaaa;font-family:Helvetica;font-size:11px;line-height:125%;text-align:left' valign='top'>
                                                                <span style='font-family:arial,helvetica neue,helvetica,sans-serif'><a style='word-wrap:break-word;color:#606060;font-weight:normal;' target='_blank' data-saferedirecturl='$site_url'>Copyright ©". date('Y') ."<a href='$site_url'>$site_title</a>. All rights reserved.</a><br>
                                                                  <br>
                                                                 </span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
   </center>
   <img src='https://ci4.googleusercontent.com/proxy/H4wjA6gfQEGkAm4vkJkx0nu20iJIFmp35etM6Ss6rGKq7k6vQSoOR0D9k8kWnzU1ZXXo4bOxVzLpULcKXzLX3EGO1T8dzHzJmS8exciMkANwOTygCBC_7urZfdukj0NDs5H6uRrIwkujxEs1EhLPuxG4r7LPjuWhXLga7RzEr0E=s0-d-e1-ft#http://stocksnap.us3.list-manage.com/track/open.php?u=d6ebbac1770294f582074bbb1&amp;id=3a891a750f&amp;e=206c5f092d'  width='1' height='1'>
</div>";
 return $msg;
	}
/** custom-fblogin password template **/
	public function signupfbtemplate($site_url,$site_logo,$topcontent,$site_title,$redirecturl,$socialmail,$repassword) 
	{
	$msg="<div marginwidth='0' marginheight='0' style='margin:0;padding:0;background-color:#d3dae0;height:100%!important;width:100%!important'>
   <center>
      <table style='border-collapse:collapse;margin:0;padding:0;background-color:#d3dae0;height:100%!important;width:100%!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center' height='100%'>
         <tbody>
            <tr>
               <td style='margin:0;padding:20px;border-top:0;height:100%!important;width:100%!important' valign='top' align='center'>
                  <table style='border-collapse:collapse;border:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                     <tbody>
                        
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td valign='top'>
                                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td style='padding:9px' valign='top'>
                                                      <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td style='padding-right:9px;padding-left:9px;padding-top:0;padding-bottom:0;text-align:center' valign='top'>
                                                                 <a href='$site_url'> <img src='$site_logo' style='max-width:600px;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;outline:none;text-decoration:none' width='300' align='middle'></a>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                         
                                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;color:#606060;font-family:Helvetica;font-size:15px;line-height:150%;text-align:left' valign='top'>
                                                                  <div style='text-align:left'><span style='font-family:arial,helvetica neue,helvetica,sans-serif'><span style='font-size:18px'><span style='font-size:16px'>Hi&nbsp;There,<br>
                                                                     
																	 <p>$content</p></br>

<p>Mail id: $socialmail</p>
<p>password: $repassword</p></br>
<p>Please confirm your Prime video account by clicking the the link below</p>
																	 
                                                                    
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td valign='top'>
                                       
                                        
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td style='padding-top:0;padding-right:18px;padding-bottom:18px;padding-left:18px'  valign='top' align='center'>
                                                      <table  style='border-collapse:separate!important;border:2px solid #00bf6f;border-radius:5px;background-color:#00bf6f' cellspacing='0' cellpadding='0' border='0'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='font-family:Arial;font-size:16px;padding:16px' valign='middle' align='center'>
                                                                  <a  title='Go to login' href='$redirecturl' style='font-weight:bold;letter-spacing:normal;line-height:100%;text-align:center;text-decoration:none;color:#ffffff;word-wrap:break-word' target='_blank' data-saferedirecturl='#'>Go to login</a>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                     
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse'  width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;color:#444444;font-family:Helvetica;font-size:15px;line-height:150%;text-align:left' valign='top'>
                                                                 
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                      
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='min-width:100%;padding:18px'>
                                                      <table  style='min-width:100%;border-top:1px solid #999999;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <span></span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td  width='50%' valign='top' align='left'>
                                          <table  style='border-collapse:collapse;min-width:100%' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td  valign='top'></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       <td  width='50%' valign='top' align='left'>
                                          <table  style='border-collapse:collapse;min-width:100%' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td  valign='top'></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                       <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td style='padding-bottom:9px' valign='top'>
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse'  width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='padding:0px 18px 9px;color:#aaaaaa;font-family:Helvetica;font-size:11px;line-height:125%;text-align:left' valign='top'>
                                                                <span style='font-family:arial,helvetica neue,helvetica,sans-serif'><a style='word-wrap:break-word;color:#606060;font-weight:normal;' target='_blank' data-saferedirecturl='$site_url'>Copyright ©". date('Y') ."<a href='$site_url'> $site_title</a>. All rights reserved.</a><br>
                                                                  <br>
                                                                 </span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
   </center>
   <img src='https://ci4.googleusercontent.com/proxy/H4wjA6gfQEGkAm4vkJkx0nu20iJIFmp35etM6Ss6rGKq7k6vQSoOR0D9k8kWnzU1ZXXo4bOxVzLpULcKXzLX3EGO1T8dzHzJmS8exciMkANwOTygCBC_7urZfdukj0NDs5H6uRrIwkujxEs1EhLPuxG4r7LPjuWhXLga7RzEr0E=s0-d-e1-ft#http://stocksnap.us3.list-manage.com/track/open.php?u=d6ebbac1770294f582074bbb1&amp;id=3a891a750f&amp;e=206c5f092d'  width='1' height='1'>
</div>";
return $msg;
}

/** custom-forgot password template **/
public function forgotpwtemplate($site_url,$site_logo,$site_title,$redirecturl,$username,$newpass) 
	{
	$msg="<div marginwidth='0' marginheight='0' style='margin:0;padding:0;background-color:#d3dae0;height:100%!important;width:100%!important'>
   <center>
      <table style='border-collapse:collapse;margin:0;padding:0;background-color:#d3dae0;height:100%!important;width:100%!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center' height='100%'>
         <tbody>
            <tr>
               <td style='margin:0;padding:20px;border-top:0;height:100%!important;width:100%!important' valign='top' align='center'>
                  <table style='border-collapse:collapse;border:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                     <tbody>
                        
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td valign='top'>
                                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td style='padding:9px' valign='top'>
                                                      <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td style='padding-right:9px;padding-left:9px;padding-top:0;padding-bottom:0;text-align:center' valign='top'>
                                                                 <a href='$site_url'> <img src='$site_logo' style='max-width:600px;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;outline:none;text-decoration:none' width='140';height='40' align='middle'></a>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                         
                                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;color:#606060;font-family:Helvetica;font-size:15px;line-height:150%;text-align:left' valign='top'>
                                                                  <div style='text-align:left'><span style='font-family:arial,helvetica neue,helvetica,sans-serif'><span style='font-size:18px'><span style='font-size:16px'>Dear&nbsp;$username,</br></br>
                                                                     
																	 <p>Your Password has been changed.</br>New password : <b>$newpass</b></p>




<p style='color:#606060'>Go to your $site_title account & login with a new password.</p>
																	 
                                                                    
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td valign='top'>
                                       
                                        
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td style='padding-top:0;padding-right:18px;padding-bottom:18px;padding-left:18px'  valign='top' align='center'>
                                                      <table  style='border-collapse:separate!important;border:2px solid #298eea;border-radius:5px;background-color:#298eea' cellspacing='0' cellpadding='0' border='0'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='font-family:Arial;font-size:16px;padding:16px' valign='middle' align='center'>
                                                                  <a  title='Login to your account' href='$redirecturl' style='font-weight:bold;letter-spacing:normal;line-height:100%;text-align:center;text-decoration:none;color:#ffffff;word-wrap:break-word' target='_blank' data-saferedirecturl='#'>Go to login</a>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                     
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse'  width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;color:#444444;font-family:Helvetica;font-size:15px;line-height:150%;text-align:left' valign='top'>
                                                                 
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                      
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='min-width:100%;padding:18px'>
                                                      <table  style='min-width:100%;border-top:1px solid #999999;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <span></span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td  width='50%' valign='top' align='left'>
                                          <table  style='border-collapse:collapse;min-width:100%' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td  valign='top'></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       <td  width='50%' valign='top' align='left'>
                                          <table  style='border-collapse:collapse;min-width:100%' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td  valign='top'></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                       <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td style='padding-bottom:9px' valign='top'>
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse'  width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='padding:0px 18px 9px;color:#aaaaaa;font-family:Helvetica;font-size:11px;line-height:125%;text-align:left' valign='top'>
                                                                <span style='font-family:arial,helvetica neue,helvetica,sans-serif'><a style='word-wrap:break-word;color:#606060;font-weight:normal;' target='_blank' data-saferedirecturl='$site_url'>Copyright ©". date('Y') ."<a href='$site_url'> $site_title</a>. All rights reserved.</a><br>
                                                                  <br>
                                                                 </span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
   </center>
   <img src='https://ci4.googleusercontent.com/proxy/H4wjA6gfQEGkAm4vkJkx0nu20iJIFmp35etM6Ss6rGKq7k6vQSoOR0D9k8kWnzU1ZXXo4bOxVzLpULcKXzLX3EGO1T8dzHzJmS8exciMkANwOTygCBC_7urZfdukj0NDs5H6uRrIwkujxEs1EhLPuxG4r7LPjuWhXLga7RzEr0E=s0-d-e1-ft#http://stocksnap.us3.list-manage.com/track/open.php?u=d6ebbac1770294f582074bbb1&amp;id=3a891a750f&amp;e=206c5f092d'  width='1' height='1'>
</div>";
return $msg;
}

/** custom-mail template **/
public function customtemplate($site_url,$site_logo_lnk,$topcontent,$site_title,$redirecturl,$specific_title,$btn_name)
{
		$msg="<div marginwidth='0' marginheight='0' style='margin:0;padding:0;background-color:#d3dae0;height:100%!important;width:100%!important'>
   <center>
      <table style='border-collapse:collapse;margin:0;padding:0;background-color:#d3dae0;height:100%!important;width:100%!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center' height='100%'>
         <tbody>
            <tr>
               <td style='margin:0;padding:20px;border-top:0;height:100%!important;width:100%!important' valign='top' align='center'>
                  <table style='border-collapse:collapse;border:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                     <tbody>
                        
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td valign='top'>
                                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td style='padding:9px' valign='top'>
                                                      <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td style='padding-right:9px;padding-left:9px;padding-top:0;padding-bottom:0;text-align:center' valign='top'>
                                                                 <a href='$site_url'> <img src='$site_logo_lnk' style='max-width:600px;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;outline:none;text-decoration:none' width='140' align='middle'></a>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                         
                                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;color:#606060;font-family:Helvetica;font-size:15px;line-height:150%;text-align:left' valign='top'>
                                                                  <div style='text-align:left'><span style='font-family:arial,helvetica neue,helvetica,sans-serif'><span style='font-size:18px'><span style='font-size:16px'>Hi&nbsp;There,<br>
                                                                     
																	 <p>$topcontent</p></br>


<p>$specific_title</p>

<!--<p>Please confirm your $site_title account by clicking the link below</p>-->
																	 
                                                                    
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td valign='top'>
                                       
                                        
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td style='padding-top:0;padding-right:18px;padding-bottom:18px;padding-left:18px'  valign='top' align='center'>
                                                      <table  style='border-collapse:separate!important;border:2px solid #298eea;border-radius:5px;background-color:#298eea' cellspacing='0' cellpadding='0' border='0'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='font-family:Arial;font-size:16px;padding:16px' valign='middle' align='center'>
                                                                  <a href='$redirecturl' style='font-weight:bold;letter-spacing:normal;line-height:100%;text-align:center;text-decoration:none;color:#ffffff;word-wrap:break-word' target='_blank' data-saferedirecturl='#'>$btn_name</a>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                     
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse'  width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;color:#444444;font-family:Helvetica;font-size:15px;line-height:150%;text-align:left' valign='top'>
                                                                 
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                      
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='min-width:100%;padding:18px'>
                                                      <table  style='min-width:100%;border-top:1px solid #999999;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <span></span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td  width='50%' valign='top' align='left'>
                                          <table  style='border-collapse:collapse;min-width:100%' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td  valign='top'></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       <td  width='50%' valign='top' align='left'>
                                          <table  style='border-collapse:collapse;min-width:100%' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody>
                                                <tr>
                                                   <td  valign='top'></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                       <tr>
                           <td valign='top' align='center'>
                              <table style='border-collapse:collapse;min-width:100%;background-color:#ffffff;border-top:0;border-bottom:0' width='600' cellspacing='0' cellpadding='0' border='0'>
                                 <tbody>
                                    <tr>
                                       <td style='padding-bottom:9px' valign='top'>
                                          <table  style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                             <tbody >
                                                <tr>
                                                   <td  style='padding-top:9px' valign='top'>
                                                      <table style='max-width:100%;min-width:100%;border-collapse:collapse'  width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                                         <tbody>
                                                            <tr>
                                                               <td  style='padding:0px 18px 9px;color:#aaaaaa;font-family:Helvetica;font-size:11px;line-height:125%;text-align:left' valign='top'>
                                                                <span style='font-family:arial,helvetica neue,helvetica,sans-serif'><a style='word-wrap:break-word;color:#606060;font-weight:normal;' target='_blank' data-saferedirecturl='$site_url'>Copyright © ".date('Y')." <a href='$site_url'>$site_title</a>. All rights reserved.</a><br>
                                                                  <br>
                                                                 </span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
   </center>
   <img src='https://ci4.googleusercontent.com/proxy/H4wjA6gfQEGkAm4vkJkx0nu20iJIFmp35etM6Ss6rGKq7k6vQSoOR0D9k8kWnzU1ZXXo4bOxVzLpULcKXzLX3EGO1T8dzHzJmS8exciMkANwOTygCBC_7urZfdukj0NDs5H6uRrIwkujxEs1EhLPuxG4r7LPjuWhXLga7RzEr0E=s0-d-e1-ft#http://stocksnap.us3.list-manage.com/track/open.php?u=d6ebbac1770294f582074bbb1&amp;id=3a891a750f&amp;e=206c5f092d'  width='1' height='1'>
</div>";
 return $msg;
}
}
?>