$(document).ready(function () {
  const sidebarLinks = document.querySelectorAll(".sidebar ul li");
  // const pages = document.querySelectorAll(".page");
  // console.log(sidebarLinks);
  // console.log(pages);

  sidebarLinks.forEach((link) => {
    link.addEventListener("click", (event) => {
      event.preventDefault();

      const pageId = link.dataset.page;

      // pages.forEach((page) => {
      //   page.classList.remove("active");
      // });

      // document.getElementById(pageId).classList.add("active");
      //   console.log(pageId);

      var id = pageId;
      getpage(id);
    });

    // getpage(pageId);
  });

  $("ul li").on("click", function () {
    $("li").removeClass("active");
    $(this).addClass("active");


  });

  getpage("im_inscricao");
});

function getpage(id) {

  switch (id) {

    case "im_inscricao":
      fetchdados("./sqls/fetch_inscr.php", "./sqls/fetch_status.php");
      break;
    case "im_pendente":
      fetchdados("./sqls/fetch_pend.php", false);
      break;
    case "im_confirmado":
      fetchdados("./sqls/fetch_conf.php", false);
      break;
    case "im_cupom":
      fetchdados("./sqls/fetch_cupom.php", false);
      break;

    case "wk_inscricao":
      fetchdados("./sqls/fetchWk_inscr.php", "./sqls/fetchWk_status.php");
      break;
    case "wk_pendente":
      fetchdados("./sqls/fetchWk_pend.php", false);
      break;
    case "wk_confirmado":
      fetchdados("./sqls/fetchWk_conf.php", false);
      break;

    case "pf_inscricao":
      fetchdados("./sqls/fetchPf_inscr.php", "./sqls/fetchPf_status.php");
      break;
    case "pf_pendente":
      fetchdados("./sqls/fetchPf_pend.php", false);
      break;
    case "pf_confirmado":
      fetchdados("./sqls/fetchPf_conf.php", false);
      break;


    case "logout":
      window.location.href = "./logout";
      break;

    default:
      fetchdados("./sqls/fetch_inscr.php", "./sqls/fetch_status.php");
      break;
  }
}

function fetchdados(getval, callget) {
  const elementtwo = document.getElementById("flexCard");
  elementtwo.innerText = "";

  $.get(getval, function (retorna) {
    $("#flexCard").html(retorna);

    if (callget) {
      fetchPanelDados(callget);
    }
  });
}

function fetchPanelDados(data) {
  $.ajax({
    method: "POST",
    url: data,
    contentType: false,
    cache: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      // console.log(response);
      // response.forEach((element) => console.log(element));
      $(".inscritos").text(response.total_count);
      $(".confirmados").text(response.confirmado_count);
      $(".pendentes").text(response.null_count);
      $(".cancelados").text(response.cancelado_count);
      // $('#tableResult').html(response);
    },
  });
}

function get_delete(ddel) {
  var dataBd = $(ddel).attr("data-bd");
  var dataIdbd = $(ddel).attr("data-idbd");
  var dataIdreg = $(ddel).attr("data-id");
  var idpage = $(ddel).attr("data-page");

  Swal.fire({
    title: "Deseja excluir a inscrição!",
    // text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#198754",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "./sqls/delete_all.php",
        data: { banco: dataBd, idbanco: dataIdbd, idreg: dataIdreg },
        // contentType: false,
        cache: false,
        // processData: false,
        dataType: "json",
        beforeSend: function () {
          $(".carregando").html("Aguarde, processando requisição...");
          $(".resultadoLoading").html(
            "<img src='./assets/img/loading03.gif' style='width: 100%;'>"
          );
        },
        success: function (response) {
          
          $(".carregando").html("");
          $(".resultadoLoading").html("");
          
          if (response.error) {

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: response.message,
              // footer: '<a href="#">Why do I have this issue?</a>'
            });

          } else {

            Swal.fire({
              position: "top-end",
              icon: "success",
              title: "Alteração",
              text: response.message,
              showConfirmButton: false,
              timer: 1500,

              willClose: () => {
                  getpage(idpage);
              },

            });
          }
        },
      });
    }
  });
}

function get_param(el) {
  var dataId = $(el).attr("data-id");
  var dataVal = $(el).attr("data-v");
  var datap = $(el).attr("data-p");

  if (dataVal != "Confirmado") {
    var texto = "Cancelar a inscrição?";
  } else {
    var texto = "Confirmar a inscrição?";
  }

  Swal.fire({
    title: texto,
    // text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#198754",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "./sqls/update_mod.php",
        data: { codparceiro: dataId, status: dataVal },
        // contentType: false,
        cache: false,
        // processData: false,
        dataType: "json",
        beforeSend: function () {
          $(".carregando").html("Aguarde, processando requisição...");
          $(".resultadoLoading").html(
            "<img src='./assets/img/loading03.gif' style='width: 100%;'>"
          );
        },
        success: function (response) {

          $(".carregando").html("");
          $(".resultadoLoading").html("");

          if (response.error) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: response.message,
              // footer: '<a href="#">Why do I have this issue?</a>'
            });
          } else {
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: "Alteração",
              text: response.message,
              footer: "Cadastro confirmado!",
              showConfirmButton: false,
              timer: 1500,

              willClose: () => {
                if (datap != "1") {
                  fetchdados("./sqls/fetch_inscr.php", "./sqls/fetch_status.php");
                }else {
                  fetchdados("./sqls/fetch_pend.php", false);
                }
              },

            });
          }
        },
      });
    }
  });
}

function get_crachParam(el) {
  var valid = $(el).attr("data-id");
  var namee = $(el).attr("data-nome");

  const palavras = namee.split(" ");
  const primeiraPalavra = palavras[0];

  $.ajax({
    method: "POST",
    url: "./sqls/fetch_cracha.php",
    data: { id: valid, nome: namee },
    success: function (response) {
      // console.log(response);

      if (response.error) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: response.message,
          // footer: '<a href="#">Why do I have this issue?</a>'
        });
      } else {
        Swal.fire({
          // icon: "error",
          // title: "Oops...11",
          showConfirmButton: false,
          html: response,
          footer:
            '<button id="btn_download" class="btn btn-outline-success">Download</button>',
        });

        // Seletor para a div que você deseja salvar
        const divToDownload = document.querySelector("#crachar_download");

        // Seletor para o botão de download
        const downloadButton = document.getElementById("btn_download");

        downloadButton.addEventListener("click", downloadDivAsImage);

        function downloadDivAsImage() {
          // Crie um elemento de imagem
          const image = document.createElement("img");

          console.log(divToDownload);

          // Converta a div em uma imagem usando o DOMtoImage
          domtoimage
            .toPng(divToDownload)
            .then(function (dataUrl) {
              // Defina o atributo 'src' da imagem
              image.src = dataUrl;

              // Crie um link para download
              const link = document.createElement("a");
              link.href = dataUrl;
              link.download = "Qrcode_" + primeiraPalavra + ".jpg";

              // Anexe a imagem ao link
              link.appendChild(image);

              // Simule um clique no link para iniciar o download
              link.click();
            })
            .catch(function (error) {
              console.error("Erro ao converter a div em imagem:", error);
            });
        }
      }
    },
  });
}

function getPf_param(el) {
  var dataId = $(el).attr("data-id");
  var dataVal = $(el).attr("data-v");
  var datap = $(el).attr("data-p");

  if (dataVal != "Confirmado") {
    var texto = "Cancelar a inscrição?";
  } else {
    var texto = "Confirmar a inscrição?";
  }

  Swal.fire({
    title: texto,
    // text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#198754",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "./sqls/updatePf_mod.php",
        data: { codparceiro: dataId, status: dataVal },
        // contentType: false,
        cache: false,
        // processData: false,
        dataType: "json",
        beforeSend: function () {
          $(".carregando").html("Aguarde, processando requisição...");
          $(".resultadoLoading").html(
            "<img src='./assets/img/loading03.gif' style='width: 100%;'>"
          );
        },
        success: function (response) {

          $(".carregando").html("");
          $(".resultadoLoading").html("");

          if (response.error) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: response.message,
              // footer: '<a href="#">Why do I have this issue?</a>'
            });
          } else {
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: "Alteração",
              text: response.message,
              footer: "Cadastro confirmado!",
              showConfirmButton: false,
              timer: 1500,

              willClose: () => {
                if (datap != "1") {
                  fetchdados("./sqls/fetchPf_inscr.php", "./sqls/fetchPf_status.php");
                }else {
                  fetchdados("./sqls/fetchPf_pend.php", false);
                }
              },

            });
          }
        },
      });
    }
  });
}

function getWk_param(el) {
  var dataId = $(el).attr("data-id");
  var dataVal = $(el).attr("data-v");
  var datap = $(el).attr("data-p");

  if (dataVal != "Confirmado") {
    var texto = "Cancelar a inscrição?";
  } else {
    var texto = "Confirmar a inscrição?";
  }

  Swal.fire({
    title: texto,
    // text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#198754",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "./sqls/updateWk_mod.php",
        data: { codparceiro: dataId, status: dataVal },
        // contentType: false,
        cache: false,
        // processData: false,
        dataType: "json",
        beforeSend: function () {
          $(".carregando").html("Aguarde, processando requisição...");
          $(".resultadoLoading").html(
            "<img src='./assets/img/loading03.gif' style='width: 100%;'>"
          );
        },
        success: function (response) {

          $(".carregando").html("");
          $(".resultadoLoading").html("");

          if (response.error) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: response.message,
              // footer: '<a href="#">Why do I have this issue?</a>'
            });
          } else {
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: "Alteração",
              text: response.message,
              footer: "Cadastro confirmado!",
              showConfirmButton: false,
              timer: 1500,

              willClose: () => {
                if (datap != "1") {
                  fetchdados("./sqls/fetchWk_inscr.php", "./sqls/fetchWk_status.php");
                }else {
                  fetchdados("./sqls/fetchWk_pend.php", false);
                }
              },

            });
          }
        },
      });
    }
  });
}
function getWk_param(el) {
  var dataId = $(el).attr("data-id");
  var dataVal = $(el).attr("data-v");
  var datap = $(el).attr("data-p");

  if (dataVal != "Confirmado") {
    var texto = "Cancelar a inscrição?";
  } else {
    var texto = "Confirmar a inscrição?";
  }

  Swal.fire({
    title: texto,
    // text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#198754",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "./sqls/updateWk_mod.php",
        data: { codparceiro: dataId, status: dataVal },
        // contentType: false,
        cache: false,
        // processData: false,
        dataType: "json",
        beforeSend: function () {
          $(".carregando").html("Aguarde, processando requisição...");
          $(".resultadoLoading").html(
            "<img src='./assets/img/loading03.gif' style='width: 100%;'>"
          );
        },
        success: function (response) {

          $(".carregando").html("");
          $(".resultadoLoading").html("");

          if (response.error) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: response.message,
              // footer: '<a href="#">Why do I have this issue?</a>'
            });
          } else {
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: "Alteração",
              text: response.message,
              footer: "Cadastro confirmado!",
              showConfirmButton: false,
              timer: 1500,

              willClose: () => {
                if (datap != "1") {
                  fetchdados("./sqls/fetchWk_inscr.php", "./sqls/fetchWk_status.php");
                }else {
                  fetchdados("./sqls/fetchWk_pend.php", false);
                }
              },

            });
          }
        },
      });
    }
  });
}

function get_crachParam(el) {
  var valid = $(el).attr("data-id");
  var namee = $(el).attr("data-nome");

  const palavras = namee.split(" ");
  const primeiraPalavra = palavras[0];

  $.ajax({
    method: "POST",
    url: "./sqls/fetch_cracha.php",
    data: { id: valid, nome: namee },
    success: function (response) {
      // console.log(response);

      if (response.error) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: response.message,
          // footer: '<a href="#">Why do I have this issue?</a>'
        });
      } else {
        Swal.fire({
          // icon: "error",
          // title: "Oops...11",
          showConfirmButton: false,
          html: response,
          footer:
            '<button id="btn_download" class="btn btn-outline-success">Download</button>',
        });

        // Seletor para a div que você deseja salvar
        const divToDownload = document.querySelector("#crachar_download");

        // Seletor para o botão de download
        const downloadButton = document.getElementById("btn_download");

        downloadButton.addEventListener("click", downloadDivAsImage);

        function downloadDivAsImage() {
          // Crie um elemento de imagem
          const image = document.createElement("img");

          console.log(divToDownload);

          // Converta a div em uma imagem usando o DOMtoImage
          domtoimage
            .toPng(divToDownload)
            .then(function (dataUrl) {
              // Defina o atributo 'src' da imagem
              image.src = dataUrl;

              // Crie um link para download
              const link = document.createElement("a");
              link.href = dataUrl;
              link.download = "Qrcode_" + primeiraPalavra + ".jpg";

              // Anexe a imagem ao link
              link.appendChild(image);

              // Simule um clique no link para iniciar o download
              link.click();
            })
            .catch(function (error) {
              console.error("Erro ao converter a div em imagem:", error);
            });
        }
      }
    },
  });
}
