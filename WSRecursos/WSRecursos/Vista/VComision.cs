using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VComision : BDconexion
    {
        public List<EComision> Listar_Comision(Int32 post, String dni)
        {
            List<EComision> lCComision = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CComision oVComision = new CComision();
                    lCComision = oVComision.Listar_Comision(con, post, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCComision);
        }
    }
}