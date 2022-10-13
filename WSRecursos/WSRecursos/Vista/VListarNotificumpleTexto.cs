using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarNotificumpleTexto : BDconexion
    {
        public List<EListarNotificumpleTexto> ListarNotificumpleTexto(Int32 id)
        {
            List<EListarNotificumpleTexto> lCListarNotificumpleTexto = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarNotificumpleTexto oVListarNotificumpleTexto = new CListarNotificumpleTexto();
                    lCListarNotificumpleTexto = oVListarNotificumpleTexto.ListarNotificumpleTexto(con, id);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarNotificumpleTexto);
        }
    }
}