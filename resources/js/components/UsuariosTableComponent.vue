<template>
    <div>
        <div>
            <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#mod-agregar-usuario" @click="crearNuevoUsuario"> 
                <i class="fas fa-user-plus"></i> Nuevo 
            </button>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="usuario in usuarios" :key="usuario.id">
                    <td>{{ usuario.id }}</td>
                    <td>{{ usuario.documento }}</td>
                    <td>{{ usuario.nombres }}</td>
                    <td>{{ usuario.apellidos }}</td>
                    <td>{{ usuario.correo }}</td>
                    <td>{{ usuario.telefono }}</td>
                    <td>
                        <button type="button" class="btn btn-sm center-block" 
                            :class="usuario.estado ? 'btn-success' :'btn-danger'"
                            @click="updateEstado(usuario)"> 
                            {{ usuario.estado ? 'Activo' :'Inactivo' }} 
                        </button>
                    </td>
                    <td>
                        <div class="btn-group text-center">
                            <button type="button" class="btn btn-sm btn-info" aria-label="Left Align" @click="updateUsuario(usuario)">
                                <i class="fas fa-user-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" aria-label="Right Align" data-data="${data}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import EventBus from '../EventBus'

    export default {
        data: function(){
            return({
                usuarios: [],
            })
        },
        created: function() {
            EventBus.$on('recargarListadoDeUsuarios', () => this.cargarListadoDeUsuarios())
        },
        methods: {
            crearNuevoUsuario() {
                EventBus.$emit('cargarModalUsuarioForm', {}, false);
            },
            cargarListadoDeUsuarios() {
                axios.get('/api/usuarios')
                .then(response => {
                    this.usuarios = response.data;
                })
                .catch(error => console.log(error))
            },

            updateEstado(usuario) {
                Swal.fire({
                    title: 'Esta seguro de cambiar el estado del usuario?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.value) {
                        axios.patch(`/api/usuario/${usuario.id}/update/estado`, usuario)
                        .then(response => {
                            Swal.fire(
                                'Actualizado!',
                                'El estado del usuario se actualizo correctamente.',
                                'success'
                            );

                           this.cargarListadoDeUsuarios();
                        })
                        .catch(errors => console.log(errors));
                    }
                })
            },

            updateUsuario(usuario) {
                EventBus.$emit('cargarModalUsuarioForm', usuario, true);
            },
        },
        mounted() {
            console.log('Component mounted.');

            this.cargarListadoDeUsuarios();
        }
    }
</script>
