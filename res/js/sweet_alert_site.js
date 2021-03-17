//swal alerts
//delete confirmation
function deleteAlert(url) {
//        console.log("Start of delete alert");
    //Warning Message
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this!",
        icon: "warning",
        buttons: ["No, cancel!", "Yes, delete!"],
        dangerMode: true
    }).then((value) => {
    if (value){
        console.log("Go to url: " + url);
        $(location).attr('href', url);
    }else{ /* just close dialogue */ }
});

    //on function start; return false and await user interaction
    return false;
}

//general confirmation
function generalConfirm(url) {
    //Warning Message
    swal({
        title: "Change the status",
        text: "Are you sure?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#EDB143",
        confirmButtonText: "Yes!",
        cancelButtonText: "No!",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm) {
        console.log("Return value is: " + isConfirm);
        if (isConfirm) {
            console.log("Go to url: " + url);
            $(location).attr('href', url);

        } else {
            //just close dialogue
        }
    });

    //on function start; return false and await user interaction
    return false;
}