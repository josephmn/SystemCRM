using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EConfiguracionCorreo
    {
        public String v_correo_salida { get; set; }
        public String v_password { get; set; }
        public String v_nombre_salida { get; set; }
        public String v_servidor_entrante { get; set; }
        public Int32 i_puerto { get; set; }
    }
}