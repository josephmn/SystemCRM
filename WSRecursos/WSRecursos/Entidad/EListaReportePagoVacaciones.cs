using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListaReportePagoVacaciones
    {
        public Int32 row { get; set; }
        public string v_periodo { get; set; }
        public string v_dni { get; set; }
        public string v_nombres { get; set; }
        public string v_area { get; set; }
        public string v_cargo { get; set; }
        public string v_zona { get; set; }
        public string v_banco { get; set; }
        public string v_cta { get; set; }
        public string v_afp { get; set; }
        public Double f_basico { get; set; }
        public Double f_vacaciones { get; set; }
        public string d_finicio { get; set; }
        public string d_ffin { get; set; }
        public Int32 v_total { get; set; }
        public Double f_ingresos { get; set; }
        public Double f_sneto { get; set; }
    }
}