var app = new Vue({
    el: '#app',
    data: {
        isLoading: false,
        isDone: true,
        rut: '',
        tipo_comentario: '',
        area: '',
        comentario: '',
        tipos_comentario: [],
        areas: []
    },
    created() {
        var vm = this;
        axios.get('api/form').then(function (respuesta) {
            console.log('bien');
            vm.areas = respuesta.data.areas;
            vm.tipos_comentario = respuesta.data.tipos_comentario;

            setTimeout(function () {
                $('select').formSelect();
                $(".dropdown-content>li>span").css("color", "#9C27B0");
            }, 200);
        });
    },
    methods: {
        verificarDatos() {
            console.log(this.rut);
            if (!this.rut) {
                toastr.error('Debe ingresar un rut válido')
                return;
            }
            if (!this.checkRut()) {
                return;
            }
            if (!this.tipo_comentario) {
                toastr.error('Debe seleccionar un tipo de comentario')
                return;
            }
            if (!this.area) {
                toastr.error('Debe seleccionar un área')
                return;
            }
            if (!this.comentario.trim()) {
                toastr.error('Debe ingresar un comentario')
                return;
            }

            console.log(this.tipo_comentario, this.area, this.comentario);
            this.enviarComentario();
        },
        enviarComentario() {
            var vm = this;
            this.isLoading = true;

            var data = {
                rut: this.rut,
                tipo_comentario: this.tipo_comentario,
                area: this.area,
                comentario: this.comentario
            };

            axios.post("api/", data).then(function (respuesta) {
                console.log(respuesta);
                vm.isLoading = false;

                if (respuesta.data.estado == "Error") {
                    toastr.error(respuesta.data.mensaje);
                    return;
                }

                if (respuesta.data.estado == "Success") {
                    //toastr.success(respuesta.data.mensaje);
                    vm.ocultarFormulario();
                    return;
                }
            });
        },
        ocultarFormulario() {
            this.isDone = false;
        },
        checkRut() {
            // Despejar Puntos
            var valor = this.rut.replace('.', '');
            // Despejar Guión
            valor = valor.replace('-', '');

            // Aislar Cuerpo y Dígito Verificador
            cuerpo = valor.slice(0, -1);
            dv = valor.slice(-1).toUpperCase();

            // Formatear RUN
            this.rut = cuerpo + '-' + dv

            // Si no cumple con el mínimo ej. (n.nnn.nnn)
            if (cuerpo.length < 7) {
                toastr.error("RUT incompleto");
                return false;
            }

            // Calcular Dígito Verificador
            suma = 0;
            multiplo = 2;

            // Para cada dígito del Cuerpo
            for (i = 1; i <= cuerpo.length; i++) {

                // Obtener su Producto con el Múltiplo Correspondiente
                index = multiplo * valor.charAt(cuerpo.length - i);

                // Sumar al Contador General
                suma = suma + index;

                // Consolidar Múltiplo dentro del rango [2,7]
                if (multiplo < 7) {
                    multiplo = multiplo + 1;
                } else {
                    multiplo = 2;
                }

            }

            // Calcular Dígito Verificador en base al Módulo 11
            dvEsperado = 11 - (suma % 11);

            // Casos Especiales (0 y K)
            dv = (dv == 'K') ? 10 : dv;
            dv = (dv == 0) ? 11 : dv;

            // Validar que el Cuerpo coincide con su Dígito Verificador
            if (dvEsperado != dv) {
                toastr.error("RUT Inválido");
                return false;
            }

            // Si todo sale bien, eliminar errores (decretar que es válido)
            return true;
        }
    }
})