var arrValuesOptions = [];

function addField() {
    var name = $("#nameField").val();
    var typeField = $("#typeField").val();
    var requerido = $('input:checkbox[name=requerido]:checked').val();
    var txtTypeField = $('select[name="typeField"] option:selected').text();

    if (!name) {
        Swal.fire(
            'Error',
            'El nombre del campo es requerido',
            'info'
        )
        return;
    }

    if (!typeField) {
        Swal.fire(
            'Error',
            'El tipo de campo es requerido',
            'info'
        )
        return;
    }

    var arr = {
        name: name,
        typeField: typeField,
        requerido: requerido,
        txtTypeField: txtTypeField
    };
    if (typeField == 3 || typeField == 4) {
        if (arrValuesOptions.length == 0) {
            Swal.fire(
                'Error',
                'Los valores son requeridos',
                'info'
            )
            return;
        }
        arr.valuesField = JSON.stringify(arrValuesOptions);
    }

    var arrFields = $("#str_campos").val();
    arrFields = JSON.parse(arrFields);
    arrFields.push(arr);
    $("#str_campos").val(JSON.stringify(arrFields));

    poblarDivCampos();
    $("#nameField").val('');
    $("#typeField").val('');
    arrValuesOptions = [];
    $("#div_values_option").html('');
    $("#div_values_option_2").hide();
}

function addAsesor() {
    var arrAsesores = $("#str_asesores").val();
    arrAsesores = JSON.parse(arrAsesores);
    var idAsesor = $("#idAsesor").val();
    var user = users.find(element => element.id == idAsesor);
    var arr = {
        id: user.id,
        name: user.name,
        last_name: user.last_name,
        email: user.email
    };
    arrAsesores.push(arr);
    $("#str_asesores").val(JSON.stringify(arrAsesores));
    var html = '';
    for (let index = 0; index < arrAsesores.length; index++) {
        const element = arrAsesores[index];
        var btn = '<button type="button" class="btn btn-danger" onclick="deleteAsesor(' + index + ')"><i class="material-icons">delete</i></button>'
        html += '<tr><td>' + element.name + '</td><td>' + element.last_name + '</td><td>' + element.email + '</td><td>' + btn + '</td></tr>';
    }
    $("#tbody_asesores").html(html);
}

function deleteField(index) {
    var arrFields = $("#str_campos").val();
    arrFields = JSON.parse(arrFields);
    arrFields.splice(index, 1);
    $("#str_campos").val(JSON.stringify(arrFields));
    var html = '';
    for (let index = 0; index < arrFields.length; index++) {
        const element = arrFields[index];
        var strRequerido = ((element.requerido && (element.requerido == 'on' || element.requerido == '1')) ? 'Si' : 'No');
        var btn = '<button type="button" class="btn btn-danger" onclick="deleteField(' + index + ')"><i class="material-icons">delete</i></button>'
        //html += '<tr><td>' + name + '</td><td>' + txtTypeField + '</td><td>' + valuesField + '</td><td>' + requerido + '</td><td>' + header + '</td><td>'+btn+'</td></tr>';
        html += '<tr><td>' + element.name + '</td><td>' + element.txtTypeField + '</td><td>' + ((element.valuesField) ? element.valuesField : 'No aplica') + '</td><td>' + strRequerido + '</td><td>' + btn + '</td></tr>';
    }
    $("#tbody_fields").html(html);
}

function deleteAsesor(index) {
    var arrAsesores = $("#str_asesores").val();
    arrAsesores = JSON.parse(arrAsesores);
    arrAsesores.splice(index, 1);
    // arrAsesores.push(arr);
    $("#str_asesores").val(JSON.stringify(arrAsesores));
    var html = '';
    for (let index = 0; index < arrAsesores.length; index++) {
        const element = arrAsesores[index];
        var btn = '<button type="button" class="btn btn-danger" onclick="deleteAsesor(' + index + ')"><i class="material-icons">delete</i></button>';
        html += '<tr><td>' + element.name + '</td><td>' + element.last_name + '</td><td>' + element.email + '</td><td>' + btn + '</td></tr>';
    }
    $("#tbody_asesores").html(html);
}

function showAsesor() {
    var arrAsesores = $("#str_asesores").val();
    arrAsesores = JSON.parse(arrAsesores);
    var html = '';
    for (let index = 0; index < arrAsesores.length; index++) {
        const element = arrAsesores[index];
        var btn = '<button type="button" class="btn btn-danger" onclick="deleteAsesor(' + index + ')"><i class="material-icons">delete</i></button>';
        html += '<tr><td>' + element.name + '</td><td>' + element.last_name + '</td><td>' + element.email + '</td><td>' + btn + '</td></tr>';
    }
    $("#tbody_asesores").html(html);
    $("#modalAsesores").modal("show");
}

$("#typeField").change(function () {
    $("#div_values_option").html('');
    arrValuesOptions = [];
    if ($("#typeField").val() == 3) {
        $("#div_values_option_2").show();
        arrValuesOptions.push({ 'desc': 'Si', 'id': 1 });
        arrValuesOptions.push({ 'desc': 'No', 'id': 2 });
        // Unica
        poblarValues();
    } else if ($("#typeField").val() == 4) {
        $("#div_values_option_2").show();
        arrValuesOptions.push({ 'desc': 'Opcion 1', 'id': 1 });
        arrValuesOptions.push({ 'desc': 'Opcion 2', 'id': 2 });
        arrValuesOptions.push({ 'desc': 'Opcion 3', 'id': 3 });
        // Multiple
        poblarValues();
    } else {
        $("#div_values_option_2").hide();
    }
});

function addOption() {
    if ($("#typeField").val() == 3) {
        arrValuesOptions.push({ 'desc': 'Si', 'id': 1 });
        // Unica
    } else if ($("#typeField").val() == 4) {
        arrValuesOptions.push({ 'desc': 'Opcion 1', 'id': 1 });
        // Multiple
    }
    poblarValues();
}

function deleteValues(index) {
    arrValuesOptions.splice(index, 1);
    poblarValues();
}

function keyUpValue(ev, index) {
    arrValuesOptions[index].desc = event.target.value;
}

function poblarValues() {
    var html = '';
    if ($("#typeField").val() == 3) {
        // Unica
        for (let index = 0; index < arrValuesOptions.length; index++) {
            const element = arrValuesOptions[index];
            html += ' <div style="display: flex; height: 40px;"> <div style="width: 10%; display: flex; justify-content: center; align-items: center; flex-direction: row;"> <div style="border: 1px solid #555; width: 13px; height: 13px; cursor: pointer; border-radius: 50%"></div></div><div style="width: 75%;"><input type="text" style="margin-left: 0px !important;" value="' + element.desc + '" class="form-check-input" id="option_1" name="options[]" onkeyup="keyUpValue(event,' + index + ')"></div><div style="width: 15%;"><button type="button" class="btn btn-danger" onclick="deleteValues(' + index + ')"><i class="material-icons">delete</i></button></div></div>';
        }
    } else if ($("#typeField").val() == 4) {
        // Multiple
        for (let index = 0; index < arrValuesOptions.length; index++) {
            const element = arrValuesOptions[index];
            html += ' <div style="display: flex; height: 40px;"> <div style="width: 10%; display: flex; justify-content: center; align-items: center; flex-direction: row;"> <div style="border: 1px solid #555; width: 13px; height: 13px; cursor: pointer;"></div></div><div style="width: 75%;"><input type="text" style="margin-left: 0px !important;" value="' + element.desc + '" class="form-check-input" id="option_1" name="options[]" onkeyup="keyUpValue(event,' + index + ')"></div><div style="width: 15%;"><button type="button" class="btn btn-danger" onclick="deleteValues(' + index + ')"><i class="material-icons">delete</i></button></div></div>';
        }
    }
    $("#div_values_option").html(html);
}


function poblarDivCampos() {
    loadingStart();
    var arrFields = $("#str_campos").val();
    arrFields = JSON.parse(arrFields);
    var html = '';

    var qNumber = 1;
    for (let index = 0; index < arrFields.length; index++) {
        const element = arrFields[index];
        var strRequerido = ((element.requerido && (element.requerido == 'on' || element.requerido == '1')) ? 'Si' : 'No');
        html += '<div style="width: 96%; background-color: #E9E9E9; margin-left: 2%; margin-top: 10px; border-radius: 5px;"><div style="display: flex; padding: 0 2%; flex-direction: column;">';
        if (index > 0) {
            html += '<div style="display: flex; justify-content: center;"><i onclick="changePosition(' + index + ', 1)" style="width: 100px; background-color: #D7D7D7; text-align: center; cursor: pointer;" class="fas fa-chevron-up"></i></div>';
        }
        html += '<div style="display: flex;"><div style="display: flex; justify-content: center; align-items: center; width: 5%;">';
        html += 'Q' + qNumber + '</div><div style="display: flex; flex-direction: column; justify-content: start; width: 100%"><div>' + element.name + '</div><div style="width: 50%;">';

        if (element.typeField == 3) {
            var arrVal = JSON.parse(element.valuesField);
            for (let i = 0; i < arrVal.length; i++) {
                const key = arrVal[i];
                html += '<div style="display: flex; height: 40px;"><div style="width: 10%; display: flex; justify-content: center; align-items: center; flex-direction: row;"><div style="border: 1px solid #555; width: 13px; height: 13px; cursor: pointer; border-radius: 50%"></div></div>';
                html += '<div style="width: 75%;"><input type="text" style="margin-left: 0px !important;" value="' + key.desc + '" class="form-check-input" id="option_" name="options2[]" ></div></div>';
            }
        } else if (element.typeField == 4) {
            var arrVal = JSON.parse(element.valuesField);
            for (let i = 0; i < arrVal.length; i++) {
                const key = arrVal[i];
                html += '<div style="display: flex; height: 40px;"><div style="width: 10%; display: flex; justify-content: center; align-items: center; flex-direction: row;"><div style="border: 1px solid #555; width: 13px; height: 13px; cursor: pointer;"></div></div>';
                html += '<div style="width: 75%;"><input type="text" style="margin-left: 0px !important;" value="' + key.desc + '" class="form-check-input" id="option_" name="options2[]" ></div></div>';
            }
        } else if (element.typeField == 1) {
            html += '<input class="form-control">';
        } else if (element.typeField == 2 || element.typeField == 6) {
            html += '<input class="form-control" type="number">';
        } else if (element.typeField == 5) {
            html += '<input class="form-control">';
        } else if (element.typeField == 7) {
            html += '<p class="clasificacion"><input id="radio1" type="radio" name="estrellas" value="5"><label for="radio1">★</label><input id="radio2" type="radio" name="estrellas" value="4"><label for="radio2">★</label><input id="radio3" type="radio" name="estrellas" value="3"><label for="radio3">★</label><input id="radio4" type="radio" name="estrellas" value="2"><label for="radio4">★</label><input id="radio5" type="radio" name="estrellas" value="1"><label for="radio5">★</label></p>';
        }
        
        html += '</div><div>Campo obligatorio: <b>' + strRequerido + '</b></div></div></div>';
        if (index > 0 && (arrFields.length - 1) > index) {
            html += '<div style="display: flex; justify-content: center;"><i onclick="changePosition(' + index + ', 2)" style="width: 100px; background-color: #D7D7D7; text-align: center; cursor: pointer;" class="fas fa-chevron-down"></i></div>';
        }
        html += '</div></div>';
        qNumber++;
    }

    $("#div_cont_campos").html(html);
    loadingStop();
}

function loadingStart() {
    $("#div_cont_campos").loading({
        stoppable: false,
        message: "Cargando...",
        theme: "dark"
    });
}

function loadingStop() {
    $(":loading").loading("stop");
}

function changePosition(index, type) {
    var arrFields = $("#str_campos").val();
    var arrSort = $("#str_campos").val();
    arrFields = JSON.parse(arrFields);
    arrSort = JSON.parse(arrSort);
    if (type == 1) {
        // Subir
        arrSort[index - 1] = arrFields[index];
        arrSort[index] = arrFields[index - 1];
    } else if (type == 2) {
        // Bajar
        arrSort[index + 1] = arrFields[index];
        arrSort[index] = arrFields[index + 1];
    }
    $("#str_campos").val(JSON.stringify(arrSort));
    poblarDivCampos();
}