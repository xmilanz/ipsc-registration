<!-- UPRAVA ZAVODNIKA -->
<div class="modal fade" id="edit_shooter" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
		<div class="modal-header bg-success text-center">
			<h4 class="modal-title text-white w-100 fw-bold">Úprava závodníka</h4>
			<br>
			<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';"></button>
		</div>
		<div class="modal-body">
		<form class="needs-validation mb-0" method="post" action="./save.php?edit_shooter" >
			<div id="modal-edit-included">Načítám...</div>
		</div>
		  <div class="modal-footer border-top-0 mt-3 col-12">
			<button type="submit" class="btn btn-success">Uložit závodníka</button>
			<button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';">Zavřít bez uložení</button>
		  </div>
		</form>
      </div>
   </div>
</div>

<script>
$(document).ready(function(){
    $('.modal_edit_shooter').click(function(){
        var ID = $(this).data('id'); // Získáme ID z data-id
        $('#modalID').val(ID); // Uložíme ID do skrytého inputu

        $.post("edit.php", { ID: ID }, function(result){
            $("#modal-edit-included").html(result); // Naplníme pouze obsah modalu
        });
    });
});
</script>


<!-- MAZANI ZAVODNIKA -->
<div class="modal fade" id="delete_shooter" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
   <div class="modal-dialog modal-notify modal-warning" role="document">
      <div class="modal-content">
         <!-- ZDE SE VKLADA OBSAH delete.php-->
      </div>
   </div>
</div>
<script>
   $('.modal_delete_shooter').click(function(){
       var ID=$(this).attr('data-id');
       var KEY=$(this).attr('data-key');
       $.ajax({url:'delete.php?ID='+ID+'&KEY='+KEY,cache:false,success:function(result){
           $(".modal-content").html(result);
       }});
   });
</script>

<!-- POSLAT REGISTRACNI MAIL -->
<div class="modal fade" id="send_regmail" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
   <div class="modal-dialog modal-notify modal-warning" role="document">
      <div class="modal-content">
         <!-- ZDE SE VKLADA OBSAH regmail.php-->
      </div>
   </div>
</div>
<script>
   $('.modal_regmail').click(function(){
       var ID=$(this).attr('data-id');
       var KEY=$(this).attr('data-key');
       $.ajax({url:'regmail.php?ID='+ID+'&KEY='+KEY,cache:false,success:function(result){
           $(".modal-content").html(result);
       }});
   });
</script>

<!-- POSLAT URGENCI PLATBY -->
<div class="modal fade" id="payment_warn" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
   <div class="modal-dialog modal-notify modal-warning" role="document">
      <div class="modal-content">
         <!-- ZDE SE VKLADA OBSAH payment_warn.php-->
      </div>
   </div>
</div>
<script>
   $('.modal_payment_warn').click(function(){
       var ID=$(this).attr('data-id');
       var KEY=$(this).attr('data-key');
       $.ajax({url:'payment_warn.php?ID='+ID+'&KEY='+KEY,cache:false,success:function(result){
           $(".modal-content").html(result);
       }});
   });
</script>

<!-- OZNACENI ZAPLACENI -->
<div class="modal fade" id="payment_save" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
   <div class="modal-dialog modal-notify modal-warning" role="document">
      <div class="modal-content">
         <!-- ZDE SE VKLADA OBSAH payment_save.php-->
      </div>
   </div>
</div>
<script>
   $('.modal_payment_save').click(function(){
       var ID=$(this).attr('data-id');
       var KEY=$(this).attr('data-key');
       $.ajax({url:'payment_save.php?ID='+ID+'&KEY='+KEY,cache:false,success:function(result){
           $(".modal-content").html(result);
       }});
   });
</script>

<!-- VYRAZENI ZAVODNIKA -->
<div class="modal fade" id="cancel_shooter" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
   <div class="modal-dialog modal-notify modal-warning" role="document">
      <div class="modal-content">
         <!-- ZDE SE VKLADA OBSAH cancel.php-->
      </div>
   </div>
</div>
<script>
   $('.modal_cancel_shooter').click(function(){
       var ID=$(this).attr('data-id');
       var KEY=$(this).attr('data-key');
       $.ajax({url:'cancel.php?ID='+ID+'&KEY='+KEY,cache:false,success:function(result){
           $(".modal-content").html(result);
       }});
   });
</script>
<!-- VYRAZENI ZAVODNIKA -->