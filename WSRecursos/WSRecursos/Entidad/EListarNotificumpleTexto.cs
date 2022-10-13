using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarNotificumpleTexto
    {
        public Int32 i_id { get; set; }
        public Int32 i_notifi { get; set; }
        public String v_texto { get; set; }
        public Int32 i_tamanio { get; set; }
        public String v_color { get; set; }
        public Int32 i_angulo { get; set; }
        public Int32 i_posicionx { get; set; }
        public Int32 i_posiciony { get; set; }
        public String i_alineacion { get; set; }
        public String v_fuente { get; set; }
    }
}