<div class="container-fluid">
    <h3>Orden Aceptada</h3>
    <p>Su orden fue procesada con exito </p>
</div>

<script>
        swal({
            title: "Orden Aceptada",
            text: "Su orden fue procesada con exito",
            icon: "success",
            button: "Aceptar",
            dangerMode: false,
        }).then( () => {
            window.location.assign('index.php?page=admin_ventas');
        });
</script>