<?php

if(isset ($_SESSION['menssagem']) and !empty($_SESSION['menssagem'])){
?>
<script>
    window.onload = function(){
        M.toast({html:'<?php echo $_SESSION['menssagem']; ?>'})
    };
</script>


<?php
}
unset($_SESSION['menssagem']);
?>