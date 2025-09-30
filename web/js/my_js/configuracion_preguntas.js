new Vue({
    el: '#app',
    data: {
        BASE_URL: $('#baseUrl').val(),

        GRUPOS_LIST: [],
        grupo_selected: 1,
        array_tipo: [],

        array_preguntas: [
            { id: 1, main_id: null, pregunta: '', tipo: 1, is_required: false, selectes: [] },
        ],

        nextId: 1, // ID para la siguiente pregunta

        opcion_delete: [],
        pregunta_delete: [],

    },
    computed: {

    },
    methods: {



        guardarEtapas() {
            // Versión mejorada
            if (!this.nombre_super_max || this.nombre_super_max.trim() === '') {
                alert("Debe ingresar un nombre válido para la etapa");
                return false; // Mejor return false para manejo consistente
            }
            if (!this.allRangesConfigured) {
                return;
            }
            const etapas = this.array_etapas.map(etapa => ({
                min: etapa.min,
                max: etapa.max,
                nombre: etapa.nombre.trim() === "" ? 'Sin nombre' : etapa.nombre.trim().toUpperCase(),
            }));

            let data = {
                array_etapas: etapas,
                maxLimit: this.maxLimit,
                nombre_super_max: this.nombre_super_max.trim().toUpperCase()
            };
            let self = this;
            console.log(this.BASE_URL);

            $.ajax({
                url: self.BASE_URL + 'save-etapa',
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",

                success: (response) => {
                    console.log(response);
                    if (response.success) {
                        alert(response.message);
                        window.location.reload();
                        //self.listDocumento();
                    }
                    //alert(response.message);
                    //self.closeModal('documento_form');
                },
                error: (error) => {
                    alert("Error.");
                },
            });

            console.log(data);
            console.log(JSON.stringify(data));
            //alert("Datos guardados correctamente");
        },

        cargarPreguntas() {

            let self = this;
            $.ajax({
                url: self.BASE_URL + 'carga-list',
                type: "POST",
                data: {
                    grupo_selected: self.grupo_selected,
                },
                success: (response) => {
                    if (response.code == 202) {
                        //self.GRUPOS_LIST = response.grupos;
                        //self.array_tipo = response.preguntas_tipo;
                        self.array_preguntas = response.listas;
                        //console.log(response);

                    }


                },
                error: (error) => {
                    alert("Error al cargar la informacion.");
                },
            });
        },

        cargar_inicial() {
            let self = this;
            $.ajax({
                url: self.BASE_URL + 'carga-inicial',
                type: "POST",
                data: {},
                success: (response) => {
                    if (response.code == 202) {
                        self.GRUPOS_LIST = response.grupos;
                        self.array_tipo = response.preguntas_tipo;
                        //self.array_preguntas = response.listas;
                        console.log(response);

                    }


                },
                error: (error) => {
                    alert("Error al cargar la informacion.");
                },
            });
        },

        agregarPregunta() {
            if (this.grupo_selected === null) {
                alert('Debe seleccionar un grupo antes de agregar una pregunta.');
                return;
            }
            this.array_preguntas.push({
                id: this.nextId++,
                pregunta: '',
                main_id: null,
                tipo: 2, // Por defecto text
                is_required: false, // Por defecto no requerido
                selectes: []
            });
        },
        eliminarPregunta(index, pregunta) {
            this.array_preguntas.splice(index, 1);
            if (pregunta.main_id !== null) {
                this.pregunta_delete.push(pregunta.main_id);
            }
            console.log(pregunta.main_id);
        },
        cambiarTipo(pregunta) {
            // Si cambia a un tipo que no es selector, limpiamos las opciones
            if (pregunta.tipo !== 3) {
                pregunta.selectes = [];
            }
        },
        agregarOpcion(pregunta) {
            if (!pregunta.selectes) {
                pregunta.selectes = [];
            }
            pregunta.selectes.push({
                id: null, // ID único temporal
                texto: ''
            });
        },
        eliminarOpcion(pregunta, opcionIndex, opcion) {
            pregunta.selectes.splice(opcionIndex, 1);
            if (opcion.id !== null) {
                this.opcion_delete.push(opcion.id);
            }
            //console.log(opcion.id);

        },
        validarPregunta(pregunta) {
            let valido = true;

            // Validar texto de la pregunta
            if (!pregunta.pregunta || pregunta.pregunta.trim() === '') {
                this.$set(pregunta, 'errorPregunta', 'El texto de la pregunta es requerido');
                valido = false;
            } else {
                this.$set(pregunta, 'errorPregunta', null);
            }

            // Validar opciones si es selector
            if (pregunta.tipo === 3) {
                if (pregunta.selectes.length === 0) {
                    this.$set(pregunta, 'errorOpciones', 'Debe agregar al menos una opción');
                    valido = false;
                } else {
                    this.$set(pregunta, 'errorOpciones', null);

                    // Validar cada opción individual
                    pregunta.selectes.forEach((opcion, index) => {
                        if (!opcion.texto || opcion.texto.trim() === '') {
                            this.$set(opcion, 'error', 'El texto de la opción es requerido');
                            valido = false;
                        } else {
                            this.$set(opcion, 'error', null);
                        }
                    });
                }
            }

            return valido;
        },

        validarTodasLasPreguntas() {
            let todasValidas = true;

            this.array_preguntas.forEach(pregunta => {
                if (!this.validarPregunta(pregunta)) {
                    todasValidas = false;
                }
            });

            return todasValidas;
        },

        guardarPreguntas() {
            if (this.grupo_selected === null) {
                alert('Debe seleccionar un grupo antes de guardar las preguntas.');
                return;
            }
            if (!this.validarTodasLasPreguntas()) {
                alert('Por favor complete todos los campos requeridos');
                return;
            }

            let self = this;
            let pyload = {
                //d:'',
                array_preguntas: self.array_preguntas,
                grupo_selected: self.grupo_selected,
                preg_del: JSON.stringify(this.pregunta_delete),
                opc_del: JSON.stringify(this.opcion_delete)
            };

            $.ajax({
                url: self.BASE_URL + 'save',
                type: "POST",
                data: pyload,
                success: (response) => {
                    self.cargarPreguntas();

                    console.log(response, 'response');
                },
                error: (error) => {
                    alert("Error al cargar la informacion.");
                },
            });

            // Aquí iría la lógica para guardar en backend
            //console.log('Preguntas a guardar:', pyload);
            alert('Preguntas guardadas correctamente');
        }
    },

    mounted() {
        self = this;
        setTimeout(function () {
            self.cargar_inicial();
            self.cargarPreguntas();
        }, 500);
        this.pregunta_delete = [];
        this.opcion_delete = [];
        //this.cargar_etapa();
    }
});