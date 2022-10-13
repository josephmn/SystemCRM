using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarDisenioNotificumpleTexto : BDconexion
    {
        public List<EListarDisenioNotificumpleTexto> ListarDisenioNotificumpleTexto(Int32 id)
        {
            List<EListarDisenioNotificumpleTexto> lCListarDisenioNotificumpleTexto = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarDisenioNotificumpleTexto oVListarDisenioNotificumpleTexto = new CListarDisenioNotificumpleTexto();
                    lCListarDisenioNotificumpleTexto = oVListarDisenioNotificumpleTexto.ListarDisenioNotificumpleTexto(con, id);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarDisenioNotificumpleTexto);
        }
    }
}