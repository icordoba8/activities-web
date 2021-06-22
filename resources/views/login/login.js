// $("#form-login").submit(function (event) {
//     event.preventDefault();
//     let json = {
//         email: $("input[name=email]").val(),
//         password: $("input[name=password]").val(),
//     };
//     //{{ env('API_REST',null)}}/login
//     $.ajax({
//         url: "{{ env('API_REST',null)}}/login",
//         type: "POST",
//         data: json,
//         dataType: "JSON",
//     })
//         .done(function (data) {
//             Cookies.set("USER-TOKEN", data.token, { expires: 1 });
//             Cookies.set("USER-ID", data.user_id, { expires: 1 });
//             window.location.href = "/";
//         })
//         .fail(function (data) {
//             const { errors, message } = data.responseJSON;
//             if (errors?.email) {
//                 swal(message, errors.email[0]);
//             }
//             if (message === "Unauthorized") {
//                 swal("", "Datos incorrecto");
//             }
//         });
// });
