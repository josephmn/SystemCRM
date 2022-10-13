using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarUsuarios
    {
        public string i_id { get; set; }
        public string v_dni { get; set; }
        public string v_nombre { get; set; }
        public string v_apellidos { get; set; }
        public string v_celular { get; set; }
        public string v_correo { get; set; }
        public string i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_color_estado { get; set; }
        public string i_perfil { get; set; }
        public string v_perfil { get; set; }
        public string v_foto { get; set; }
    }
}