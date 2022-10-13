using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EAsistencia
    {
        public string CODIGO { get; set; }
        public string DNI { get; set; }
        public string NOMBRE { get; set; }
        public string AREA { get; set; }
        public string CARGO { get; set; }
        public string ZONA { get; set; }
        public string TIPO_ASISTENCIA { get; set; }
        public string DIA { get; set; }
        public string FECHA { get; set; }
        public string ENTRADA { get; set; }
        public string INI_REF { get; set; }
        public string TER_REF { get; set; }
        public string SALIDA { get; set; }
        public string COMENTARIO { get; set; }
        public string ASISTENCIA { get; set; }
        public string REFRIGERIO { get; set; }
        public string ASISTENCIA_COLOR { get; set; }
        public string REFRIGERIO_COLOR { get; set; }
        public string TEMP_ENT { get; set; }
        public string TEMP_SAL { get; set; }
    }
}