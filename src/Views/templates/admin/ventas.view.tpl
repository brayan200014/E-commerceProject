<div class="modal fade" id="ventanaModal" tabindex="-1" role="dialog" aria-labelledby="tituloVentana" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
 <h5 id="tituloVenta">Titulo Venta modal</h5>
 <button class="close" data-dismiss="modal" aria-label="Cerrar">
    <span aria-hidden="true">&times;</span>
 </button>
</div>
<div class="modal-body">
    <div class="alert alert-success">
        <h6>Prueba de Modal</h6>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-warning" type="button" data-dismiss="modal">Cerrar</button>
    <button class="btn btn-success" type="button">Aceptar</button>
</div>
</div>
</div>
</div>


<!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800" >Ventas</h1>
                    <p class="mb-4" >DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Ventas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>ISV</th>
                                            <th>Subtotal</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>ISV</th>
                                            <th>Subtotal</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    {{foreach Sales}}
                                        <tr>
                                            <td>{{sale_id}}</td>
                                            <td>{{sale_date}}</td>
                                            <td>{{customer}}</td>
                                            <td>{{sale_isv}}</td>
                                            <td>{{sale_subtotal}}</td>
                                            <td>{{sale_total}}</td>
                                            <td>{{sale_status}}</td>
                                             <td> <a href="" class="btn btn-primary btn-sm active" role="button" aria-pressed="true" data-toggle="modal" data-target="#ventanaModal"><i class="fas fa-eye"></i></a> &nbsp;
                                            <a href="index.php=?page=admin_venta&mode=UPD&id={{sale_id}}" class="btn btn-primary btn-sm active" role="button" aria-pressed="true"><i class="fas fa-pen"></i></a>
                                        </tr>
                                      {{endfor Sales}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>