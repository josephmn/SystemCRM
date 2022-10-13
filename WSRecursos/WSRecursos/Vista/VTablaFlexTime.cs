using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VTablaFlexTime : BDconexion
    {
        public List<ETablaFlexTime> TablaFlexTime(Int32 post, String user, Int32 anhio, Int32 mes)
        {
            List<ETablaFlexTime> lCTablaFlexTime = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CTablaFlexTime oVTablaFlexTime = new CTablaFlexTime();
                    lCTablaFlexTime = oVTablaFlexTime.TablaFlexTime(con, post, user, anhio, mes);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCTablaFlexTime);
        }
    }
}