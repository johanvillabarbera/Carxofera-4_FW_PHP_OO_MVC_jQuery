<div id="contenido">
    <form autocomplete="on" method="post" name="delete_car" id="delete_car">
        <table border='0'>
            <tr>
                <td align="center"  colspan="2"><h3>¿Está seguro de que quiere borrar el coche <?php echo $car['brand'];?> <?php echo $car['model'];?> con número de bastidor <?php echo $car['license_number'];?> y número de placa <?php echo $car['car_plate'];?>?</h3></td>
                <input type="hidden" id="id" name="id" placeholder="id" value="<?php echo $car['id'];?>"/>
            </tr>
            <tr>
                <td width=680 align="center"><input name="Submit" type="button" class="Button_green" onclick="operations_car('delete')" value="Aceptar"/></td>
                <td width=680 align="center"><a class="Button_red" href="index.php?page=controller_car&op=list">Cancelar</a></td>
            </tr>
        </table>
    </form>
</div>