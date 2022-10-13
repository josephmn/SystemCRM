using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EListarNotificaciones
    {
        public Int32 i_id { get; set; }
        public string v_class { get; set; }
        public string v_title { get; set; }
        public string v_subtitle { get; set; }
        public string v_body { get; set; }
        public string v_description { get; set; }
        public Int32 i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_estado_color { get; set; }
        public string v_crtd_user { get; set; }
        public string d_creacion { get; set; }
        public string v_lupd_user { get; set; }
        public string d_actualizacion { get; set; }
        public string v_link { get; set; }
    }
}