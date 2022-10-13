using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndAusentismonorem : BDconexion
    {
        public List<EIndAusentismonorem> Listar_IndAusentismonorem()
        {
            List<EIndAusentismonorem> lCIndAusentismonorem = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndAusentismonorem oVIndAusentismonorem = new CIndAusentismonorem();
                    lCIndAusentismonorem = oVIndAusentismonorem.Listar_IndAusentismonorem(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndAusentismonorem);
        }
    }
}