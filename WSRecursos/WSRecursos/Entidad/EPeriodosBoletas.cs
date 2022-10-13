using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EPeriodosBoletas
    {
        public Int32 i_id { get; set; }
        public String v_periodo { get; set; }
        public String v_firma { get; set; }
        public Int32 i_estado { get; set; }
        public String v_estado { get; set; }
        public String v_color_estado { get; set; }
        public String v_lupd_user { get; set; }
        public String d_lupd_date { get; set; }
    }
}