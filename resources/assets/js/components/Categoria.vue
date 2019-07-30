<template>

    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Categorías
                    <button type="button" @click="OpenModal('categoria','registrar',categoria)" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="cat_name">Nombre</option>
                                    <option value="cat_description">Descripción</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listCategory(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listCategory(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="categoria in arrayCategory":key="categoria.id">
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" @click="OpenModal('categoria','actualizar',categoria)">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <template v-if="categoria.cat_condition">
                                    <button type="button" class="btn btn-danger btn-sm" @click="Offcategory(categoria.id)">
                                        <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="Oncategory(categoria.id)">
                                        <i class="icon-plus"></i>
                                    </button>
                                </template>
                            </td>

                            <td v-text="categoria.cat_name"></td>
                            <td v-text="categoria.cat_description"></td>
                            <td>
                                <div v-if="categoria.cat_condition">
                                    <span class="badge badge-success">Activo</span>

                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">Desactivado</span>

                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page -1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber":key="page" :class="[page == isActived ? 'active': '']">
                                <a class="page-link" href="#" @click.prevent="changePage(page,buscar,criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page <pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page +1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade"  tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="titulomodal"></h4>
                        <button type="button" class="close" @click="CloseModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="name" class="form-control" placeholder="Nombre de categoría">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="description" class="form-control" placeholder="Ingrese descripcion">
                                </div>
                            </div>
                            <div v-show="errorCategory" class="form-group row div-error">
                                <div class="text center text-error">
                                    <div v-for="error in errorShowMsjCategory" key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="CloseModal()">Cerrar</button>
                        <button type="button" v-if="typeaction==1" class="btn btn-primary" @click="registerCategory()">Guardar</button>
                        <button type="button" v-if="typeaction==2" class="btn btn-primary" @click="UpdateCategory()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->


    </main>
</template>

<script>


    import axios from "axios";

    // CommonJS


    export default {
        data()
        {
            return{
                name:'',
                description:'',
                arrayCategory: [],
                modal:0,
                titulomodal:'',
                typeaction:1,
                errorCategory:0,
                errorShowMsjCategory:[],
                category_id:0,
                pagination:
                    {
                        'total' : 0,
                        'current_page' :0,
                        'per_page' : 0,
                        'last_page':0,
                        'from':0,
                        'to':0,
                    },
                offset : 3,
                criterio:'cat_name',
                buscar:''

            }
        },
        computed:{
            isActived: function()
            {
              return this.pagination.current_page;  
            },
            pagesNumber: function () {
                if(!this.pagination.to)
                {
                    return[];
                }
                var from = this.pagination.current_page - this.offset;
                if(from<1)
                {
                    from=1;
                }
                var to = from + (this.offset*2);
                if(to>=this.pagination.last_page)
                {
                    to=this.pagination.last_page;
                }

                var pagesArray=[];
                while(from <=to)
                {
                    pagesArray.push(from);
                    from++
                }
                return pagesArray;
            }
        },
        methods:
            {
                listCategory(page,buscar,criterio)
                {
                    let me=this;
                    var url='/categoria?page=' +page +'&buscar='+buscar +'&criterio='+criterio;
                    axios.get(url)
                        .then(function (response) {
                           var respuesta =response.data;
                           me.arrayCategory=respuesta.categoria.data;
                           me.pagination=respuesta.pagination;

                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });

                },
                changePage(page,buscar,criterio)
                {
                    let me=this;
                    me.pagination.current_page=page;
                    me.listCategory(page,buscar,criterio);
                },
                registerCategory()
                {
                    if(this.ValideCategory())
                    {
                        return;
                    }
                    let me=this;

                    axios.post('/categoria/registrar',{'name':this.name,'description':this.description}).then(function (response) {
                        me.CloseModal();
                        me.listCategory(1,'','name');
                    }).catch(function (error) {
                        console.log(error);
                    });

                },
                UpdateCategory()
                {
                    if(this.ValideCategory())
                    {
                        return;
                    }
                    let me=this;

                    axios.put('/categoria/actualizar',{'name':this.name,'description':this.description,'id':this.category_id}).then(function (response) {
                        me.CloseModal();
                        me.listCategory(1,'','name');
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                Offcategory(id)
                {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false,
                    })

                    swalWithBootstrapButtons.fire({
                        title: '¿Estas seguro?',
                        text: "desactivaras la categoria.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'No, cancelar!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {


                            let me=this;

                            axios.put('/categoria/desactivar',{'id':id}).then(function (response) {

                                me.listCategory(1,'','name');
                                swalWithBootstrapButtons.fire(
                                    'Desactivada!',
                                    'Tu categoria ha sido desactivada',
                                    'success'
                                )
                            }).catch(function (error) {
                                console.log(error);
                            });

                        } else if (
                            // Read more about handling dismissals
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                                'Cancelado',
                                'Tu categoria sigue activada ',
                                'error'
                            )
                        }
                    })
                },
                Oncategory(id)
                {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false,
                    })

                    swalWithBootstrapButtons.fire({
                        title: '¿Estas seguro?',
                        text: "activaras la categoria.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'No, cancelar!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {


                            let me=this;

                            axios.put('/categoria/activar',{'id':id}).then(function (response) {


                                swalWithBootstrapButtons.fire(
                                    'activada!',
                                    'Tu categoria ha sido activada',
                                    'success'
                                )
                                me.listCategory(1,'','name');
                            }).catch(function (error) {
                                console.log(error);
                            });

                        } else if (
                            // Read more about handling dismissals
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                                'Cancelado',
                                'Tu categoria sigue desactivada ',
                                'error'
                            )
                        }
                    })
                },
                ValideCategory()
                    {
                        this.errorCategory=0;
                        this.errorShowMsjCategory=[];
                        if(!this.name) this.errorShowMsjCategory.push("El nombre de la categoria no puede estar vacio");
                        if(this.errorShowMsjCategory.length) this.errorCategory=1;
                        return this.errorCategory;
                    },
                CloseModal()
                {
                    this.modal=0;
                    this.titulomodal='';
                    this.name='';
                    this.description='';
                },
                OpenModal(model,action,data=[])
                {
                    switch (model) {
                        case "categoria":
                        {
                            switch (action) {
                                case 'registrar':
                                {
                                    this.modal=1;
                                    this.nombre='';
                                    this.titulomodal='Registrar categoria';
                                    this.description='';
                                    this.typeaction=1;
                                    break;
                                }
                                case 'actualizar':
                                {
                                    //console.log(data);
                                    this.modal=1;
                                    this.titulomodal='Actualizar categoria';
                                    this.typeaction=2;
                                    this.category_id=data['id'];
                                    this.name=data['cat_name'];
                                    this.description=data['cat_description'];
                                    break;

                                }
                            }
                        }
                    }
                }
            },
        mounted() {
            this.listCategory(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content
    {
        width: 100% !important;
        position: absolute !important;

    }
    .mostrar{
        display:list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a;
    }
    .div-error
    {
        display:flex;
        justify-content: center;
    }
    .text-error
    {
        color: red !important;
        font-weight: bold;
    }
</style>
