$(function () {
    var $alias = $(".form-control[name='alias']");
    var $aliasAlert = $(".alias-alert");
    var specialChars = "!@#$%^&*()-_=+[{]}\\|;:'\",<.>/?`~ěščřžýáíéóúůďťňĚŠČŘŽÝÁÍÉÓÚŮĎŤŇ ";

    $alias.on("input", function (e) {
        var el = $(this);
        var val = el.val();
        $aliasAlert.show();

        specialChar=false;
        for(var i=0; i<val.length;i++){
            for(var j=0; j<specialChars.length; j++){
                if(val[i]==specialChars[j]){
                    specialChar = true;
                }
            }
        }

        console.log(specialChar);
        
        if(specialChar==true){
            $(this).addClass("invalid");
        }
		  if(specialChar==false){
            $(this).addClass("valid").removeClass("invalid");

        }

        
    });
});
