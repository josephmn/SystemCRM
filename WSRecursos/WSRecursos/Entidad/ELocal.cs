using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class ELocal
    {
        public string i_codigo { get; set; }
        public string v_descripcion { get; set; }
        public string v_hora_inicio { get; set; }
        public string v_hora_fin { get; set; }
        public string v_tolerancia { get; set; }
        public string i_tipo_asistencia { get; set; }
        public string v_tipo_asistencia { get; set; }
        public string i_zona { get; set; }
        public string v_zona { get; set; }
        public string i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_color_estado { get; set; }
        public string v_abreviatura { get; set; }
    }
}