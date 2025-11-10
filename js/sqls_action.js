$(document).ready(function () {

    $('.btn_status').on('click', function (e) {
        e.preventDefault();

        alert('at');

        const vall = $(this).data('v');

        console.log(vall);
    });

});

// function updatStatus(val, id) {

//     console.log(val, id);

//     if (val) {

//         Swal.fire({
//             title: "Are you sure?",
//             text: "You won't be able to revert this!",
//             icon: "warning",
//             showCancelButton: true,
//             confirmButtonColor: "#3085d6",
//             cancelButtonColor: "#d33",
//             confirmButtonText: "Yes, delete it!"
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 Swal.fire({
//                     title: "Deleted!",
//                     text: "Your file has been deleted.",
//                     icon: "success"
//                 });
//             }
//         });
//     }
// }