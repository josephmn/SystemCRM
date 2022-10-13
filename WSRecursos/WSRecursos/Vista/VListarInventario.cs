using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarInventario : BDconexion
    {
        public List<EListarInventario> ListarInventario(Int32 post, String sku)
        {
            List<EListarInventario> lCListarInventario = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarInventario oVListarInventario = new CListarInventario();
                    lCListarInventario = oVListarInventario.ListarInventario(con, post, sku);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarInventario);
        }
    }
}