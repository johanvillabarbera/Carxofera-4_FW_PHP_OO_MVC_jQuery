<style>
.slidecontainer {
  width: 100%;
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 25px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  background: #04AA6D;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  background: #04AA6D;
  cursor: pointer;
}
</style>
<?php
$license_number = $brand = $model = $car_plate = $km = $category = $type2 = $comments = $discharge_date = $color = $extras2 =
$car_image = $price =  $doors = $city = $lat = $lng = "";

if ($_POST){
    if ($_POST["license_number"]) {
        $license_number = $_POST["license_number"];
    }
    if ($_POST["brand"]) {
        $brand = $_POST["brand"];
    }
    if ($_POST["model"]) {
        $model = $_POST["model"];
    }
    if ($_POST["car_plate"]) {
        $car_plate = $_POST["car_plate"];
    }
    if ($_POST["km"]) {
        $km = $_POST["km"];
    }
    if ($_POST["category"]) {
        $category = $_POST["category"];
    }
    if ($_POST["type"]) {
        foreach ($_POST["type"] as $indice) {
            $type2=$type2."$indice:";
        }
    }
    if ($_POST["comments"]) {
        $comments = $_POST["comments"];
    }
    if ($_POST["discharge_date"]) {
        $discharge_date = $_POST["discharge_date"];
    }
    if ($_POST["color"]) {
        $color = $_POST["color"];
    }
    if ($_POST["extras"]) {
        foreach ($_POST["extras"] as $indice) {
            $extras2=$extras2."$indice:";
        }
    }
    if ($_POST["car_image"]) {
        $car_image = $_POST["car_image"];
    }
    if ($_POST["price"]) {
        $price = $_POST["price"];
    }
    if ($_POST["doors"]) {
        $doors = $_POST["doors"];
    }
    if ($_POST["city"]) {
        $city = $_POST["city"];
    }
    if ($_POST["lat"]) {
        $lat = $_POST["lat"];
    }
    if ($_POST["lng"]) {
        $lng = $_POST["lng"];
    }
}

?>
<div id="contenido">
    <form autocomplete="on" method="post" name="alta_car" id="alta_car">
        <h1>Coche nuevo</h1>
        <table border='0'>

            <tr>
                <td>Número bastidor: </td>
                <td><input type="text" id="license_number" name="license_number" placeholder="1234567890ABCDE" value="<?php echo $license_number;?>"/></td>
                <td><font color="red">
                    <span id="error_license_number" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Placa: </td>
                <td><input type="text" id="car_plate" name="car_plate" placeholder="1234 ABC" value="<?php echo $car_plate;?>"/></td>
                <td><font color="red">
                    <span id="error_car_plate" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Marca: </td>
                <td><input type="text" id="brand" name="brand" placeholder="Audi" value="<?php echo $brand;?>"/></td>
                <td><font color="red">
                    <span id="error_brand" class="error">
        
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Modelo: </td>
                <td><input type="text" id="model" name="model" placeholder="A3" value="<?php echo $model;?>"/></td>
                <td><font color="red">
                    <span id="error_model" class="error">
                
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Kilometros: </td>
                <td><input type="text" id="km" name="km" placeholder="30000" value="<?php echo $km;?>"/></td>
                <td><font color="red">
                    <span id="error_km" class="error">
                    
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Categoria: </td>
                <td>
                    <?php
                        if ($_POST){
                            if ($_POST["category"]==="SM"){
                    ?>
                        <input type="radio" id="category" name="category" placeholder="category" value="SM" checked/>SM
                        <input type="radio" id="category" name="category" placeholder="category" value="RT"/>RT
                    <?php    
                            }else{
                    ?>
                        <input type="radio" id="category" name="category" placeholder="category" value="SM"/>SM
                        <input type="radio" id="category" name="category" placeholder="category" value="RT" checked/>RT
                    <?php  
                            } 
                        }else{
                    ?>
                        <input type="radio" id="category" name="category" placeholder="category" value="SM"/>SM
                        <input type="radio" id="category" name="category" placeholder="category" value="RT"/>RT
                    <?php   
                        }
                    ?>
                </td>
                <td><font color="red">
                    <span id="error_category" class="error">
                        
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Tipo: </td>
                <td>
                    <?php
                        if ($_POST){
                        $type=explode(":", $type2);
                    ?>
                    <?php
                        $busca_array=in_array("Hibrido", $type);
                        if($busca_array){
                    ?>
                        <input type="checkbox" id= "type[]" name="type[]" value="Hibrido" checked/>Híbrido
                    <?php
                        }else{
                    ?>
                        <input type="checkbox" id= "type[]" name="type[]" value="Hibrido"/>Híbrido
                    <?php
                        }
                    ?>
                    <?php
                        $busca_array=in_array("Eléctrico", $type);
                        if($busca_array){
                    ?>
                        <input type="checkbox" id= "type[]" name="type[]" value="Eléctrico" checked/>Eléctrico
                    <?php
                        }else{
                    ?>
                        <input type="checkbox" id= "type[]" name="type[]" value="Eléctrico"/>Eléctrico
                    <?php
                        }
                    ?>
                    <?php
                        $busca_array=in_array("Berlina", $type);
                        if($busca_array){
                    ?>
                        <input type="checkbox" id= "type[]" name="type[]" value="Berlina" checked/>Berlina
                    <?php
                        }else{
                    ?>
                    <input type="checkbox" id= "type[]" name="type[]" value="Berlina"/>Berlina
                    <?php
                        }
                    ?>
                    <?php
                        $busca_array=in_array("Deportivo", $type);
                        if($busca_array){
                    ?>
                        <input type="checkbox" id= "type[]" name="type[]" value="Deportivo" checked/>Deportivo
                    <?php
                        }else{
                    ?>
                        <input type="checkbox" id= "type[]" name="type[]" value="Deportivo"/>Deportivo
                    <?php
                        }
                    ?>
                    <?php
                        $busca_array=in_array("SUV", $type);
                        if($busca_array){
                    ?>
                        <input type="checkbox" id= "type[]" name="type[]" value="SUV" checked/>SUV
                    <?php
                        }else{
                    ?>
                    <input type="checkbox" id= "type[]" name="type[]" value="SUV"/>SUV
                    <?php
                        }
                    }else{
                    ?>
                    <input type="checkbox" id= "type[]" name="type[]" placeholder= "type" value="Hibrido"/>Híbrido
                    <input type="checkbox" id= "type[]" name="type[]" placeholder= "type" value="Eléctrico"/>Eléctrico
                    <input type="checkbox" id= "type[]" name="type[]" placeholder= "type" value="Berlina"/>Berlina
                    <input type="checkbox" id= "type[]" name="type[]" placeholder= "type" value="Deportivo"/>Deportivo
                    <input type="checkbox" id= "type[]" name="type[]" placeholder= "type" value="SUV"/>SUV
                    <?php
                    }
                    ?>
                </td>
                <td><font color="red">
                    <span id="error_type" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Comentarios: </td>
                <td><textarea cols="30" rows="5" type="text" id="comments" name="comments"><?php echo $comments;?></textarea></td>
                <td><font color="red">
                    <span id="error_comments" class="error">
                      
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Fecha alta: </td>
                <td><input type="date" id="discharge_date" name="discharge_date" value="<?php echo $discharge_date;?>"/></td>
                <td><font color="red">
                    <span id="error_discharge_date" class="error">
                      
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Color: </td>
                <td><input type="text" id="color" name="color" placeholder="Negro" value="<?php echo $color;?>"/></td>
                <td><font color="red">
                    <span id="error_color" class="error">
                      
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Extras: </td>

                <?php
                    if ($_POST){
                        $extra=explode(":", $extras2);
                ?>
                <td><select multiple size="4" id="extras[]" name="extras[]" placeholder="extras">
                    <?php
                        $busca_array=in_array("GPS", $extra);
                        if($busca_array){
                    ?>
                        <option value="GPS" selected>GPS</option>
                    <?php
                        }else{
                    ?>
                        <option value="GPS">GPS</option>
                    <?php
                        }
                    ?>
                    <?php
                        $busca_array=in_array("Turbo", $extra);
                        if($busca_array){
                    ?>
                        <option value="Turbo" selected>Turbo</option>
                    <?php
                        }else{
                    ?>
                        <option value="Turbo">Turbo</option>
                    <?php
                        }
                    ?>
                    <?php
                        $busca_array=in_array("Asientos", $extra);
                        if($busca_array){
                    ?>
                        <option value="Asientos" selected>Asientos calefactables</option>
                    <?php
                        }else{
                    ?>
                        <option value="Asientos">Asientos calefactables</option>
                    <?php
                        }
                    ?>
                    <?php
                        $busca_array=in_array("Descapotable", $extra);
                        if($busca_array){
                    ?>
                        <option value="Descapotable" selected>Descapotable</option>
                    <?php
                        }else{
                    ?>
                        <option value="Descapotable">Descapotable</option>
                    <?php
                        }
                    ?>
                    </select></td>
                <?php
                    }else{ 
                ?>
                <td><select multiple size="4" id="extras[]" name="extras[]" placeholder="extras">
                    <option value="GPS">GPS</option>
                    <option value="Turbo">Turbo</option>
                    <option value="Asientos">Asientos calefactables</option>
                    <option value="Descapotable">Descapotable</option>
                    </select></td>
                <?php
                    } 
                ?>
                <td><font color="red">
                    <span id="error_extras" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Imagen: </td>
                <td><input type="text" id="car_image" name="car_image" placeholder="view/images/img_cars/mercedes_glc_coupe.jpg" value="<?php echo $car_image;?>"/></td>
                <td><font color="red">
                    <span id="error_car_image" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Precio: </td>
                <div class="slidecontainer">
                    <td><input type="range" min="1" max="250000" value="<?php echo $price;?>" class="slider" id="price" name="price"/></td>
                    <td><p>Valor: <span id="valor_price"></span></p></td>
                </div>
                <td><font color="red">
                    <span id="error_price" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <script>
                var slider = document.getElementById("price");
                var output = document.getElementById("valor_price");
                output.innerHTML = slider.value;

                slider.oninput = function() {
                output.innerHTML = this.value;
                }
            </script>

            <tr>
                <td>Puertas: </td>
                <td><select id="doors" name="doors" placeholder="doors">
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    </select></td>
                <td><font color="red">
                    <span id="error_doors" class="error">
                        
                    </span>
                </font></font></td>
            </tr>
        
            <tr>
                <td>Ciudad: </td>
                <td><input type="text" id="city" name="city" placeholder="Madrid" value="<?php echo $city;?>"/></td>
                <td><font color="red">
                    <span id="error_city" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Lat: </td>
                <td><input type="text" id="lat" name="lat" placeholder="41.37422519654638" value="<?php echo $lat;?>"/></td>
                <td><font color="red">
                    <span id="error_lat" class="error">
                     
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Lng: </td>
                <td><input type="text" id="lng" name="lng" placeholder="2.175717061578382" value="<?php echo $lng;?>"/></td>
                <td><font color="red">
                    <span id="error_lng" class="error">
                       
                    </span>
                </font></font></td>
            </tr>
            
            <tr>
                <td><br><input name="Submit" type="button" class="Button_red_2" onclick="validate('create')" value="Enviar"/></td>
                <td align="right"><a href="index.php?page=controller_car&op=list">Volver</a></td>
            </tr>
        </table>
    </form>
</div>