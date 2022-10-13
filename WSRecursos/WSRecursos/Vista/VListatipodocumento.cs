using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListatipodocumento : BDconexion
    {
        public List<EListatipodocumento> Listar_Listatipodocumento(Int32 id)
        {
            List<EListatipodocumento> lCListatipodocumento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListatipodocumento oVListatipodocumento = new CListatipodocumento();
                    lCListatipodocumento = oVListatipodocumento.Listar_Listatipodocumento(con, id);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListatipodocumento);
        }
    }
}