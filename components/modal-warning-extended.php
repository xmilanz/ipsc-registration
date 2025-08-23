<?php
function WarningModalExtended(
    string $Header = '', 
	string $CloseHref = '',
	string $Message = '',
	string $Info1 = '',
	string $Info2 = '',
	string $FooterButtons = ''
): void {
    $WarnHeader = htmlspecialchars($Header, ENT_QUOTES, 'UTF-8');
    $WarnCloseHref = htmlspecialchars($CloseHref, ENT_QUOTES, 'UTF-8');
    $WarnMessage = $Message;
    $WarnInfo1 = $Info1;
    $WarnInfo2 = $Info2;
    $WarnFooterButtons = $FooterButtons;
	
echo " 
 <div class='text-center'>
	<img src='./images/bkg_eggenberg.png'>
 </div>
   <div id='myModal' class='row modal fade' tabindex='-1'>
	<div class='modal-dialog'>
		<div class='modal-content'>
		<div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 fw-bold py-2'>$WarnHeader</h4> <br>
			<button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close' onclick=\"window.location.href = '$WarnCloseHref';\"></button>
		</div>
		<div class='modal-body text-center'>
				$WarnMessage
			</div>
		</div>
		<div class='col-12 text-center px-3 pb-1'>
				<p class='pe-2' style='font-size:14px'>$WarnInfo1</p>
				<i class='far fa-info-circle pe-2' style='font-size:14px'></i>$WarnInfo2
			</div>
  		<div class='modal-footer border-top-0 col-12'>
   			$WarnFooterButtons
   		</div>
   	</div>
   </div>
</div>
 ";
}
?>
<script  type='text/javascript'>
$(document).ready(function(){
    $('#myModal').modal('show');
});
</script>