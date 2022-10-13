using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListadocontrolvacacionesjefe
    {
        public string i_id { get; set; }
        public string v_dni { get; set; }
        public string v_nombre { get; set; }
        public string v_tipo { get; set; }
        public string v_color_tipo { get; set; }
        public string d_finicio { get; set; }
        public string d_ffin { get; set; }
        public string d_registro { get; set; }
        public string d_aprobacion { get; set; }
        public Int32 i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_style_fechaproceso { get; set; }
        public string v_estado_color { get; set; }
        public string v_aprobar { get; set; }
    }
}