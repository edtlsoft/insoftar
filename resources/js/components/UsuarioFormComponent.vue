<template>
    <div id="modal-usuario-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledbi="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <div class="col-xs-10">
                        <h3 class="titulo_modal">{{ mode_update ? 'ACTUALIZAR' : 'REGISTRAR' }} USUARIO</h3>
                    </div>
                    <div class="col-xs-2">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                </div>

                <div class="modal-body">
                    <div id="modal2" class="col-xs-12">

                        <form class="form-group" action="php/msproyectos.php" method="POST" @submit.prevent="saveDataUsuario">

                            <div class="mg-top-mod">
                            </div>

                            <label class="col-xs-12 labelpanel"> DOCUMENTO </label>
                            <div class="col-xs-12" >
                                <div class="form-group">
                                    <input type="number" class="form-control" v-model="usuario.documento">
                                </div>
                            </div>

                            <label class="col-xs-12 labelpanel"> NOMBRES </label>
                            <div class="col-xs-12" >
                                <div class="form-group">
                                    <input type="text" class="form-control" v-model="usuario.nombres" required>
                                </div>
                            </div>

                            <label class="col-xs-12 labelpanel"> APELLIDOS </label>
                            <div class="col-xs-12" >
                                <div class="form-group">
                                    <input type="text" class="form-control" v-model="usuario.apellidos" required>
                                </div>
                            </div>

                            <label class="col-xs-12 labelpanel"> CORREO </label>
                            <div class="col-xs-12" >
                                <div class="form-group">
                                    <input class="form-control" type="text" v-model="usuario.correo" required>
                                </div>
                            </div>

                            <label class="col-xs-12 labelpanel"> TELEFONO </label>
                            <div class="col-xs-12" >
                                <div class="form-group">
                                    <input class="form-control" type="number" v-model="usuario.telefono" required>
                                </div>
                            </div>

                            <div class="col-xs-12" id="msg-errors">
                                <b v-if="msgerror"> <img :src="msgerror.img" style="width: 25px"> {{ msgerror.mensaje }} </b>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <button type="submit" class="btn form-control" :class="mode_update ? 'btn-success' : 'btn-primary'">
                                        <span class="glyphicon glyphicon-floppy-disk"></span> 
                                        {{ mode_update ? 'ACTUALIZAR' : 'GUARDAR' }} USUARIO
                                    </button>
                                </div>
                            </div>      

                        </form>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-rigth" data-dismiss="modal">CERRAR</button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from '../EventBus'
    
    export default {
        data: function(){
            return({
                usuario: {},
                mode_update: false,

                msgerror: {},
            })
        },
        created: function() {
            EventBus.$on('cargarModalUsuarioForm', (usuario, mode_update=false) => this.cargarModalUsuarioForm(usuario, mode_update))
        },
        methods: {
            cargarModalUsuarioForm(usuario, mode_update) {
                this.usuario     = usuario;
                this.mode_update = mode_update;

                $('div#modal-usuario-form').modal();
            },

            saveDataUsuario() {
                let interceptor = this.setInterceptor(this.mode_update ? 'Actualizando datos' : 'Guardando datos');
                let url = this.mode_update ? `/api/usuario/${this.usuario.id}/update` : `/api/usuario/store`;

                axios.post(url, this.usuario)
                .then(response => {
                    this.msgerror = {
                        img: '/img/exitoso.jpg',
                        mensaje: this.mode_update ? 'El usuario se actualizo correctamente' : 'El usuario se registro correctamente',
                    };

                    EventBus.$emit('recargarListadoDeUsuarios');

                    setTimeout(() => {
                        this.msgerror = {};
                        
                        $('div#modal-usuario-form').modal('hide');
                    }, 1000);
                })
                .catch(errors => {
                    console.log(errors);
                    typeof(errors.response) != 'undefined' ? this.mostrarErroresHTTP(errors.response.data) : true;
                })

                axios.interceptors.request.eject(interceptor);
            },

            setInterceptor(mensaje) {
                return axios.interceptors.request.use((config) => {
                    this.msgerror = {
                        img:     '/img/Cargar.gif',
                        mensaje: mensaje,
                    }
                    
                    return config;
                });
            },

            mostrarErroresHTTP: function(error) {
                let errores  = error.errors;
                let errormsg = '';

                for( let e in errores ){
                    errormsg = errores[e][0];
                    break;
                }

                errormsg = errormsg ? errormsg : 
                                (error.message ? error.message : 'Ocurrio un error desconocido al intentar realizar la peticion, intentelo nuevamente.');

                this.msgerror = {
                    img: '/img/error.jpg',
                    mensaje: errormsg,
                }
            },
        },
        mounted() {
            console.log('Component mounted.');
        }
    }
</script>
