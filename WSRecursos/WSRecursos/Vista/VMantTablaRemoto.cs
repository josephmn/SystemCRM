using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantTablaRemoto : BDconexion
    {
        public List<EMantenimiento> MantTablaRemoto(
            Int32 post,
            Int32 id,
            Int32 semana,
            Int32 zona,
            Int32 local,
            String user
            )
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantTablaRemoto oVMantTablaRemoto = new CMantTablaRemoto();
                    lCEMantenimiento = oVMantTablaRemoto.MantTablaRemoto(con, post, id, semana, zona, local, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}