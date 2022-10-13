using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarvacacionesxdni
    {
        public Int32 i_id { get; set; }
        public Int32 i_mes { get; set; }
        public string v_mes { get; set; }
        public string d_finicio { get; set; }
        public string d_ffin { get; set; }
        public Int32 i_dias { get; set; }
        public string v_tipo { get; set; }
        public string v_color_tipo { get; set; }
        public Int32 i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_color { get; set; }
        public string d_fregistro { get; set; }
        public string d_faprobacion { get; set; }
    }
}