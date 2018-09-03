<script>
	$(document).ready(function() {
        
        $("#title").keyup(function(e){
          var rexString = /[`~!@#$%^&*()_|+\-=÷¿?;:'",.<>\{\}\[\]\\\/]/gi;
          if (rexString.test(this.value))
          {
            // Filter non-digits from input value.
            this.value = this.value.replace(rexString, '');
          }
      
        });
    });

</script>