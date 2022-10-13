using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class ECombodocumentos
    {
        public Int32 i_id { get; set; }
        public string v_nombre { get; set; }
        public string v_carpeta { get; set; }
        public string v_modulo { get; set; }
        public Int32 i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_color_estado { get; set; }
        public string v_type_archivo { get; set; }
        public string i_cantidad { get; set; }
        public string v_cantidad { get; set; }
        public string v_color_cantidad { get; set; }
        public double f_size { get; set; }
        public string d_fecha_actualiza { get; set; }

    }
}