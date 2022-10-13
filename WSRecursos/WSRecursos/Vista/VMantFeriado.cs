using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantFeriado : BDconexion
    {
        public List<EMantenimiento> MantFeriado(
            Int32 post,
            Int32 id,
            String descripcion,
            String fferiado,
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
                    CMantFeriado oVMantFeriado = new CMantFeriado();
                    lCEMantenimiento = oVMantFeriado.MantFeriado(con, post, id, descripcion, fferiado, estado, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}