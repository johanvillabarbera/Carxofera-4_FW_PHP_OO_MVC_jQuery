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
<div id="contenido">
    <form autocomplete="on" method="post" name="aupdate_car" id="update_car">
        <h1>Modificar coche</h1>
        <table border='0'>
            
        <input type="hidden" id="id" name="id" placeholder="id" value="<?php echo $car['id'];?>"/>
        <input type="hidden" id="license_number_old" name="license_number_old" placeholder="license_number_old" value="<?php echo $car['license_number'];?>"/>
        <input type="hidden" id="car_plate_old" name="car_plate_old" placeholder="car_plate_old" value="<?php echo $car['car_plate'];?>"/>

            <tr>
                <td>Número bastidor: </td>
                <td><input type="text" id="license_number" name="license_number" placeholder="license_number" value="<?php echo $car['license_number'];?>"/></td>
                <td><font color="red">
                    <span id="error_license_number" class="error">
                        
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Placa: </td>
                <td><input type="text" id="car_plate" name="car_plate" placeholder="car_plate" value="<?php echo $car['car_plate'];?>"/></td>
                <td><font color="red">
                    <span id="error_car_plate" class="error">
                        
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Marca: </td>
                <td><input type="text" id="brand" name="brand" placeholder="brand" value="<?php echo $car['brand'];?>"/></td>
                <td><font color="red">
                    <span id="error_brand" class="error">
                        
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Modelo: </td>
                <td><input type="text" id="model" name="model" placeholder="model" value="<?php echo $car['model'];?>"/></td>
                <td><font color="red">
                    <span id="error_model" class="error">
                        
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Kilometros: </td>
                <td><input type="text" id="km" name="km" placeholder="km" value="<?php echo $car['km'];?>"/></td>
                <td><font color="red">
                    <span id="error_km" class="error">
                        
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Categoria: </td>
                <td>
                    <?php
                        if ($car['category']==="SM"){
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
                    ?>
                </td>
                <td><font color="red">
                    <span id="error_category" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Tipo: </td>
                <?php
                    $type=explode(":", $car['type']);
                ?>
                <td>
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
                    ?>
                </td>
                <td><font color="red">
                    <span id="error_type" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Comentarios: </td>
                <td><textarea cols="30" rows="5" type="text" id="comments" name="comments" placeholder="comments"><?php echo $car['comments'];?></textarea></td>
                <td><font color="red">
                    <span id="error_comments" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Fecha alta: </td>
                <td><input type="date" id="discharge_date" name="discharge_date" placeholder="discharge_date" value="<?php echo $car['discharge_date'];?>"/></td>
                <td><font color="red">
                    <span id="error_discharge_date" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Color: </td>
                <td><input type="text" id="color" name="color" placeholder="color" value="<?php echo $car['color'];?>"/></td>
                <td><font color="red">
                    <span id="error_color" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Extras: </td>
                <?php
                    $extra=explode(":", $car['extras']);
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
                <td><font color="red">
                    <span id="error_extras" class="error">
                    
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Imagen: </td>
                <td><input type="text" id="car_image" name="car_image" placeholder="view/images/img_cars/mercedes_glc_coupe.jpg" value="<?php echo $car['car_image'];?>"/></td>
                <td><font color="red">
                    <span id="error_car_image" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Precio: </td>
                <div class="slidecontainer">
                    <td><input type="range" min="1" max="250000" value="<?php echo $car['price'];?>" class="slider" id="price" name="price"/></td>
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
                    <?php
                        if($car['doors']==="2"){
                    ?>
                        <option value="2" selected>2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    <?php
                        }elseif($car['doors']==="3"){
                    ?>
                        <option value="2">2</option>
                        <option value="3" selected>3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    <?php
                        }elseif($car['doors']==="4"){
                    ?>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4" selected>4</option>
                        <option value="5">5</option>
                    <?php
                        }else{
                    ?>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5" selected>5</option>
                    <?php
                        }
                    ?>
                    </select></td>
                <td><font color="red">
                    <span id="error_doors" class="error">
                        
                    </span>
                </font></font></td>
            </tr>
        
            <tr>
                <td>Ciudad: </td>
                <td><input type="text" id="city" name="city" placeholder="city" value="<?php echo $car['city'];?>"/></td>
                <td><font color="red">
                    <span id="error_city" class="error">
                       
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Lat: </td>
                <td><input type="text" id="lat" name="lat" placeholder="lat" value="<?php echo $car['lat'];?>"/></td>
                <td><font color="red">
                    <span id="error_lat" class="error">
                        
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Lng: </td>
                <td><input type="text" id="lng" name="lng" placeholder="lng" value="<?php echo $car['lng'];?>"/></td>
                <td><font color="red">
                    <span id="error_lng" class="error">
                        
                    </span>
                </font></font></td>
            </tr>
            
            <tr>
                <td><br><input name="Submit" type="button" class="Button_red_2" onclick="validate('update')" value="Modificar"/></td>
                <td align="right"><a href="index.php?page=controller_car&op=list">Volver</a></td>
            </tr>
        </table>
    </form>
</div>