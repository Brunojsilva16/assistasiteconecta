const container = document.querySelector(".container");
const loginForm = document.querySelector('.login-form')
const RegisterForm = document.querySelector('.Register-form');
const RegiBtn = document.querySelector('.RegiBtn');
const LoginBtn = document.querySelector('.LoginBtn');
RegiBtn.addEventListener('click', () => {
  RegisterForm.classList.add('active');
  loginForm.classList.add('active')
})
LoginBtn.addEventListener('click', () => {
  RegisterForm.classList.remove('active');
  loginForm.classList.remove('active')
})

const formLogin = document.getElementById("frm_login");
formLogin.addEventListener("submit", function (e) {
  e.preventDefault();

  const loginForm = new FormData(formLogin, e.submitter);
  
  let datLocate = './sqls/verifica_loginM.php';


  $.ajax({
    method: 'POST',
    data: loginForm,
    url: datLocate,
    contentType: false,
    cache: false,
    processData: false,
    dataType: 'json',
    // beforeSend: function () {
    //   $(".carregando").html('Aguarde, processando requisição...');
    //   $(".resultadoLoading").html("<img src='./assets/img/loading03.gif' style='width: 50%;'>");
    // },
    success: function (result) {
      if (result.error) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: result.message,
          footer: '<span style="font-size: 12px; color:brown">Verifique também o nível de acesso</span>'
        });

      } else {
        window.location.href = "dashboard";

      }

    }

  });


  // if (validarFormulario()) {

  //   console.log('passou')

  // $.ajax({
  //   method: 'POST',
  //   url: './sqls/verifica_login.php',
  //   data: {data: 12, id: "450"},
  //   contentType: false,
  //   cache: false,
  //   processData: false,
  //   dataType: 'json',
  //   // beforeSend: function () {
  //   //   $(".carregando").html('Aguarde, processando requisição...');
  //   //   $(".resultadoLoading").html("<img src='./assets/img/loading03.gif' style='width: 50%;'>");
  //   // },
  //   success: function (response) {
  //     // $(".carregando").html('');
  //     // $(".resultadoLoading").html('');

  //     if (response.error) {
  //       Swal.fire({
  //         icon: "error",
  //         title: "Oops...",
  //         text: response.message,
  //         // footer: '<a href="#">Why do I have this issue?</a>'
  //       });
  //       console.log('Erro não sucedido');
  //     }
  //     else {
  //       console.log('bem sucedido');
  //       window.location.href = "dashboard.php";

  //     }
  //   }
  // });

  // } else {

  //   Swal.fire({
  //     icon: "error",
  //     text: "Verifique os campos do formulário!",
  //   });
  //   // $(".swal2-confirm").css('background-color', '#AF2846');
  // }

});


function validarFormulario() {

  var email = document.getElementById('login-Email');
  var senha = document.getElementById('login-senha');
  // var email = $("#inputEmail").val();

  // var senha = $("#inputSenha").val();

  if (email.value == 'null' || email.value == '') {
    document.getElementById('labelEmail').innerHTML = "<span class='text-danger'>Email Inválido</span>";

    return false;
  } else {
    document.getElementById('labelEmail').innerHTML = "Email";
  }

  if (senha.value == 'null' || senha.value == '') {
    document.getElementById('labelSenha').innerHTML = "<span class='text-danger'>Nome Inválido</span>";
    return false;
  } else {
    document.getElementById('labelSenha').innerHTML = "Nome";
  }

  return true;
}