using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndAusentismorem : BDconexion
    {
        public List<EIndAusentismorem> Listar_IndAusentismorem()
        {
            List<EIndAusentismorem> lCIndAusentismorem = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndAusentismorem oVIndAusentismorem = new CIndAusentismorem();
                    lCIndAusentismorem = oVIndAusentismorem.Listar_IndAusentismorem(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndAusentismorem);
        }
    }
}