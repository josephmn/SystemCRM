using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarNotificaciones : BDconexion
    {
        public List<EListarNotificaciones> ListarNotificaciones(Int32 post, Int32 id)
        {
            List<EListarNotificaciones> lCListarNotificaciones = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarNotificaciones oVListarNotificaciones = new CListarNotificaciones();
                    lCListarNotificaciones = oVListarNotificaciones.ListarNotificaciones(con, post, id);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarNotificaciones);
        }
    }
}