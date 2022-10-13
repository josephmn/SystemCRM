using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarFlexTime : BDconexion
    {
        public List<EListarFlexTime> ListarFlexTime(Int32 id, Int32 idflex, Int32 zona, Int32 local)
        {
            List<EListarFlexTime> lCListarFlexTime = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarFlexTime oVListarFlexTime = new CListarFlexTime();
                    lCListarFlexTime = oVListarFlexTime.ListarFlexTime(con, id, idflex, zona, local);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarFlexTime);
        }
    }
}