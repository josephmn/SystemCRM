using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VCombodocumentos : BDconexion
    {
        public List<ECombodocumentos> Listar_Combodocumentos(Int32 post, Int32 id, String dni)
        {
            List<ECombodocumentos> lCCombodocumentos = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CCombodocumentos oVCombodocumentos = new CCombodocumentos();
                    lCCombodocumentos = oVCombodocumentos.Listar_Combodocumentos(con, post, id, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCCombodocumentos);
        }
    }
}