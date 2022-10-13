using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarPaNotificaciones : BDconexion
    {
        public List<EListarPaNotificaciones> ListarPaNotificaciones(Int32 post, Int32 top, String dni)
        {
            List<EListarPaNotificaciones> lCListarPaNotificaciones = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarPaNotificaciones oVListarPaNotificaciones = new CListarPaNotificaciones();
                    lCListarPaNotificaciones = oVListarPaNotificaciones.ListarPaNotificaciones(con, post, top, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarPaNotificaciones);
        }
    }
}