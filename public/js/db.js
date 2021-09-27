function addBD() {
    $("#modalAsesores").modal("show");
}

function importModal() {
    $("#modalImport").modal("show");
}

var csvjsonConverter = (csvdata, delimiter) => {
    let arrmatch = [];
    let array = [[]];
    let quotevals = "";
    let k = 0;

    let regexp = new RegExp(("(\\" + delimiter + "|\\r?\\n|\\r|^)" + "(?:\"([^\"]*(?:\"\"[^\"]*)*)\"|" +
        "([^\"\\" + delimiter + "\\r\\n]*))"), "gi");

    while (arrmatch = regexp.exec(csvdata)) {
        let delimitercheck = arrmatch[1];
        if ((delimitercheck !== delimiter) && delimitercheck.length) {
            array.push([]);
        }

        if (arrmatch[2]) {
            quotevals = arrmatch[2].replace('""', '\"');
        }
        else {
            quotevals = arrmatch[3];
        }
        array[array.length - 1].push(quotevals);
    }
    console.log(array);

    let formatjson = JSON.stringify(array, null, 2);
    return formatjson;
};

function selectProjectImport() {
    $.ajax({
        url: window.location.origin + "/project/getfield/" + $("#idProjectImport").val(),
        type: "get",
        success: function (response) {
            console.log(response);
            fields = response;

            var html = '<table class="table table-bordred table-striped"><thead id="theadDB"><tr><td style="text-align: center" colspan="' + response.length + '">Campos disponibles</td></tr></thead><tbody id="tbody_fields"><tr>';
            for (let index = 0; index < response.length; index++) {
                const element = response[index];
                html += '<th>' + element.name + '</th>';
            }
            html += '</tr></tbody></table>';
            $("#divCamposImport").html(html);
            loadCsv();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });

}

function loadCsv() {
    var idProjectImport = $("#idProjectImport").val();
    var separador = $("#separador").val();
    var csv = $("#fileImport")[0].files[0];
    if (csv && idProjectImport != "" && separador != "") {
        readURL();
    } else {
        //alert("validacion");
    }
}
var convertjson;
function readURL() {
    var csv = $("#fileImport")[0].files[0];
    var reader = new FileReader();
    reader.onload = function (e) {
        var rows = e.target.result;
        convertjson = csvjsonConverter(rows, $("#separador").val());
        //  console.log(convertjson);
        loadDataCsvTable(convertjson);
        //var convertjson = csvjsonConverter(rows, $("#delimiter").val());
        //$("#json").val(convertjson);
    };
    reader.readAsText(csv);
}

function loadDataCsvTable(data) {
    data = JSON.parse(data);
    console.log(data);
    console.log(data.length);
    var letter = "A";
    //   var html1 = '<table class="table table-bordred table-striped"><thead id="theadDB"><tr><td style="text-align: center" colspan="'+response.length+'">Campos disponibles</td></tr></thead><tr>';
    var html = '<table class="table table-bordred table-striped">';
    var optionStr = '<option>Seleccione</option>';
    for (let index = 0; index < data.length; index++) {
        const element = data[index];
        // console.log(element);           
        if (index == 0) {
            html += '<thead id="theadDB"><tr><th style="text-align: center" colspan="' + element.length + '">Datos del archivo</th></tr></thead>';
            html += '<tr>';
            for (let index1 = 0; index1 < element.length; index1++) {
                const element1 = element[index1];
                if (index1 == 0) {
                    html += nextLetter(letter, element.length);
                    optionStr += nextLetterOption(letter, element.length);
                }
                //console.log(element1);
                html += '<td>' + element1 + '</td>';
            }
            html += '</tr>';
        } else {
            if (index < 2) {
                html += '<tr>';
                for (let index1 = 0; index1 < element.length; index1++) {
                    const element1 = element[index1];
                    html += '<td>' + element1 + '</td>';
                }
                html += '</tr>';
            }
        }
        // html += '<th>' + element.name +'</th>' ;
    }
    //html += '</tr></table>';
    html += '</table>';
    //  console.log(html);
    $("#divDataImport").html(html);

    var html = '<table class="table table-bordred table-striped"><thead id="theadDB"><tr><td style="text-align: center" colspan="' + fields.length + '">Campos disponibles</td></tr></thead><tbody id="tbody_fields"><tr>';
    var htmlTr = '<tr>';
    for (let index = 0; index < fields.length; index++) {
        const element = fields[index];
        html += '<th>' + element.name + '</th>';
        console.log(element);
        htmlTr += '<td><select name="' + element.name_id + '" id="' + element.name_id + '" onchange="loadFields(' + index + ',\'' + element.name_id + '\')">';
        htmlTr += optionStr;
        htmlTr += '</select></td>';
        // html += '<th>' + element.name +'</th>' ;
    }
    htmlTr += '</tr>';
    html += '</tr></tbody></table>';



    $("#divCamposImport").html(html);


    $('#tbody_fields tr:last').after(htmlTr);


}

function loadFields(index, maneId) {
    //        console.log(maneId);
    //console.log($("#"+maneId).val());

    var arr = {
        nameId: maneId,
        index: index,
        value: $("#" + maneId).val()
    };

    var arrFields = $("#sltFields").val();
    arrFields = JSON.parse(arrFields);
    var idx = arrFields.findIndex(element => element.index == index);
    if (idx == -1) {
        arrFields.push(arr);
    } else {
        arrFields[idx] = {
            nameId: maneId,
            index: index,
            value: $("#" + maneId).val()
        };
    }



    console.log(arrFields);
    $("#sltFields").val(JSON.stringify(arrFields));


}

getNextKey = function (key) {
    if (key === 'Z' || key === 'z') {
        return String.fromCharCode(key.charCodeAt() - 25) + String.fromCharCode(key.charCodeAt() - 25); // AA or aa
    } else {
        var lastChar = key.slice(-1);
        var sub = key.slice(0, -1);
        if (lastChar === 'Z' || lastChar === 'z') {
            // If a string of length > 1 ends in Z/z,
            // increment the string (excluding the last Z/z) recursively,
            // and append A/a (depending on casing) to it
            return getNextKey(sub) + String.fromCharCode(lastChar.charCodeAt() - 25);
        } else {
            // (take till last char) append with (increment last char)
            return sub + String.fromCharCode(lastChar.charCodeAt() + 1);
        }
    }
    return key;
};

function nextLetter(letter, length) {
    var str = "<tr>";
    for (let index1 = 0; index1 < length; index1++) {
        str += '<th>Columna: ';
        str += letter;
        str += '</th>';
        letter = getNextKey(letter);
    }
    str += '</tr>';
    return str;
}

function nextLetterOption(letter, length) {
    var optionStr = "";
    for (let index1 = 0; index1 < length; index1++) {
        optionStr += '<option value="' + letter + '">Columna: ' + letter + '</option>';
        letter = getNextKey(letter);
    }
    return optionStr;
}



var fields;
function selectProject() {
    $("#idProject").val();

    $.ajax({
        url: window.location.origin + "/project/getfield/" + $("#idProject").val(),
        type: "get",
        success: function (response) {
            console.log(response);
            fields = response;
            var html = '';
            for (let index = 0; index < response.length; index++) {
                const element = response[index];
                html += '<div class="form-group cls_div_campo">';
                html += '<div class="cls_width_50">';

                switch (element.id_type) {
                    case 1:
                    case 2:
                        html += '<label for="' + element.name_id + '">' + element.name + ' ';
                        if (element.validacion && element.validacion == 1) {
                            html += '<span style="color: red">*</span></label>';
                        } else {
                            html += '</label></div>';
                        }
                        html += '<input value="" type="' + ((element.id_type == 1) ? "text" : "number") + '" name="' + element.name_id + '" id="' + element.name_id + '" class="form-control input-sm cls_width_50" placeholder="' + element.name + '"></div></div>';
                        break;
                    case 3:
                        html += '<label for="' + element.name_id + '">' + element.name + ' ';
                        if (element.validacion && element.validacion == 1) {
                            html += '<span style="color: red">*</span></label>';
                        } else {
                            html += '</label></div>';
                        }
                        html += '<div class="form-check cls_width_50" style="padding-left: inherit;">';
                        var dataValues = element.values.split(',');
                        for (let index2 = 0; index2 < dataValues.length; index2++) {
                            const element2 = dataValues[index2];
                            html += '<div class="radio" style="margin-right: 10px;">';
                            html += '<label><input type="radio" value="' + element2.trim() + '" name="' + element2.name_id + '" id="' + element2.name_id + '" style="margin-right: 5px;">' + element2.trim() + '</label>';
                            html += '</div>';
                        }
                        html += '</div></div>';
                        break;
                    case 4:
                        html += '<label for="' + element.name_id + '">' + element.name + ' ';
                        if (element.validacion && element.validacion == 1) {
                            html += '<span style="color: red">*</span></label>';
                        } else {
                            html += '</label></div>';
                        }
                        var dataValues = element.values.split(',');
                        for (let index3 = 0; index3 < dataValues.length; index3++) {
                            const element3 = dataValues[index3];
                            html += '<div class="form-check cls_width_50">';
                            html += '<input type="checkbox"  value="' + element3.trim() + '" name="' + element.name_id + '[]" id="' + element3.trim() + '">';
                            html += '<label class="form-check-label" for="' + element3.trim() + '">' + element3.trim() + '</label></div>';
                        }
                        html += '</div>';
                        break;
                    case 5:
                    case 6:
                        html += '<label for="' + element.name_id + '">' + element.name + ' ';
                        if (element.validacion && element.validacion == 1) {
                            html += '<span style="color: red">*</span></label>';
                        } else {
                            html += '</label></div>';
                        }
                        html += '<input value="" type="' + ((element.id_type == 5) ? "date" : "tel") + '" name="' + element.name_id + '" id="' + element.name_id + '" class="form-control input-sm cls_width_50" placeholder="' + element.name + '"></div></div>';
                        break;
                    default:
                        break;
                }
            }
            $("#divCampos").html(html);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });

}

function saveImport() {
    console.log(convertjson);
    $("#sltFields").val()
    $("#idProjectImport").val()
    $("#separador").val()
    convertjson
    var data = {
        "idProjectImport": $("#idProjectImport").val(),
        "separador": $("#separador").val(),
        "sltFields": $("#sltFields").val(),
        "json": convertjson,
    };
    $.ajax({
        url: window.location.origin + "/db/savedbimport",
        type: "post",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: data,
        success: function (response) {
            console.log(response);
            Swal.fire({
                title: 'Éxito',
                text: "Se ha cargado con éxito el archivo",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
            }).then((result) => {
                location.reload();
            })
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseJSON.msg);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: jqXHR.responseJSON.msg,
            })
        }
    });
}

function save() {

    if (!$("#name").val()) {
        Swal.fire(
            'Error',
            'El nombre es obligatorio',
            'info'
        )
        return;
    }

    if (!$("#name").val()) {
        Swal.fire(
            'Error',
            'El nombre es obligatorio',
            'info'
        )
        return;
    }
    if (!$("#lastName").val()) {
        Swal.fire(
            'Error',
            'El apellido es obligatorio',
            'info'
        )
        return;
    }
    if (!$("#id_type_identification").val()) {
        Swal.fire(
            'Error',
            'El tipo de identificación es obligatorio',
            'info'
        )
        return;
    }
    if (!$("#number_identification").val()) {
        Swal.fire(
            'Error',
            'El múmero de identificación es obligatorio',
            'info'
        )
        return;
    }

    var $form = $("#formDB");
    var data = getFormData($form);
    $.ajax({
        url: window.location.origin + "/db/savedb/" + $("#idProject").val(),
        type: "post",
        data: data,
        success: function (response) {
            console.log(response);
            Swal.fire({
                title: 'Éxito',
                text: "Se ha creado con éxito el cliente",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Crear otro',
                cancelButtonText: 'Cerrar'
            }).then((result) => {
                console.log(result);
                if (result.isConfirmed) {
                    swal.close();
                    $("#name").val()
                    $("#lastName").val()
                    $("#id_type_identification").val('').change();
                    $("#idProject").val('').change();
                    $("#number_identification").val()
                } else {
                    $("#modalAsesores").modal("hide");
                }
            })
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseJSON.msg);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: jqXHR.responseJSON.msg,
            })
        }
    });
}

function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
    }
}

function selectProjectDB() {
    $.ajax({
        url: window.location.origin + "/db/getdatadb/" + $("#idProjectDB").val(),
        type: "get",
        success: function (response) {
            console.log(response);
            var htmlThead = '<tr><th>Nombre</th><th>Apellido</th><th>Tipo de documento</th><th>Número de documento</th>';
            var htmlTbody = '<tr><td colspan="4" style="text-align: center;">Sin datos</td></tr>';
            if (response.contact.length > 0) {
                var htmlThead = '<tr><th>Nombre</th><th>Apellido</th><th>Tipo de documento</th><th>Número de documento</th>';
                var htmlTbody = '';

                for (let index = 0; index < response.fields.length; index++) {
                    var item = response.fields[index];
                    htmlThead += '<th>' + item.name + '</th>';
                }
                htmlThead += '</tr>';


                for (let index = 0; index < response.contact.length; index++) {
                    var item = response.contact[index];
                    var OKeys = Object.keys(item);
                    var OValues = Object.values(item);

                    htmlTbody += '<tr>';
                    htmlTbody += '<td>' + ((item.name) ? item.name : '') + '</td>';
                    htmlTbody += '<td>' + ((item.last_name) ? item.last_name : '') + '</td>';
                    htmlTbody += '<td>' + ((item.nameTypeIdentification) ? item.nameTypeIdentification : '') + '</td>';
                    htmlTbody += '<td>' + ((item.number_identification) ? item.number_identification : '') + '</td>';

                    for (let index2 = 0; index2 < response.fields.length; index2++) {
                        var item2 = response.fields[index2];
                        var isLargeNumber = (element) => element == item2.name_id;
                        var indexKey = OKeys.findIndex(isLargeNumber);
                        console.log(OKeys.findIndex(isLargeNumber));
                        htmlTbody += '<td>' + ((OValues[indexKey]) ? OValues[indexKey] : "") + '</td>';
                    }
                    htmlTbody += '</tr>';
                }
                $("#theadDB").html(htmlThead);
                $("#tbodyDB").html(htmlTbody);
            } else {

                $("#theadDB").html(htmlThead);
                $("#tbodyDB").html(htmlTbody);
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseJSON.msg);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: jqXHR.responseJSON.msg,
            })
        }
    });
}
