import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import Example from '@/Components/ModalBootstrap';
import { useState } from 'react';
import formulario from '@/Components/AddFormulario';
import MUIDataTable from "mui-datatables";
import axios from 'axios';

export default function Dashboard(props) {
    const [empleados, setEmpleados] = useState(props.empleados);
    const [updating, setUpdate] = useState(false);
    const [deleting, setDelete] = useState(false);
    const [deletingId, setDeleteId] = useState(0);
    const [mostrarModal, setShow] = useState(false);
    const [tituloModal, setTitulo] = useState("Añadir Empleado");
    const [actionButton, setActionButton] = useState("Añadir Empleado");
    const initialState={
        id:"",
        nombre:"",
        apellido:"",
        nss:"",
        fecha_ingreso:"",
        status:"",
        img:"",
        preview:"",
        delFoto:false
    }
    const [fomularioState, setForm] = useState(initialState);
    const [contenidoState, setContenido] = useState("");
    const updateFormulario = async (event)=>{
        if(event.target.name =="img"){
           const file= event.target.files[0];
           const fr = new FileReader();
           fr.onload = (e) => {
            const { result } = e.target;
            setForm({ ...fomularioState, preview:fr.result , img:file})
            }
            fr.readAsDataURL(file)

        }else{
            setForm({ ...fomularioState, [event.target.name]: event.target.value })
        }
    }
    const eliminarImagen =()=>{
        if(updating){
            setForm({ ...fomularioState, preview:"" , img:"",delFoto:true})
        }else{
            setForm({ ...fomularioState, preview:"" , img:""})
        }

    }
    const contenidoModal=formulario(fomularioState,updateFormulario,eliminarImagen,contenidoState)
    const guardarEmpleado=()=>{
        console.log(empleados);
        if (updating){
            fomularioState._method="patch"
            axios.postForm("empleados/"+fomularioState.id,fomularioState).then((e)=>{
                let data=e.data.data;
                let newState= empleados.map((e1)=>{
                    if (e1.id==data.id){
                        return data;
                    }
                    return e1;
                })
                setEmpleados(newState)
                setForm(initialState);
                setShow(false)
                setUpdate(false);
                return;
            }).catch((e)=>{
                console.log(e);
            })
            return;
        }
        if(deleting){
            deleteEmpleado(deletingId);
            return;
        }
        axios.postForm("",fomularioState).then((e)=>{
            setEmpleados(oldArray => [...oldArray,e.data.data] )
            setForm(initialState);
            setShow(false)
        }).catch((e)=>{
            console.log(e);
        })
    }
    const cancelarModal=()=>{
        setForm(initialState);
        setUpdate(false);
        setDelete(false);
        setDeleteId(0);
        setShow(false)
    }
    const initialStateModalButtons=(
        <>
        <button className='btn btn-danger' onClick={cancelarModal}>Cancelar</button>
        <button className='btn btn-primary' onClick={guardarEmpleado}>{actionButton}</button>
        </>
    );
    const buttonsModal=initialStateModalButtons;

    const editarEmpleado = (id)=>{
        if(empleados[id].img!=""&& empleados[id].img!=null) empleados[id].preview="/storage/"+empleados[id].img ;
        setForm(empleados[id])
        setTitulo("Actualizar Empleado")
        setActionButton("Actualizar");
        // contenidoModal=formulario(fomularioState,updateFormulario,eliminarImagen);
        setShow(true)
        setUpdate(true);
    }
    const deleteEmpleado= (id,index)=>{
        axios.delete("empleados/"+id).then((e)=>{
            setEmpleados(empleados.filter((empleados) => empleados.id !== id));
            setForm(initialState);
            setShow(false);
            setDelete(false);
            setDeleteId(0);
            return;
        }).catch((e)=>{
            console.log(e);
        })
    }
    const deleteMultiplesEmpleados= (ids)=>{
        axios.delete("empleados/multiple/"+ids).then((e)=>{
            // setEmpleados(empleados.filter((empleados) => !ids.includes(empleados.id)));
            // setForm(initialState);
            // setShow(false);
            // setDelete(false);
            // setDeleteId(0);
            return;
        }).catch((e)=>{
            console.log(e);
        })
    }
    const eliminarEmplado= (id)=>{
        setTitulo("Eliminar usuario")
        setContenido("Seguro que deseas elminia a "+empleados[id].nombre);
        setActionButton("Eliminar");
        setDelete(true);
        setDeleteId(empleados[id].id);
        setShow(true)
    }

    const filas = empleados.map((e,i)=>{
        let columns=Object.keys(e).map((e1)=>{
            if(e1=="status"){
                let status;
                if(e[e1]==1) status="Activo"
                else if(e[e1]==2) status="Vacaciones"
                else if(e[e1]==3) status="Suspendido"
                else if(e[e1]==4) status="Permiso Especial"
                else if(e[e1]==5) status="Baja"
                return (<td key={e.id+"."+e1}>{status}</td>)
            }
            return (<td key={e.id+"."+e1}>{e[e1]}</td>);
        })
        columns.push((<td key={e.id+".edit"}> <button className='btn btn-primary' onClick={() => {editarEmpleado(i)}}>Editar</button><button className='btn btn-danger' onClick={() => {eliminarEmplado(i)}}>Elminar</button> </td>))
        return (<tr key={e.id}>{columns}</tr>);
    })
   const openModal= ()=>{setShow(true); setUpdate(false); setTitulo("Añadir Empleado"); };
    const closeModal = ()=> setShow(false);
    const divStyle={
        overflow:"auto"
    }
    const imgComlumn={
        name: "IMG",
        options: {
          customBodyRender: (value, tableMeta, updateValue) => {
            if(value!=""&&value!=null){
                return (
                    <img src={"/storage/"+value} alt="" srcSet="" />
                )
            }

          }
        }
      };
    const actionsColumn={
        name: "Acciones",
        options: {
          customBodyRender: (value, tableMeta, updateValue) => {
            return (
                <>
                <button className='btn btn-primary' onClick={() => {editarEmpleado(value)}}>Editar</button><button className='btn btn-danger' onClick={() => {eliminarEmplado(value)}}>Elminar</button>
                </>
                )
          }
        }
      }
    const columns = ["ID","Nombre","Apellido",imgComlumn,"NSS","Fecha Ingreso","Status","Created","Updated",actionsColumn]
    const data = empleados.map((e,i)=>{
                let status;
                if(e["status"]==1) status="Activo"
                else if(e["status"]==2) status="Vacaciones"
                else if(e["status"]==3) status="Suspendido"
                else if(e["status"]==4) status="Permiso Especial"
                else if(e["status"]==5) status="Baja"


            return [
                e.id, e.nombre, e.apellido, e.img, e.nss, e.fecha_ingreso, status,e.created_at,e.updated_at,i
            ]
          });

        const options = {
        filterType: 'checkbox',
        onRowsDelete: (e)=>{
            const ids=e.data.map((e)=>{
                return empleados[e.dataIndex].id;
            })
            deleteMultiplesEmpleados(ids);
        }
        };



    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Empleados</h2>}
        >
            <Head title="Dashboard" />
            <Example  modalTitle={tituloModal} modalContent={contenidoModal} modalButtons={buttonsModal} showProp={mostrarModal} hideModal={closeModal}/>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                        <div className="p-2 d-flex flex-column">
                            <div className='px-3 d-flex justify-content-between align-items-center'>
                                <h3></h3>
                                 <button className='btn btn-success' onClick={openModal}> Añadir Empleado</button>
                            </div>
                            <div style={divStyle}>
                            <MUIDataTable
                                title={"Lista de Empleados"}
                                data={data}
                                columns={columns}
                                options={options}
                                />
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </AuthenticatedLayout>
    );
}
