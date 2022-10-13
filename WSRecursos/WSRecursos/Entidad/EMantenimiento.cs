using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EMantenimiento
    {
        public string v_icon { get; set; }
        public string v_title { get; set; }
        public string v_text { get; set; }
        public Int32 i_timer { get; set; }
        public Int32 i_case { get; set; }
        public Boolean v_progressbar { get; set; }
    }
}