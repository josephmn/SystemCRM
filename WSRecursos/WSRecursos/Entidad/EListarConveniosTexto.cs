using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarConveniosTexto
    {
        public Int32 i_id { get; set; }
        public Int32 i_convenio { get; set; }
        public String v_texto { get; set; }
        public Int32 i_tamanio { get; set; }
        public String v_color { get; set; }
        public Int32 i_angulo { get; set; }
        public Int32 i_posicionx { get; set; }
        public Int32 i_posiciony { get; set; }
    }
}