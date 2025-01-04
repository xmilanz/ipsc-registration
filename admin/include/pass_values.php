<!-- UPRAVA ZAVODNIKA -->
<div class="modal fade" id="edit_shooter" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel"  aria-hidden="true">
        <div class="modal-dialog modal-notify modal-warning" role="document">
        <div class="modal-content">
		<!-- ZDE SE VKLADA OBSAH edit.php-->
		</div>
        </div>
</div>
<script>
    $('.modal_edit_shooter').click(function(){
        var ID=$(this).attr('data-id');
        $.ajax({url:"edit.php?ID="+ID,cache:false,success:function(result){
            $(".modal-content").html(result);
        }});
    });
</script>
<!-- UPRAVA ZAVODNIKA -->


<!-- MAZANI ZAVODNIKA -->
<div class="modal fade" id="delete_shooter" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel"  aria-hidden="true">
        <div class="modal-dialog modal-notify modal-warning" role="document">
        <div class="modal-content">
		<!-- ZDE SE VKLADA OBSAH delete.php-->
		</div>
        </div>
</div>
<script>
    $('.modal_delete_shooter').click(function(){
        var ID=$(this).attr('data-id');
        $.ajax({url:"delete.php?ID="+ID,cache:false,success:function(result){
            $(".modal-content").html(result);
        }});
    });
</script>
<!-- MAZANI ZAVODNIKA -->

<!-- POSLAT REGISTRACNI MAIL -->
<div class="modal fade" id="send_regmail" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel"  aria-hidden="true">
        <div class="modal-dialog modal-notify modal-warning" role="document">
        <div class="modal-content">
		<!-- ZDE SE VKLADA OBSAH regmail.php-->
		</div>
        </div>
</div>
<script>
    $('.modal_regmail').click(function(){
        var ID=$(this).attr('data-id');
        $.ajax({url:"regmail.php?ID="+ID,cache:false,success:function(result){
            $(".modal-content").html(result);
        }});
    });
</script>
<!-- POSLAT REGISTRACNI MAIL -->


<!-- POSLAT URGENCI PLATBY -->
<div class="modal fade" id="send_paymail" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel"  aria-hidden="true">
        <div class="modal-dialog modal-notify modal-warning" role="document">
        <div class="modal-content">
		<!-- ZDE SE VKLADA OBSAH paymail.php-->
		</div>
        </div>
</div>
<script>
    $('.modal_paymail').click(function(){
        var ID=$(this).attr('data-id');
        $.ajax({url:"paymail.php?ID="+ID,cache:false,success:function(result){
            $(".modal-content").html(result);
        }});
    });
</script>
<!-- POSLAT URGENCI PLATBY -->

<!-- OZNACENI ZAPLACENI -->
<div class="modal fade" id="save_payment" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel"  aria-hidden="true">
        <div class="modal-dialog modal-notify modal-warning" role="document">
        <div class="modal-content">
		<!-- ZDE SE VKLADA OBSAH payment.php-->
		</div>
        </div>
</div>
<script>
    $('.modal_save_payment').click(function(){
        var ID=$(this).attr('data-id');
        var KEY=$(this).attr('data-key');
        $.ajax({url:'payment.php?ID='+ID+'&KEY='+KEY,cache:false,success:function(result){
            $(".modal-content").html(result);
        }});
    });
</script>
<!-- OZNACENI ZAPLACENI -->

<!-- VYRAZENÍ ZAVODNIKA -->
<div class="modal fade" id="cancel_shooter" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel"  aria-hidden="true">
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
