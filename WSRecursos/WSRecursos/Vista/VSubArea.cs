using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VSubArea : BDconexion
    {
        public List<ESubArea> SubArea(Int32 post, String area)
        {
            List<ESubArea> lCSubArea = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CSubArea oVSubArea = new CSubArea();
                    lCSubArea = oVSubArea.Listar_SubArea(con, post, area);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCSubArea);
        }
    }
}