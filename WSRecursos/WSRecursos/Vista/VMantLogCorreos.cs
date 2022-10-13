using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantLogCorreos : BDconexion
    {
        public List<EMantenimiento> MantLogCorreos(Int32 post, String ticket, String para, String copia, String asunto, String mensaje, Int32 output, String ruta, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantLogCorreos oVMantLogCorreos = new CMantLogCorreos();
                    lCEMantenimiento = oVMantLogCorreos.MantLogCorreos(con, post, ticket, para, copia, asunto, mensaje, output, ruta, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}