using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EConPerfilesAccesos
    {
        public Int32 i_perfil { get; set; }
        public Int32 i_menu { get; set; }
        public Int32 i_submenu { get; set; }
        public string v_menu { get; set; }
        public string v_submenu { get; set; }
        public string v_default { get; set; }
    }
}