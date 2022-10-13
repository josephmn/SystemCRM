using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarpagovacaciones
    {
        public Int32 i_prog { get; set; }
        public Int32 i_vac { get; set; }
        public string v_dni { get; set; }
        public string v_nombres { get; set; }
        public string v_nommes { get; set; }
        public Int32 i_anhio { get; set; }
        public string d_finicio { get; set; }
        public string d_ffin { get; set; }
        public Int32 v_total { get; set; }
        public string v_tipo { get; set; }
        public string v_color_tipo { get; set; }
        public string v_estado { get; set; }
        public string d_aprobado { get; set; }
        public string d_corte { get; set; }
    }
}