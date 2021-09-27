const { indexOf } = require("lodash");

var arrValuesOptions = [];

function showFields(id) {
    $.ajax({
        url:  window.location.origin + "/project/getfield/" + id,
        type: "get",
        success: function (response) {
                              
            var arrFields = [];
            for (let index = 0; index < response.length; index++) {
                const element = response[index];
                var arr = {
                    id: element.id,
                    name: element.name,
                    typeField: element.id_type,
                    txtTypeField: element.txtTypeField,
                    validacion: ((element.validacion == 1) ? 'on' : '')
                };
                if (element.id_type == 3 || element.id_type == 4) {                  
                    arr.valuesField = JSON.stringify(arrValuesOptions);
                }
                arrFields.push(arr);  
            }
            $("#str_campos").val(JSON.stringify(arrFields));
            $("#idProjectField").val(id);
            $("#modalAsesores").modal("show");
            poblarDivCampos();
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
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

function poblarValues() {
    var html = '';
    if ($("#typeField").val() == 3) {
        // Unica
        for (let index = 0; index < arrValuesOptions.length; index++) {
            const element = arrValuesOptions[index];
            html += ' <div style="display: flex; height: 40px;"> <div style="width: 10%; display: flex; justify-content: center; align-items: center; flex-direction: row;"> <div style="border: 1px solid #555; width: 13px; height: 13px; cursor: pointer; border-radius: 50%"></div></div><div style="width: 75%;"><input type="text" style="margin-left: 0px !important;     width: 75%" value="' + element.desc + '" class="form-check-input" id="option_1" name="options[]" onkeyup="keyUpValue(event,' + index + ')"></div><div style="width: 15%;"><button type="button" class="btn btn-sm btn-danger" onclick="deleteValues(' + index + ')"><i class="material-icons">delete</i></button></div></div>';
        }
    } else if ($("#typeField").val() == 4) {
        // Multiple
        for (let index = 0; index < arrValuesOptions.length; index++) {
            const element = arrValuesOptions[index];
            html += ' <div style="display: flex; height: 40px;"> <div style="width: 10%; display: flex; justify-content: center; align-items: center; flex-direction: row;"> <div style="border: 1px solid #555; width: 13px; height: 13px; cursor: pointer;"></div></div><div style="width: 75%;"><input type="text" style="margin-left: 0px !important;     width: 75%" value="' + element.desc + '" class="form-check-input" id="option_1" name="options[]" onkeyup="keyUpValue(event,' + index + ')"></div><div style="width: 15%;"><button type="button" class="btn btn-sm btn-danger" onclick="deleteValues(' + index + ')"><i class="material-icons">delete</i></button></div></div>';
        }
    }
    $("#div_values_option").html(html);
}

function keyUpValue(ev, index) {
    arrValuesOptions[index].desc = event.target.value;
}

function deleteValues(index) {
    arrValuesOptions.splice(index, 1);
    poblarValues();
}

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

function addField() {
    var name = $("#nameField").val();
    var typeField = $("#typeField").val();
    var requerido = $('input:checkbox[name=requerido]:checked').val();
    var txtTypeField = $('select[name="typeField"] option:selected').text();
    var validacion = $('input:checkbox[name=validacion]:checked').val();

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
        txtTypeField: txtTypeField,
        validacion: validacion
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

function poblarDivCampos() {
    var arrFields = $("#str_campos").val();
    arrFields = JSON.parse(arrFields);
    console.log(arrFields);
    var indexOf;
    for (let index = 0; index < arrFields.length; index++) {
        const element1 = arrFields[index];
        if(element1.validacion && (element1.validacion == 'on' || element1.validacion == '1')){
            if(Number.isInteger(indexOf)){
                arrFields[indexOf].validacion = "";
                indexOf = index;
            }else{
                indexOf = index;
            }            
        }
    }
    var html = '';
    for (let index = 0; index < arrFields.length; index++) {
        const element = arrFields[index];

        var strValidacion = ((element.validacion && (element.validacion == 'on' || element.validacion == '1')) ? 'Campo de validación' : '');

        var values  = '';
        if (element.typeField == 3) {
            var arrVal = JSON.parse(element.valuesField);
            for (let i = 0; i < arrVal.length; i++) {
                const key = arrVal[i];
                values += key.desc; 
                values += ', ';
            }
        } else if (element.typeField == 4) {
            var arrVal = JSON.parse(element.valuesField);
            for (let i = 0; i < arrVal.length; i++) {
                const key = arrVal[i];
                values += key.desc; 
                values += ', ';
            }
        }else{
             values  = 'No aplica';
        }

        html += '<tr><td>' + element.name + '</td>';
        html += '<td>' + element.txtTypeField + '</td>';
        html += '<td>' + strValidacion + '</td>';
        html += '<td>' + values + '</td></tr>';
    }

    $("#div_cont_campos").html(html);
}

function saveField(){
    var values = {
        "idProject" : $("#idProjectField").val(),
        "arrFields" : $("#str_campos").val()
    };

    $.ajax({
        url:  window.location.origin + "/project/savefield",
        type: "post",
        data: values ,
        success: function (response) {
            Swal.fire(
                'Éxito',
                'Se ha creado con éxito los campos personalizados',
                'success'
              );
              $("#modalAsesores").modal("hide");
           // You will get response from your PHP page (what you echo or print)
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
    
}