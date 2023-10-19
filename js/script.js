function FindFile() {
    document.getElementById('my_hidden_file').click();
}
function LoadFile() {
    document.getElementById('my_hidden_load').click();

}


function onResponse() {
    top.location.href = '';
}

function showErrorMsg(d) {
    // eval('var msg = ' + d + ';');
    // top.location.href = '';
    // alert('crya');
}

