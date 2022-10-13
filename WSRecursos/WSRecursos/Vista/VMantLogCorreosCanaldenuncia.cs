using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantLogCorreosCanaldenuncia : BDconexion
    {
        public List<EMantenimiento> MantLogCorreosCanaldenuncia(
            Int32 post,
            String ticket,
            String para,
            String copia,
            Int32 anonimo,
            String asunto,
            String archivo,
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
                    CMantLogCorreosCanaldenuncia oVMantLogCorreosCanaldenuncia = new CMantLogCorreosCanaldenuncia();
                    lCEMantenimiento = oVMantLogCorreosCanaldenuncia.MantLogCorreosCanaldenuncia(con, post, ticket, para, copia, anonimo, asunto, archivo, mensaje, output, ruta, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}