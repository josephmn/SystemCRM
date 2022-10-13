using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EComision
    {
        public string i_id { get; set; }
        public string d_fecha { get; set; }
        public string v_mes { get; set; }
        public string i_tipo_comision { get; set; }
        public string v_tipo_comision { get; set; }
        public string i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_color { get; set; }
        public string d_aprobacion_jefe { get; set; }
        public string v_aprobar_jefe { get; set; }
        public string d_aprobacion_rrhh { get; set; }
        public string v_aprobar_rrhh { get; set; }
    }
}