 
<div class="container-fluid">
    <h4>Agregar Venta</h4><br>
    <form>
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
  <button type="submit" class="btn btn-primary">Guardar</button> &NonBreakingSpace;&NonBreakingSpace;
  <a href="index.php?admin_ventas" class="btn btn-primary">Cancelar</a>
</form>

</div>

<div class="container-fluid d-flex flex-row">
    <div class="container d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-target="#ventanaModal" data-toggle="modal">Agregar Productos</button>
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
                                             <td><button type="button" class="btn btn-primary" id="buttonPlus"><i class="fas fa-plus"></i></button>  &nbsp;
                                            
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
 <h5 id="tituloVenta">Titulo Venta modal</h5>
 <button class="close" data-dismiss="modal" aria-label="Cerrar">
    <span aria-hidden="true">&times;</span>
 </button>
</div>
<form action="">
<div class="modal-body">
    <div class="alert alert-success">
        <h6>Prueba de Modal</h6>
    </div>

</div>
</form>
<div class="modal-footer">
    <button class="btn btn-warning" type="button" data-dismiss="modal">Cerrar</button>
    <button class="btn btn-success" type="button">Aceptar</button>
</div>
</div>
</div>
</div>



<script src="/{{BASE_DIR}}/public/js/peticiones.js"></script>