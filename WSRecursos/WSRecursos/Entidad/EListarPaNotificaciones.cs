using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarPaNotificaciones
    {
        public Int32 i_id { get; set; }
        public string v_class { get; set; }
        public string v_title { get; set; }
        public string v_subtitle { get; set; }
        public string v_body { get; set; }
        public string v_description { get; set; }
        public Boolean i_autohide { get; set; }
        public Int32 i_delay { get; set; }
        public Int32 i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_estado_color { get; set; }
        public string d_crtd_date { get; set; }
        public string v_link { get; set; }
    }
}