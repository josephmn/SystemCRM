using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EConsultaFinalistas
    {
        public Int32 i_id { get; set; }
        public string v_publicacion { get; set; }
        public string v_puesto { get; set; }
        public string v_dni { get; set; }
        public string v_nombres { get; set; }
        public string v_celular { get; set; }
        public string v_correo { get; set; }
        public Int32 i_hijos { get; set; }
        public Int32 i_status { get; set; }
        public string v_estado { get; set; }
        public string v_color_estado { get; set; }

    }
}