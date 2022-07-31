window.onload= function() {
let elementos= document.getElementsByClassName("buttonEdit");
for (let i=0; i<elementos.length; i++ ) {
    elementos[i].addEventListener("click", (event) => {
        var valores= new Array();
        var elementosTD= event.srcElement.parentElement.getElementsByTagName("td");
        for (let i=0; i<elementosTD.length; i++) {
            valores.push(elementosTD[i].innerHTML);
        }

        window.location.assign("index.php?page=admin_venta&mode=UPD&idSale="+valores[0]);
    });
}


let elementosDisplay= document.getElementsByClassName("buttonDisplay");
for (let i=0; i<elementosDisplay.length; i++ ) {
    elementosDisplay[i].addEventListener("click", (event) => {
        var valores= new Array();
        var elementosTD= event.srcElement.parentElement.getElementsByTagName("td");
        for (let i=0; i<elementosTD.length; i++) {
            valores.push(elementosTD[i].innerHTML);
        }

        window.location.assign("index.php?page=admin_venta&mode=DSP&idSale="+valores[0]);
    });
}
}
