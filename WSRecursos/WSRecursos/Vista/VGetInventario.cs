using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VGetInventario : BDconexion
    {
        public List<EGetInventario> GetInventario()
        {
            List<EGetInventario> lCGetInventario = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CGetInventario oVGetInventario = new CGetInventario();
                    lCGetInventario = oVGetInventario.GetInventario(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCGetInventario);
        }
    }
}