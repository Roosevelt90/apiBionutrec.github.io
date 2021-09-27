$("#formSurvey").on('submit', function (evt) {
    for (let index = 0; index < fields.length; index++) {
        const element = fields[index];
        if (element.required == 1) {
            var flag = false;
            //Unico
            if (element.id_type == 3) {
                console.log(element);
                if($('input[name="'+element.name_id+'"]:checked').val()){
                    flag = true;
                }
                //Multiple
            } else if (element.id_type == 4) {
                var chk_arr = document.getElementsByName(element.name_id + "[]");
                var chklength = chk_arr.length;
                for (k = 0; k < chklength; k++) {
                    if (chk_arr[k].checked == true) {
                        flag = true;
                        break;
                    }
                }
            } else {
                if ($("#" + element.name_id).val()) {
                    flag = true;
                }
            }
            if (flag == false) {
                Swal.fire(
                    'Error',
                    'El campo <b>"' + element.name + '"</b> es requerido',
                    'info'
                )
                evt.preventDefault();
            }

        }
    }
});