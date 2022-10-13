using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EIndAusentismoxArea
    {
        public string v_descripcion { get; set; }
        public string a_remunerado_dia { get; set; }
        public string b_no_remunerado_dia { get; set; }
        public string c_remunerado_persona { get; set; }
        public string d_no_remunerado_persona { get; set; }
        public string e_dotacion { get; set; }
        public string f_porc_remunerado { get; set; }
        public string g_porc_no_remunerado { get; set; }
    }
}