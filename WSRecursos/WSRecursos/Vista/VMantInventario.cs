using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantInventario : BDconexion
    {
        public List<EMantenimiento> MantInventario(
            Int32 post,
            String sku,
            Int32 estado,
            String user
            )
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantInventario oVMantInventario = new CMantInventario();
                    lCEMantenimiento = oVMantInventario.MantInventario(con, post, sku, estado, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}