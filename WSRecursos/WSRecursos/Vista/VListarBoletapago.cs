using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarBoletapago : BDconexion
    {
        public List<EListarBoletapago> Listar_ListarBoletapago(String periodo)
        {
            List<EListarBoletapago> lCListarBoletapago = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarBoletapago oVListarBoletapago = new CListarBoletapago();
                    lCListarBoletapago = oVListarBoletapago.Listar_ListarBoletapago(con, periodo);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarBoletapago);
        }
    }
}