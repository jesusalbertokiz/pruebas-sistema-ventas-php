<?php

    $ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/index"; //Se usa _GET para tomar información de la barra de busqueda. Luego se formatea para que cuando haya nada tenga el valos de la pagina de inicio
    $array = explode("/", $ruta); // Esto divide las rutas en segmentos separados por "/"
    $controller = $array[0]; // El primer segmento de la URL sera el controlador. Lo que va a ejecutar: Función o clases
    $metodo = "index"; //El segundo segmento de la URL sera el metododo. La paginación: el home el about y todo eso (la vista) se pasa por este segmento
    $parametro = ""; //El tercer segmento de la URL sera el parametro
    
    if (!empty($array[1])) {// Aqui hacemos que los metodos cabien cuando el segundo segmento de la URL se modifique
        if (!empty($array[1] != "")){// Aqui hacemos la excepción de que si vale "" no ejecute nada
            $metodo = $array[1];// A la vez formateamos para que de valor prederteminado tenga index
        }
    }

    if (!empty($array[2])) {// Aca en caso de que tengamos un tercer segmento lo tomaremos como parametro
        if (!empty($array[2] != "")) {// Aqui hacemos la excepción de que si vale "" no ejecute nada
            for ($i=2; $i < count($array); $i++) { //Aqui nos aseguraremos de que el ciclo for tome encuenta es apartir del tercer segmento
                $parametro .= $array[$i]. ","; //crearemos un string por los segmentos que esten apartir del tercero. 
            }
            $parametro = trim($parametro, ",");//La coma hizo que tuviera una "," al final, asi que la eliminaremos con trim()
        }
    }

    /**Ahora hasta este punto ya logramos obtener información de las URL ahora necesitamos que nuestros controladores
    ejecuten algo segun la URL que le pasemos al programa. Para hacer esto debemos recordar que estos controladores estan en una carpeta
    especifica y que estos asu vez tienen su nombre especifico. Es decir para acceder a ellos necesitamos la ruta especifica para 
    colocarla como URL**/

    
  $dirControllers = "Controllers/".$controller.".php"; //Aca queda predeterminada la carpeta Controllers que es donde se guardaran los controladores, el controlador home que inicializamos al principio concatenaremos la variable controller que obtendremos de la URL mas la extencion ".php"



    if(file_exists($dirControllers)){
        require_once $dirControllers; //Aca vamos a traer el codigo el controlador que buscamos. Pero recuerda que los controladores son clases. Para ejecutar sus metodos hay que llamarlos.
        $controller = new $controller(); //Aca creamos una nueva instancia de la clase de los controladores y luego estaremos preparados para usar sus metodos
        
        //Verificamos si en esta nueva instancia existen metodos del controlador
        if (method_exists($controller, $metodo)){ //Aqui comprobamos que esta clase tiene el metodo que estamos buscando a traves de la URL
                $controller->$metodo($parametro); //Ejecuto el metodo que mande a llamar
        }
        else{
            echo "No existe el metodo";
        }
    }
    
    else{
       echo "No existe el controlador";
    }  
        
    
    
    /*      
    require_once "Config/App/autoload.php";//Segundo Video

*/

?>