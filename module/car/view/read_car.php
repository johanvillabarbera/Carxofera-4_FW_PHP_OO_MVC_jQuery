<div id="contenido">
    <h1>Informacion del Coche</h1>
    <p>
    <table border='2'>
        <tr>
            <td>Id: </td>
            <td>
                <?php
                    echo $car['id'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Número bastidor: </td>
            <td>
                <?php
                    echo $car['license_number'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Placa: </td>
            <td>
                <?php
                    echo $car['car_plate'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Marca: </td>
            <td>
                <?php
                    echo $car['brand'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Modelo: </td>
            <td>
                <?php
                    echo $car['model'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Kilometros: </td>
            <td>
                <?php
                    echo $car['km'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Categoria: </td>
            <td>
                <?php
                    echo $car['category'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Tipo: </td>
            <td>
                <?php
                    echo $car['type'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Comentarios: </td>
            <td>
                <?php
                    echo $car['comments'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Fecha alta: </td>
            <td>
                <?php
                    echo $car['discharge_date'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Color: </td>
            <td>
                <?php
                    echo $car['color'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Extras: </td>
            <td>
                <?php
                    echo $car['extras'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Imagen: </td>
            <td>
                <?php
                    echo $car['car_image'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Precio: </td>
            <td>
                <?php
                    echo $car['price'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Puertas: </td>
            <td>
                <?php
                    echo $car['doors'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Ciudad: </td>
            <td>
                <?php
                    echo $car['city'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Lat: </td>
            <td>
                <?php
                    echo $car['lat'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Lng: </td>
            <td>
                <?php
                    echo $car['lng'];
                ?>
            </td>
        </tr>
        
    </table>
    </p>
    <p><a href="index.php?page=controller_car&op=list">Volver</a></p>
</div>