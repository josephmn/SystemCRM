using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VConPerfilesAccesos : BDconexion
    {
        public List<EConPerfilesAccesos> ConPerfilesAccesos(Int32 post, Int32 perfil, Int32 menu)
        {
            List<EConPerfilesAccesos> lCConPerfilesAccesos = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CConPerfilesAccesos oVConPerfilesAccesos = new CConPerfilesAccesos();
                    lCConPerfilesAccesos = oVConPerfilesAccesos.ConPerfilesAccesos(con, post, perfil, menu);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCConPerfilesAccesos);
        }
    }
}