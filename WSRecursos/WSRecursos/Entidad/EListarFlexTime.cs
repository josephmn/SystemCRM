using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarFlexTime
    {
        public Int32 i_id { get; set; }
        public string v_nombre { get; set; }
        public string v_hora_inicio { get; set; }
        public string v_hora_fin { get; set; }
        public string v_tolerancia { get; set; }
        public Int32 i_zona { get; set; }
        public string v_zona { get; set; }
        public Int32 i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_color_estado { get; set; }
        public Int32 i_local { get; set; }
        public string v_local { get; set; }
    }
}