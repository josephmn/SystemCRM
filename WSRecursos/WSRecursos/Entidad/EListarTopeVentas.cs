using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarTopeVentas
    {
        public string cliente { get; set; }
        public string periodo { get; set; }
        public string total { get; set; }
        public string tope_venta { get; set; }
    }
}