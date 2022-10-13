using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarCorreoBuzonsugerencia
    {
        public string i_id { get; set; }
        public string v_ticket { get; set; }
        public string v_nombre { get; set; }
        public string v_para { get; set; }
        public string v_copia { get; set; }
        public Int32 i_asunto { get; set; }
        public string v_asunto { get; set; }
        public string v_mensaje { get; set; }
        public string v_estado { get; set; }
        public string v_color { get; set; }
        public string d_fecha { get; set; }
    }
}