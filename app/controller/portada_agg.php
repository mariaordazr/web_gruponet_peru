<?php
    error_reporting(0);
    if(!empty($_POST["btnAggPort"])){
        try{
            $imagen = addslashes(file_get_contents($_FILES["txtimg"]["tmp_name"]));
        }catch(Exception $e){
            $imagen="";
        }
        if($imagen!=""){
            $sql=$conexion->query("INSERT INTO portadas(img_portada) VALUES('$imagen')");
            if($sql == true){
                echo "<div class='alert alert-success'>Imagen registrada correctamente</div>";
            }else{
                echo "<div class='alert alert-danger'>No se pudo agregar la imagen, pueda que estes usando un formato no JPG</div>";
            }
        }else{
            echo "<div class='alert alert-danger'>Selecciona una imagen</div>";
        }
        ?>
        <script>
            (function(){
                var not=function()
                {
                    window.history.replaceState(null,null, window.location.pathname);
                }
                setTimeout(not,0)
            }())
        </script>
<?php }

