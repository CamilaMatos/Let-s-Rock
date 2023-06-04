/*!
    * Start Bootstrap - SB Admin v7.0.4 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2021 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

function calcularTotal(quantidade) {
    let valor = document.querySelector("#valor").value;

    if (quantidade <= 0) {
        Swal.fire({
            title: 'Erro',
            text: 'Digite um valor positivo',
        })
        $("#quantidade").val("");
    } else if ( valor != "" ) {
        valor = Number(valor.replace(/\D/g, '')) / 100;
        let total = quantidade * valor;
        total = total.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
        document.querySelector("#total").value = total;
    }
}
