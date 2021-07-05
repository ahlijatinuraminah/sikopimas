function showMessage(data){
    var icon ='';
    if(data.hasil){
        icon = 'success';
        title = 'Sukses';
    }
    else{
        icon = "error";
        title = 'Gagal';
    }

    swal(title, data.message, icon);
}