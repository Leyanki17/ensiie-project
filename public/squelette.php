<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <link rel="stylesheet" href="<?  echo $this->router->getStyleUrl();?>" />
        
        <title><? echo $this->title?></title>
    </head>
    <body>
        <div class="container-fluid w-100 h-100 p-0">
            <div class="row h-100">
                <div class="col-2 h-100">
                    <div class="navbar-h">
                        <nav class="navbar">

                            <img src="/img/logo.png" class="logo">
                           <? if(key_exists("user",$_SESSION)){
                               ?>
                                    <img src="/avatars_img/<? echo $_SESSION["user"]->getId();?>.jpg" class="user_img">
                               <?
                           } ?>
                            <? echo $this->menu;?>  
                        </nav>
                    </div>
                    
                </div>
                <div class="col-10 p-4 text-center">
                    <div class="feed">
                        <span >
                            <?php echo $this->feedback ?>
                        </span>    
                    </div>

                    <section>
                        <?php echo $this->content;?>
                    </section>

                </div>
            </div>
        </div>
        <script type="text/javascript" src="script.js"></script>
    </body>
</html>