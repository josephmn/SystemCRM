using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarNotificumpleanios : BDconexion
    {
        public List<EListarNotificumpleanios> ListarNotificumpleanios(Int32 post, Int32 id)
        {
            List<EListarNotificumpleanios> lCListarNotificumpleanios = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarNotificumpleanios oVListarNotificumpleanios = new CListarNotificumpleanios();
                    lCListarNotificumpleanios = oVListarNotificumpleanios.ListarNotificumpleanios(con, post, id);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarNotificumpleanios);
        }
    }
}