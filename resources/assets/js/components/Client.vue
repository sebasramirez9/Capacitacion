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
                    <i class="fa fa-align-justify"></i> Clientes
                    <button type="button" @click="OpenModal('persona','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre">Nombre</option>
                                    <option value="num_docuemnto">Numero de documento</option>
                                    <option value="email">Email</option>
                                    <option value="telefono">Telefono</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listPerson(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listPerson(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Tipo de documento</th>
                            <th>Numero de documento</th>
                            <th>Direccion </th>
                            <th>Telefono</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="persona in arrayPerson":key="persona.id">
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" @click="OpenModal('persona','actualizar',persona)">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;

                            </td>

                            <td v-text="persona.nombre"></td>
                            <td v-text="persona.tipo_documento"></td>
                            <td v-text="persona.num_documento"></td>
                            <td v-text="persona.direccion"></td>
                            <td v-text="persona.telefono"></td>
                            <td v-text="persona.email"></td>
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
                                    <input type="text" v-model="name" class="form-control" placeholder="Nombre de la persona">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Tipo de documento</label>
                                <div class="col-md-9">
                                    <select v-model="type_document" class="form-control">
                                        <option value="DNI">DNI</option>
                                        <option value="RUC">RUC</option>
                                        <option value="PASS">PASS</option>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Numero </label>
                                <div class="col-md-9">
                                    <input type="text" v-model="num_document" class="form-control" placeholder="Numero">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Direccion </label>
                                <div class="col-md-9">
                                    <input type="text" v-model="address" class="form-control" placeholder="Direccion">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Telefono </label>
                                <div class="col-md-9">
                                    <input type="text" v-model="tel" class="form-control" placeholder="Nombre de categoría">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div v-show="errorPerson" class="form-group row div-error">
                                <div class="text center text-error">
                                    <div v-for="error in errorShowMsjPerson" key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="CloseModal()">Cerrar</button>
                        <button type="button" v-if="typeaction==1" class="btn btn-primary" @click="registerPerson()">Guardar</button>
                        <button type="button" v-if="typeaction==2" class="btn btn-primary" @click="UpdatePerson()">Actualizar</button>
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
                person_id:0,
                name:'',
                type_document:'',
                num_document:'',
                address:'',
                tel:'',
                email:'',
                arrayPerson: [],
                modal:0,
                titulomodal:'',
                typeaction:1,
                errorPerson:0,
                errorShowMsjPerson:[],
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
                criterio:'nombre',
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
                listPerson(page,buscar,criterio)
                {
                    let me=this;
                    var url='/client?page=' +page +'&buscar='+buscar +'&criterio='+criterio;
                    axios.get(url)
                        .then(function (response) {
                            var respuesta =response.data;
                            me.arrayPerson=respuesta.personas.data;
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
                    me.listPerson(page,buscar,criterio);
                },
                registerPerson()
                {
                    if(this.ValidePerson())
                    {
                        return;
                    }
                    let me=this;

                    axios.post('/client/registrar',{
                        'name':this.name,
                        'type_document':this.type_document,
                        'num_document':this.num_document,
                        'address':this.address,
                        'tel':this.tel,
                        'email':this.email,
                    }).then(function (response) {
                        me.CloseModal();
                        me.listPerson(1,'','name');
                    }).catch(function (error) {
                        console.log(error);
                    });

                },
                UpdatePerson()
                {
                    if(this.ValidePerson())
                    {
                        return;
                    }
                    let me=this;

                    axios.put('/client/actualizar',{
                        'name':this.name,
                        'type_document':this.type_document,
                        'num_document':this.num_document,
                        'address':this.address,
                        'tel':this.tel,
                        'email':this.email,
                        'id':this.person_id
                    }).then(function (response) {
                        me.CloseModal();
                        me.listPerson(1,'','name');
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                ValidePerson()
                {
                    this.errorPerson=0;
                    this.errorShowMsjPerson=[];
                    if(!this.name) this.errorShowMsjPerson.push("El nombre de la persona no puede estar vacio");
                    if(this.errorShowMsjPerson.length) this.errorPerson=1;
                    return this.errorPerson;
                },
                CloseModal()
                {
                    this.modal=0;
                    this.titulomodal='';
                    this.name='';
                    this.type_document='DNI';
                    this.num_document='';
                    this.address='';
                    this.tel='';
                    this.email='';
                    this.errorPerson=0
                },
                OpenModal(model,action,data=[])
                {
                    switch (model) {
                        case "persona":
                        {
                            switch (action) {
                                case 'registrar':
                                {
                                    this.modal=1;
                                    this.name='';
                                    this.type_document='DNI';
                                    this.num_document='';
                                    this.address='';
                                    this.tel='';
                                    this.email='';
                                    this.typeaction=1;
                                    break;
                                }
                                case 'actualizar':
                                {
                                    //console.log(data);
                                    this.modal=1;
                                    this.titulomodal='Actualizar categoria';
                                    this.typeaction=2;
                                    this.person_id=data['id'];
                                    this.name=data['nombre'];
                                    this.address=data['direccion'];
                                    this.type_document=data['tipo_documento'];
                                    this.num_document=data['num_documento'];
                                    this.tel=data['telefono'];
                                    this.email=data['email'];
                                    break;

                                }
                            }
                        }
                    }
                }
            },
        mounted() {
            this.listPerson(1,this.buscar,this.criterio);
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
