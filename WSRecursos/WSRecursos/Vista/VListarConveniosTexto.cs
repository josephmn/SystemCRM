using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarConveniosTexto : BDconexion
    {
        public List<EListarConveniosTexto> ListarConveniosTexto(Int32 id)
        {
            List<EListarConveniosTexto> lCListarConveniosTexto = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarConveniosTexto oVListarConveniosTexto = new CListarConveniosTexto();
                    lCListarConveniosTexto = oVListarConveniosTexto.ListarConveniosTexto(con, id);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarConveniosTexto);
        }
    }
}