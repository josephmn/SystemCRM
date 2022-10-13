using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantLogCorreosBuzonsugerencia : BDconexion
    {
        public List<EMantenimiento> MantLogCorreosBuzonsugerencia(
            Int32 post,
            String ticket,
            String para,
            String copia,
            Int32 asunto,
            String desc_asunto,
            String mensaje,
            Int32 output,
            String ruta,
            String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantLogCorreosBuzonsugerencia oVMantLogCorreosBuzonsugerencia = new CMantLogCorreosBuzonsugerencia();
                    lCEMantenimiento = oVMantLogCorreosBuzonsugerencia.MantLogCorreosBuzonsugerencia(con, post, ticket, para, copia, asunto, desc_asunto, mensaje, output, ruta, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}