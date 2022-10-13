using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VBoletapago : BDconexion
    {
        public List<EBoletapago> Listar_Boletapago(String dni)
        {
            List<EBoletapago> lCBoletapago = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CBoletapago oVBoletapago = new CBoletapago();
                    lCBoletapago = oVBoletapago.Listar_Boletapago(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCBoletapago);
        }
    }
}