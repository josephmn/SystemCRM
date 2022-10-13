using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VPersonal : BDconexion
    {
        public List<EPersonal> Listar_Personal(Int32 post, string dni, Int32 local)
        {
            List<EPersonal> lCPersonal = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CPersonal oVPersonal = new CPersonal();
                    lCPersonal = oVPersonal.Listar_Personal(con, post, dni, local);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCPersonal);
        }
    }
}