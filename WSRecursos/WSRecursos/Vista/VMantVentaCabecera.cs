using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantVentaCabecera : BDconexion
    {
        public List<EMantenimiento> MantVentaCabecera(Int32 post, Int32 id, String ticket, String para, String copia, String asunto, String subtotal, String igv, String total, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantVentaCabecera oVMantVentaCabecera = new CMantVentaCabecera();
                    lCEMantenimiento = oVMantVentaCabecera.MantVentaCabecera(con, post, id, ticket, para, copia, asunto, subtotal, igv, total, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}