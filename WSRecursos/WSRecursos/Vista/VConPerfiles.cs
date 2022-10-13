using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VConPerfiles : BDconexion
    {
        public List<EConPerfiles> ConPerfiles(Int32 post, Int32 perfil)
        {
            List<EConPerfiles> lCConPerfiles = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CConPerfiles oVConPerfiles = new CConPerfiles();
                    lCConPerfiles = oVConPerfiles.ConPerfiles(con, post, perfil);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCConPerfiles);
        }
    }
}