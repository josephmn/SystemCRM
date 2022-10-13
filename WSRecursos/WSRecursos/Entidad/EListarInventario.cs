using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarInventario
    {
        public Int32 i_id { get; set; }
        public string v_sku { get; set; }
        public string v_descripcion { get; set; }
        public string v_marca { get; set; }
        public double f_precio { get; set; }
        public Int32 i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_color_estado { get; set; }
        public string d_fregistro { get; set; }
        public string d_factualiza { get; set; }
    }
}