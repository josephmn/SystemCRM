using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndAusentismoxArea : BDconexion
    {
        public List<EIndAusentismoxArea> Listar_IndAusentismoxArea()
        {
            List<EIndAusentismoxArea> lCIndAusentismoxArea = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndAusentismoxArea oVIndAusentismoxArea = new CIndAusentismoxArea();
                    lCIndAusentismoxArea = oVIndAusentismoxArea.Listar_IndAusentismoxArea(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndAusentismoxArea);
        }
    }
}