using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarBuzonsugerencia : BDconexion
    {
        public List<EListarBuzonsugerencia> ListarBuzonsugerencia(Int32 post)
        {
            List<EListarBuzonsugerencia> lCListarBuzonsugerencia = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarBuzonsugerencia oVListarBuzonsugerencia = new CListarBuzonsugerencia();
                    lCListarBuzonsugerencia = oVListarBuzonsugerencia.ListarBuzonsugerencia(con, post);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarBuzonsugerencia);
        }
    }
}