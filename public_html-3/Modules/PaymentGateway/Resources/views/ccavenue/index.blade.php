<html>
    <head>
        <title>CCAvenue Payment</title>
    </head>
    <body>
        
        <center>
           
            <form method="post" name="redirect" action="<?php echo $CCAVENUE_BASE_URL;?>"> 
                <?php
                echo "<input type='hidden' name='encRequest' value='$encrypted_data'>";
                echo "<input type='hidden' name='access_code' value='$ACCESS_CODE'>";
                ?>
            </form>
            
        </center>
        
        <script language='javascript'>document.redirect.submit();</script>
    
    </body>
</html>

