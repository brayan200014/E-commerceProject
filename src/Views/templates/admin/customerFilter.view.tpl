<!--<div class="container-fluid justify-content-center align-items-center">
    <h3>Buscar Cliente</h3>

    <form action="index.php?page=admin_filterCustomer" method="post" autocomplete="off">
        <p>
            <label for="campo">Ingresar Correo: </label> &NonBreakingSpace;&NonBreakingSpace;
            <input type="text" name="campo" id="campo" >
            <ul id="lista" style="list-style-type: none; width: 350px; height: auto; position: absolute; z-index: 10; padding: 10px;">
                {{foreach Clientes}}
                    <li onclick="redirect(`{{customer_id}}`)" style="background-color:#EEEEE; border-top: 1px solid #9e9e9e; padding: 10px; width: 100%; float: left; cursor: pointer;">{{customer_id}}&NonBreakingSpace;&NonBreakingSpace;{{Nombre}}&NonBreakingSpace;&NonBreakingSpace;{{useremail}}</li>
                {{endfor Clientes}}
            </ul>
        </p>
    </form>

</div>

<div class="container-fluid">
    <h3>Buscar Cliente</h3><br>
 <form action="index.php?page=admin_customerFilter" method="post" autocomplete="off">
  <div class="form-group">
            <label for="campo">Ingresar Correo: </label> &NonBreakingSpace;&NonBreakingSpace;
            <input type="text" name="campo" id="campo" class="form-control" >
  </div>
  <button type="submit" class="btn btn-primary">Buscar</button><br>
    <div class="container-fluid justify-content-center align-items-center text-align-center">
   <ul id="lista" style="list-style-type: none; width: 350px; height: auto; position: absolute; z-index: 10; padding: 10px;">
                {{foreach Clientes}}
                    <li onclick="redirect(`{{customer_id}}`)" style="background-color:#EEEEE; border-top: 1px solid #9e9e9e; padding: 10px; width: 100%; float: left; cursor: pointer;">{{customer_id}}&NonBreakingSpace;&NonBreakingSpace;{{Nombre}}&NonBreakingSpace;&NonBreakingSpace;{{useremail}}</li>
                {{endfor Clientes}}
     </ul>
     </div>
</form>
</div>-->

<!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800" >Clientes</h1>
                    <p class="mb-4" >Buscar cliente para ingresar la venta</p>

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
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                             <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    {{foreach Clientes}}
                                        <tr>
                                            <td>{{customer_id}}</td>
                                            <td>{{Nombre}}</td>
                                            <td>{{useremail}}</td>
                                       
                                             <td> <a href="index.php?page=admin_venta&mode=INS&cus_id={{customer_id}}"" class="btn btn-primary btn-sm active" role="button" aria-pressed="true" ><i class="fas fa-plus"></i></a> &nbsp;
                                            
                                        </tr>
                                      {{endfor Clientes}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



<script>
    function redirect(id) {
        const idc= id;
       alert(idc);
       window.location.assign("index.php?page=admin_venta&mode=INS&cus_id="+id);
    }
</script>


