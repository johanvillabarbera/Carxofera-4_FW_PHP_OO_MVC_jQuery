<div id="contenido">
    <div class="container">
        <table>
            <tr>
                <th width=100><h3 data-tr="Añadir">Añadir</h3></th>
                <th width=100><h3 data-tr="Dummies">Dummies</h3></th>
                <th width=100><h3 data-tr="Borrar todo">Borrar todo</h3></th>
            </tr>
            <tr>
                <th><p><a href="index.php?page=controller_car&op=create"><img src="view/img/anadir.png"></a></p></th>
                <th><p><a href="index.php?page=controller_car&op=dummies"><img src="view/img/anadir.png"></a></p></th>
                <th><p><a href="index.php?page=controller_car&op=delete_all"><img src="view/img/eliminar.png"></a></p></th>
            </tr>
        </table>
        <br>

    	<div class="row">
    			<h2>LISTA DE COCHES</h2>
    	</div>
    	<div class="row">

    		<table>
                <tr>
                    <td width=50><b>Id</b></th>
                    <td width=125><b>Número bastidor</b></th>
                    <td width=125><b>Placa</b></th>
                    <th width=350><b>Accion</b></th>
                </tr>
                <?php
                    if ($rdo->num_rows === 0){
                        echo '<tr>';
                        echo '<td align="center"  colspan="3">NO HAY NINGUN COCHE</td>';
                        echo '</tr>';
                    }else{
                        foreach ($rdo as $row) {
                       		echo '<tr>';
                    	   	echo "<td width=50>".$row['id']."</td>";
                            echo "<td width=125>".$row['license_number']."</td>";
                            echo "<td width=125>".$row['car_plate']."</td>";	
                    	   	echo '<td width=350>';

                            print ("<div class='read_car' id='".$row['id']."'>Read</div>");  //READ

                    	   	//echo '<a class="Button_blue" href="index.php?page=controller_car&op=read&id='.$row['id'].'">Read</a>';
                    	   	echo '&nbsp;';
                    	   	echo '<a class="Button_green" href="index.php?page=controller_car&op=update&id='.$row['id'].'">Update</a>';
                    	   	echo '&nbsp;';
                    	   	echo '<a class="Button_red" href="index.php?page=controller_car&op=delete&id='.$row['id'].'">Delete</a>';
                    	   	echo '</td>';
                    	   	echo '</tr>';
                        }
                    }
                ?>
            </table>
    	</div>
    </div>
</div>

<!-- modal window -->
<section id="car_modal">
    
</section>


    <div class="container">
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <img src="https://api.lorem.space/image/car?w=351&h=240">
                    <h3>Audi A3</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cum cumque minus iste veritatis provident at.</p>
                        <!-- <a href="#">Read More</a> -->
                        <?php
                        print ("<div class='read_car' id='".$row['id']."'>Read</div>");
                        ?>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <img src="https://api.lorem.space/image/car?w=350&h=240">
                    <h3>Volkswagen Golf</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cum cumque minus iste veritatis provident at.</p>
                        <a href="#">Read More</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <img src="https://api.lorem.space/image/car?w=349&h=240">
                    <h3>Opel Corsa</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cum cumque minus iste veritatis provident at.</p>
                        <a href="#">Read More</a>
                </div>
            </div>
        </div>
    </div>
