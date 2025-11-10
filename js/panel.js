function fetchPanelDados() {
    $.ajax({
        method: 'POST',
        url: './sqls/fetch_status.php',
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        success: function (response) {

            // console.log(response);
            // response.forEach((element) => console.log(element));
            $(".inscritos").text(response.total_count);
            $(".confirmados").text(response.confirmado_count);
            $(".pendentes").text(response.null_count);
            $(".cancelados").text(response.cancelado_count);
            // $('#tableResult').html(response);
        }
    });
}
// function fetchPanelGraf() {
//     $.ajax({
//         method: 'POST',
//         url: './sqls/fetch_graf.php',
//         contentType: false,
//         cache: false,
//         processData: false,
//         dataType: 'json',
//         success: function (response) {

//             grafiPie('js-doughnut', response.categoria, response.valor, 'Dados Por Categoria');
//             // console.log(response);
//         }
//     });
// }
function fetchPanelList() {
    $.ajax({
        method: 'POST',
        url: './sqls/fetch_inscr.php',
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            // console.log(response);
        }
    });
}
