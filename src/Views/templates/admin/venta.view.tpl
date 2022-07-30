 
<div class="container-fluid">
    <h4>Agregar Venta</h4><br>
    <form action="index.php?page=checkout_checkout" method="post">
    <input type="hidden" name="mode" value="{{mode}}">
    <div id="detalle">
 <div class="form-group">
    <label for="customer_id">Cliente ID:</label>
    <input type="text" class="form-control" value="{{cus_id}}" readonly>
    </select>
</div>
  <div class="form-group">
    <label for="sale_isv">Impuesto</label>
    <select class="form-control" id="sale_isv" name="sale_isv">
  <option value=""></option>
    <option value="0.18">0.18</option>
    <option value="0.15">0.15</option>
    </select>
</div>
  <div class="form-group">
    <label for="sale_status">Estado</label>
    <select class="form-control" id="sale_status" name="sale_status">
    <option value=""></option>
    <option value="CONF">Confirmada</option>
    <option value="PEND">Pendiente</option>
    <option value="CANC">Cancelada</option>
    </select>
</div>
     {{foreach ProductosSessionVentas}}
    <div class=" form-group d-flex flex-row">
            <div class="form-group ">
                <label for="product_id">ID: </label> <br>
                <input type="text" class="form-control" id="product_id" name="product_id[]" value="{{product_id}}" readonly>
            </div>
             <div class="form-group">
                <label for="product_name">Nombre: </label>
                <input type="text" class="form-control" id="product_name" name="product_name[]" value="{{product_name}}" readonly>
            </div>
            <div class="form-group">
                <label for="product_price">Precio: </label>
                <input type="text" class="form-control" id="product_price" name="product_price[]" value="{{product_price}}" readonly>
            </div>
            <div class="form-group">
                <label for="inventory_size">Talla: </label>
                <input type="text" class="form-control" id="inventory_size" name="inventory_size[]" value="{{inventory_size}}" readonly>
            </div>
            <div class="form-group">
                <label for="inventory_gender">Genero: </label>
                <input type="text" class="form-control" id="inventory_gender" name="inventory_gender[]" value="{{inventory_gender}}" readonly>
            </div>
            <div class="form-group">
                <label for="quantity">Cantidad</label>
                <input type="number"  class="form-control" min="1" max="40" step="1" name="quantity[]" id="quantity" value="{{quantity}}">
            </div>
            <div class="form-group">
                <button type="button" name="btnDelete" data-target="#ventanaModalDelete" data-toggle="modal" class="btnDelete fas fa-trash" value="{{product_id}}" style="border: none; background-color: none; color:#007bff;"></button>
            </div>
    </div>
       {{endfor ProductosSessionVentas}}
</div>
  <button type="submit" class="btn btn-primary" name="btnEnviarVenta">Guardar</button> &NonBreakingSpace;&NonBreakingSpace;
  <a href="index.php?admin_ventas" class="btn btn-primary">Cancelar</a>
</form>

</div>

<div class="container-fluid d-flex flex-row flex-wrap">
    <div class="container d-flex justify-content-end">
           
    </div>
</div>

<br><br>
<!-- Page Heading -->

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Productos </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th>Talla</th>
                                            <th>Genero</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th>Talla</th>
                                            <th>Genero</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    {{foreach Productos}}
                                        <tr>
                                            <td>{{product_id}}</td>
                                            <td>{{product_name}}</td>
                                            <td>{{product_price}}</td>
                                            <td>{{inventory_size}}</td>
                                            <td>{{inventory_gender}}</td>
                                            <td class="buttonPlus fas fa-plus" style="cursor: pointer; color: white; background-color: #007bff;" data-target="#ventanaModal" data-toggle="modal"></td> &nbsp;
                                            
                                        </tr>
                                      {{endfor Productos}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


<div class="modal fade" id="ventanaModal" tabindex="-1" role="dialog" aria-labelledby="tituloVentana" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
 <h5 id="tituloVenta">Agregar Producto al detalle</h5>
 <button class="close" data-dismiss="modal" aria-label="Cerrar">
    <span aria-hidden="true">&times;</span>
 </button>
</div>
<div class="modal-body">
    <div>
        <form action="index.php?page=admin_venta" method="POST" >
            <div class="form-group">
                <input class="form-control" type="hidden" value="admin_venta" name="page">
                <input class="form-control" type="hidden" value="{{cus_id}}" name="cus_id">
                <input  class="form-control" type="hidden" name="mode" value="{{mode}}">
            </div>
            <div class="form-group">
                <label for="product_idModal">ID: </label>
                <input type="text" class="form-control" id="product_idModal" name="product_idModal" readonly>
            </div>
            <div class="form-group">
                <label for="product_nameModal">Nombre: </label>
                <input type="text" class="form-control" id="product_nameModal" name="product_nameModal" readonly>
            </div>
            <div class="form-group">
                <label for="product_priceModal">Precio: </label>
                <input type="text" class="form-control" id="product_priceModal" name="product_priceModal" readonly>
            </div>
            <div class="form-group">
                <label for="inventory_sizeModal">Talla: </label>
                <input type="text" class="form-control" id="inventory_sizeModal" name="inventory_sizeModal" readonly>
            </div>
            <div class="form-group">
                <label for="inventory_genderModal">Genero: </label>
                <input type="text" class="form-control" id="inventory_genderModal" name="inventory_genderModal" readonly>
            </div>
            <div class="form-group">
                <label for="quantityModal">Cantidad</label>
                <input type="number"  class="form-control" min="1" max="40" step="1" name="quantityModal" id="quantityModal" value="{{quantity}}">
            </div>
            <button class="btn btn-success" type="submit" id="btnAgregarDetalle" name="btnAgregarDetalle" value="true">Agregar</button>
        </form>
    </div>

</div>

<div class="modal-footer">
    <button class="btn btn-warning" type="button" data-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>


<div class="modal fade" id="ventanaModalDelete" tabindex="-1" role="dialog" aria-labelledby="tituloVentanaDelete" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
 <h5 id="tituloVentaDelete">Eliminando Producto del Detalle</h5>
 <button class="close" data-dismiss="modal" aria-label="Cerrar">
    <span aria-hidden="true">&times;</span>
 </button>
</div>
<div class="modal-body">
    <div>
        <form action="index.php?page=admin_venta" method="POST" >
            <div class="form-group">
                <input class="form-control" type="hidden" value="admin_venta" name="page">
                <input class="form-control" type="hidden" value="{{cus_id}}" name="cus_id">
                <input  class="form-control" type="hidden" name="mode" value="{{mode}}">
            </div>
            <div class="form-group">
                <label for="product_idModal">ID: </label>
                <input type="text" class="form-control" id="product_idModalDelete" name="product_idModalDelete" readonly>
            </div>
             <div class="form-group">
                <label for="inventory_sizeModal">Size: </label>
                <input type="text" class="form-control" id="inventory_sizeModalDelete" name="inventory_sizeModalDelete" readonly>
            </div>
            <div class="form-group">
                <label for="inventory_genderModal">Gender: </label>
                <input type="text" class="form-control" id="inventory_genderModalDelete" name="inventory_genderModalDelete" readonly>
            </div>
             <div class="form-group">
                <label for="quantity_modalDelete">Cantidad: </label>
                <input type="text" class="form-control" id="quantity_modalDelete" name="quantity_modalDelete" readonly>
            </div>
            
            <button class="btn btn-danger" type="submit" id="btnEliminarProduct" name="btnEliminarProduct" value="true">Eliminar</button>
        </form>
    </div>

</div>

<div class="modal-footer">
    <button class="btn btn-warning" type="button" data-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>

<script src="/{{BASE_DIR}}/public/js/peticiones.js"></script>