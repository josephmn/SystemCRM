using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarTipoArchivos
    {
        public Int32 i_id { get; set; }
        public string v_archivo { get; set; }
        public string v_mime { get; set; }
        public string v_type { get; set; }
        public string v_icono { get; set; }
        public string v_color { get; set; }
        public string d_creacion { get; set; }
        public string d_actualizacion { get; set; }
    }
}