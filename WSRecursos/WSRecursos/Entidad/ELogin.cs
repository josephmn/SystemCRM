using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class ELogin
    {
        public string v_dni { get; set; }
        public string v_nombre { get; set; }
        public string v_correo { get; set; }
        public string v_codigo { get; set; }
        public string v_estado { get; set; }
        public string i_idperfil { get; set; }        
        public string v_perfil { get; set; }
        public string v_foto { get; set; }
        public string v_ruc { get; set; }
        public string v_razon { get; set; }
        public string v_nombre_completo { get; set; }
        public string v_ruta { get; set; }
        public string v_firma { get; set; }        
        public Int32 i_flex { get; set; }
        public Int32 i_remoto { get; set; }
        public Int32 i_venta { get; set; }
        public Int32 i_zona { get; set; }
        public Int32 i_local { get; set; }
        public string d_nacimiento { get; set; }
        public string v_pais { get; set; }
        public string v_cargo { get; set; }
        public string v_nombres { get; set; }
        public string v_apellidos { get; set; }
        public string v_departamento { get; set; }
        public string v_provincia { get; set; }
        public string v_distrito { get; set; }
        public string v_direccion { get; set; }
        public string v_referencia { get; set; }
        public Int32 i_cliente { get; set; }
        public Int32 i_cumpleanios { get; set; }
    }
}