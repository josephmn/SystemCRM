using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarFeriado
    {
        public Int32 i_id { get; set; }
        public string v_descripcion { get; set; }
        public Int32 i_anhio { get; set; }
        public Int32 i_mes { get; set; }
        public string v_mes { get; set; }
        public string d_fecha { get; set; }
        public Int32 i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_color_estado { get; set; }
        public string d_fregistro { get; set; }
        public string d_factualiza { get; set; }
    }
}