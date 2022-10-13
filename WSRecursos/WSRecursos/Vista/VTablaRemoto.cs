using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VTablaRemoto : BDconexion
    {
        public List<ETablaRemoto> TablaRemoto(Int32 post, String user, Int32 anhio)
        {
            List<ETablaRemoto> lCTablaRemoto = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CTablaRemoto oVTablaRemoto = new CTablaRemoto();
                    lCTablaRemoto = oVTablaRemoto.TablaRemoto(con, post, user, anhio);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCTablaRemoto);
        }
    }
}