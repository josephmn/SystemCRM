using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantControlRemoto : BDconexion
    {
        public List<EMantenimiento> MantControlRemoto(
            Int32 post,
            Int32 id,
            String user
            )
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantControlRemoto oVMantControlRemoto = new CMantControlRemoto();
                    lCEMantenimiento = oVMantControlRemoto.MantControlRemoto(con, post, id, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}