<template>

    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">

            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>

        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Articulos
                    <button type="button" @click="OpenModal('articulos','registrar')" class="btn btn-secondary">
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
                                <input type="text" v-model="buscar" @keyup.enter="listArticle(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listArticle(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="articulos in arrayArticle":key="articulos.id">
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" @click="OpenModal('articulos','actualizar',articulos)">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <template v-if="articulos.art_condition">
                                    <button type="button" class="btn btn-danger btn-sm" @click="OffArticle(articulos.id)">
                                        <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="OnArticle(articulos.id)">
                                        <i class="icon-plus"></i>
                                    </button>
                                </template>
                            </td>
                            <td v-text="articulos.art_codigo"></td>
                            <td v-text="articulos.art_name"></td>
                            <td v-text="articulos.nombre_categoria"></td>
                            <td v-text="articulos.art_precio_venta"></td>
                            <td v-text="articulos.art_descripcion"></td>
                            <td>
                                <div v-if="articulos.art_condition">
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
                                <label class="col-md-3 form-control-label" for="text-input">Categoria</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="IdCategory">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="categoria in arrayCategory" :key="categoria.id":value="categoria.id" v-text="categoria.cat_name"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Codigo</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="code" class="form-control" placeholder="Codigo del articulo">
                                    <barcode :value="code" :options="{format: 'EAN-13'}">
                                        Generando codigo de barras.
                                    </barcode>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre del articulo</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="name" class="form-control" placeholder="Nombre del articulo">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Precio de venta</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="price" class="form-control" placeholder="Precio de venta">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="description" class="form-control" placeholder="Ingrese descripcion">
                                </div>
                            </div>
                            <div v-show="errorArticle" class="form-group row div-error">
                                <div class="text center text-error">
                                    <div v-for="error in errorShowMsjArticle" key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="CloseModal()">Cerrar</button>
                        <button type="button" v-if="typeaction==1" class="btn btn-primary" @click="registerArticle()">Guardar</button>
                        <button type="button" v-if="typeaction==2" class="btn btn-primary" @click="UpdateArticle()">Actualizar</button>
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
    import VueBarcode from 'vue-barcode';
    // CommonJS


    export default {
        data()
        {
            return{
                name:'',
                description:'',
                article_id:'',
                arrayArticle: [],
                name_category:'',
                code:'',
                modal:0,
                price:0,
                titulomodal:'',
                typeaction:1,
                errorArticle:0,
                errorShowMsjArticle:[],
                IdCategory:0,
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
                buscar:'',
                arrayCategory:[]

            }
        },
        components:{
          'barcode':VueBarcode
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
                listArticle(page,buscar,criterio)
                {
                    let me=this;
                    var url='/article?page=' +page +'&buscar='+buscar +'&criterio='+criterio;
                    axios.get(url)
                        .then(function (response) {
                            var respuesta =response.data;
                            me.arrayArticle=respuesta.articulos.data;
                            me.pagination=respuesta.pagination;

                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });

                },
                selectCategory()
                {
                    let me=this;
                    var url='/categoria/selectCategoria';
                    axios.get(url)
                        .then(function (response) {
                            //console.log(response);
                            var respuesta =response.data;
                            me.arrayCategory=respuesta.categorias;
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
                    me.listArticle(page,buscar,criterio);
                },
                registerArticle()
                {
                    if(this.ValideArticle())
                    {
                        return;
                    }
                    let me=this;

                    axios.post('/article/registrar',{
                        'IdCategory':this.IdCategory,
                        'code':this.code,
                        'name':this.name,
                        'price':this.price,
                        'description':this.description,
                    }).then(function (response) {
                        me.CloseModal();
                        me.listArticle(1,'','name');
                    }).catch(function (error) {
                        console.log(error);
                    });

                },
                UpdateArticle()
                {
                    if(this.ValideArticle())
                    {
                        return;
                    }
                    let me=this;

                    axios.put('/article/actualizar',{
                        'IdCategory':this.IdCategory,
                        'code':this.code,
                        'name':this.name,
                        'price':this.price,
                        'description':this.description,
                        'id':this.article_id
                    }).then(function (response) {
                        me.CloseModal();
                        me.listArticle(1,'','name');
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                OffArticle(id)
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
                        text: "desactivaras el articulo",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'No, cancelar!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {


                            let me=this;

                            axios.put('/article/desactivar',{'id':id}).then(function (response) {

                                me.listArticle(1,'','name');
                                swalWithBootstrapButtons.fire(
                                    'Desactivada!',
                                    'Tu articulo ha sido desactivado',
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
                OnArticle(id)
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
                        text: "activaras el articulo.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'No, cancelar!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {

                            let me=this;

                            axios.put('/article/activar',{'id':id}).then(function (response) {
                                me.listArticle(1,'','name');
                                swalWithBootstrapButtons.fire(
                                    'activada!',
                                    'Tu articulo ha sido activada',
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
                                'Tu categoria sigue desactivada ',
                                'error'
                            )
                        }
                    })
                },
                ValideArticle()
                {
                    this.errorArticle=0;
                    this.errorShowMsjArticle=[];
                    if(this.IdCategory==0) this.errorShowMsjArticle.push("Selecciona una categoria");
                    if(!this.name) this.errorShowMsjArticle.push("El nombre de la categoria no puede estar vacio");
                    if(!this.price) this.errorShowMsjArticle.push("El precio venta del articulo debe ser un numero y no puede estar vacio");
                    if(this.errorShowMsjArticle.length) this.errorArticle=1;
                    return this.errorArticle;
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
                        case "articulos":
                        {
                            switch (action) {
                                case 'registrar':
                                {
                                    this.modal=1;
                                    this.name='';
                                    this.titulomodal='Registrar articulo';
                                    this.IdCategory=0;
                                    this.name_category='';
                                    this.code='';
                                    this.price=0;
                                    this.description='';
                                    this.typeaction=1;
                                    break;
                                }
                                case 'actualizar':
                                {
                                    //console.log(data);
                                    this.modal=1;
                                    this.titulomodal='Actualizar articulo';
                                    this.typeaction=2;
                                    this.article_id=data['id'];
                                    this.IdCategory=data['art_catId'];
                                    this.code=data['art_codigo'];
                                    this.name=data['art_name'];
                                    this.price=data['art_precio_venta'];
                                    this.description=data['art_descripcion'];
                                    break;

                                }
                            }
                        }
                    }
                    this.selectCategory();
                }
            },
        mounted() {
            this.listArticle(1,this.buscar,this.criterio);
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
