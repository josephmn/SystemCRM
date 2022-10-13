using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarCorreoBuzonsugerencia : BDconexion
    {
        public List<EListarCorreoBuzonsugerencia> ListarCorreoBuzonsugerencia(Int32 post, String dni)
        {
            List<EListarCorreoBuzonsugerencia> lCListarCorreoBuzonsugerencia = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarCorreoBuzonsugerencia oVListarCorreoBuzonsugerencia = new CListarCorreoBuzonsugerencia();
                    lCListarCorreoBuzonsugerencia = oVListarCorreoBuzonsugerencia.ListarCorreoBuzonsugerencia(con, post, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarCorreoBuzonsugerencia);
        }
    }
}